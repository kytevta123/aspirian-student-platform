<?php

namespace App\Services;

use App\Models\TestAttempt;
use App\Models\TestResult;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class TestResultService
{
    /**
     * Calculate and create the result for a submitted test attempt.
     *
     * The calculation is performed entirely on the server.
     */
    public function calculate(TestAttempt $attempt): TestResult
    {
        if (! $attempt->isSubmitted()) {
            throw new RuntimeException(
                'Only submitted test attempts can be calculated.'
            );
        }

        $existingResult = $attempt->result;

        if ($existingResult) {
            return $existingResult;
        }

        return DB::transaction(function () use ($attempt): TestResult {
            $attempt->load([
                'test.questions',
                'answers',
            ]);

            $totalMarks = 0;
            $obtainedMarks = 0;
            $correctAnswers = 0;
            $wrongAnswers = 0;
            $unanswered = 0;

            $answersByQuestion = $attempt->answers
                ->keyBy('question_id');

            foreach ($attempt->test->questions as $question) {
                $questionMarks = (int) (
                    $question->pivot->marks
                    ?? $question->marks
                    ?? 0
                );

                $totalMarks += $questionMarks;

                $attemptAnswer = $answersByQuestion->get(
                    $question->id
                );

                if (
                    ! $attemptAnswer ||
                    $this->isUnanswered($attemptAnswer->answer)
                ) {
                    $unanswered++;

                    continue;
                }

                if (
                    $this->answersMatch(
                        $attemptAnswer->answer,
                        $question->answer
                    )
                ) {
                    $correctAnswers++;

                    $obtainedMarks += $questionMarks;
                } else {
                    $wrongAnswers++;
                }
            }

            $percentage = $totalMarks > 0
                ? round(
                    ($obtainedMarks / $totalMarks) * 100,
                    2
                )
                : 0;

            $status = $this->determineStatus(
                $percentage
            );

            return TestResult::create([
                'test_attempt_id' => $attempt->id,
                'test_id' => $attempt->test_id,
                'user_id' => $attempt->user_id,
                'total_marks' => $totalMarks,
                'obtained_marks' => $obtainedMarks,
                'percentage' => $percentage,
                'correct_answers' => $correctAnswers,
                'wrong_answers' => $wrongAnswers,
                'unanswered' => $unanswered,
                'status' => $status,
            ]);
        });
    }

    /**
     * Determine whether an answer should be treated as unanswered.
     */
    protected function isUnanswered(?string $answer): bool
    {
        return $answer === null
            || trim($answer) === '';
    }

    /**
     * Compare a submitted answer with the question's correct answer.
     *
     * Comparison is normalized to avoid false negatives caused by
     * capitalization or accidental surrounding whitespace.
     */
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

    /**
     * Determine pass/fail status.
     *
     * Current default passing percentage is 40%.
     */
    protected function determineStatus(
        float $percentage
    ): string {
        return $percentage >= 40
            ? TestResult::STATUS_PASSED
            : TestResult::STATUS_FAILED;
    }
}