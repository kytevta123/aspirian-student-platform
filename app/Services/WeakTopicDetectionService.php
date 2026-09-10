<?php

namespace App\Services;

use App\Models\TestAttemptAnswer;
use Illuminate\Support\Collection;

class WeakTopicDetectionService
{
    public const WEAK_THRESHOLD = 40.0;

    /**
     * Get topic-wise performance for a student.
     */
    public function detectForUser(int $userId): Collection
    {
        $answers = TestAttemptAnswer::query()
            ->whereHas('testAttempt', function ($query) use ($userId) {
                $query
                    ->where('user_id', $userId)
                    ->where('status', 'submitted');
            })
            ->with([
                'question.topic',
            ])
            ->get();

        $topics = [];

        foreach ($answers as $answer) {
            $question = $answer->question;
            $topic = $question?->topic;

            if (! $topic) {
                continue;
            }

            $topicId = $topic->id;

            if (! isset($topics[$topicId])) {
                $topics[$topicId] = [
                    'topic_id' => $topicId,
                    'topic_title' => $topic->title,
                    'total_questions' => 0,
                    'correct_answers' => 0,
                    'wrong_answers' => 0,
                    'unanswered' => 0,
                ];
            }

            $topics[$topicId]['total_questions']++;

            if ($this->isUnanswered($answer->answer)) {
                $topics[$topicId]['unanswered']++;

                continue;
            }

            if (
                $this->answersMatch(
                    $answer->answer,
                    $question->answer
                )
            ) {
                $topics[$topicId]['correct_answers']++;

                continue;
            }

            $topics[$topicId]['wrong_answers']++;
        }

        return collect($topics)
            ->map(function (array $topic): array {
                $attempted = $topic['correct_answers']
                    + $topic['wrong_answers'];

                $percentage = $attempted > 0
                    ? round(
                        ($topic['correct_answers'] / $attempted) * 100,
                        2
                    )
                    : 0;

                $topic['attempted_questions'] = $attempted;
                $topic['percentage'] = $percentage;
                $topic['is_weak'] = $percentage < self::WEAK_THRESHOLD;

                return $topic;
            })
            ->sortBy('percentage')
            ->values();
    }

    /**
     * Get only weak topics for a student.
     */
    public function weakTopicsForUser(int $userId): Collection
    {
        return $this->detectForUser($userId)
            ->filter(function (array $topic): bool {
                return $topic['is_weak'];
            })
            ->values();
    }

    protected function isUnanswered(?string $answer): bool
    {
        return $answer === null
            || trim($answer) === '';
    }

    protected function answersMatch(
        string $submittedAnswer,
        ?string $correctAnswer
    ): bool {
        if ($correctAnswer === null) {
            return false;
        }

        return mb_strtolower(
            trim($submittedAnswer)
        ) === mb_strtolower(
            trim($correctAnswer)
        );
    }
}