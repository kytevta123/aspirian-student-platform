<?php

namespace App\Services;

use App\Models\Question;
use Illuminate\Database\Eloquent\Collection;

class QuestionDuplicateDetector
{
    public function normalize(string $text): string
    {
        $text = trim($text);

        if ($text === '') {
            return '';
        }

        $text = html_entity_decode(
            $text,
            ENT_QUOTES | ENT_HTML5,
            'UTF-8'
        );

        $text = strip_tags($text);

        /*
         * Normalize Unicode characters first so that
         * duplicate detection behaves consistently.
         */
        if (class_exists(\Normalizer::class)) {
            $normalized = \Normalizer::normalize(
                $text,
                \Normalizer::FORM_C
            );

            if ($normalized !== false) {
                $text = $normalized;
            }
        }

        /*
         * Convert all whitespace sequences into one space.
         */
        $text = preg_replace(
            '/\s+/u',
            ' ',
            $text
        ) ?? $text;

        /*
         * Remove punctuation so that:
         *
         * What is a computer?
         * What is a computer!
         * What is a computer.
         *
         * are treated as the same question.
         */
        $text = preg_replace(
            '/[[:punct:]]+/u',
            ' ',
            $text
        ) ?? $text;

        /*
         * Remove any extra spaces created after
         * punctuation removal.
         */
        $text = preg_replace(
            '/\s+/u',
            ' ',
            $text
        ) ?? $text;

        return mb_strtolower(
            trim($text),
            'UTF-8'
        );
    }

    public function findExact(
        string $questionText,
        ?int $excludeQuestionId = null
    ): ?Question {
        $normalizedText = $this->normalize(
            $questionText
        );

        if ($normalizedText === '') {
            return null;
        }

        $query = Question::query()
            ->where(
                'normalized_text',
                $normalizedText
            );

        if ($excludeQuestionId !== null) {
            $query->where(
                'id',
                '!=',
                $excludeQuestionId
            );
        }

        return $query
            ->latest('id')
            ->first();
    }

    public function findSimilar(
        string $questionText,
        float $threshold = 0.80,
        ?int $excludeQuestionId = null
    ): Collection {
        $normalizedText = $this->normalize(
            $questionText
        );

        if ($normalizedText === '') {
            return new Collection();
        }

        $threshold = max(
            0.0,
            min(
                1.0,
                $threshold
            )
        );

        $query = Question::query()
            ->whereNotNull('normalized_text');

        if ($excludeQuestionId !== null) {
            $query->where(
                'id',
                '!=',
                $excludeQuestionId
            );
        }

        $questions = $query->get();

        $similarQuestions = new Collection();

        foreach ($questions as $question) {
            $candidateText = $question->normalized_text;

            if (
                ! is_string($candidateText)
                || trim($candidateText) === ''
            ) {
                continue;
            }

            $similarity = $this->similarity(
                $normalizedText,
                $candidateText
            );

            if ($similarity < $threshold) {
                continue;
            }

            $question->setAttribute(
                'similarity_score',
                round(
                    $similarity,
                    4
                )
            );

            $similarQuestions->push(
                $question
            );
        }

        return $similarQuestions
            ->sortByDesc(
                fn (Question $question) =>
                    (float) $question->similarity_score
            )
            ->values();
    }

    /**
     * Calculate similarity between two question texts.
     *
     * This method is public because it is also part of
     * the duplicate detection service's testable API.
     */
    public function similarity(
        string $first,
        string $second
    ): float {
        $first = $this->normalize($first);
        $second = $this->normalize($second);

        if ($first === $second) {
            return 1.0;
        }

        if ($first === '' || $second === '') {
            return 0.0;
        }

        similar_text(
            $first,
            $second,
            $percent
        );

        $similarTextScore = $percent / 100;

        $levenshteinScore = $this->levenshteinSimilarity(
            $first,
            $second
        );

        return max(
            $similarTextScore,
            $levenshteinScore
        );
    }

    protected function levenshteinSimilarity(
        string $first,
        string $second
    ): float {
        $firstLength = strlen($first);
        $secondLength = strlen($second);

        $maxLength = max(
            $firstLength,
            $secondLength
        );

        if ($maxLength === 0) {
            return 1.0;
        }

        /*
         * PHP's native levenshtein() has a practical
         * limitation for very long strings.
         *
         * For long questions, similar_text() is already
         * available as the primary similarity calculation.
         */
        if (
            $firstLength > 255
            || $secondLength > 255
        ) {
            return 0.0;
        }

        $distance = levenshtein(
            $first,
            $second
        );

        return max(
            0.0,
            1 - (
                $distance / $maxLength
            )
        );
    }
}