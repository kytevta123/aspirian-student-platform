<?php

namespace App\Services;

use Illuminate\Support\Collection;

class RevisionQueueService
{
    public const MAX_ITEMS = 10;

    public function __construct(
        protected WeakTopicDetectionService $weakTopicDetectionService
    ) {
    }

    /**
     * Build a revision queue for the given student.
     */
    public function buildForUser(int $userId): Collection
    {
        return $this->weakTopicDetectionService
            ->weakTopicsForUser($userId)
            ->take(self::MAX_ITEMS)
            ->values()
            ->map(function (array $topic, int $index): array {
                $topic['queue_position'] = $index + 1;
                $topic['priority'] = $this->getPriority(
                    (float) $topic['percentage']
                );
                $topic['recommendation'] = $this->getRecommendation(
                    (float) $topic['percentage'],
                    (int) $topic['wrong_answers'],
                    (int) $topic['unanswered']
                );

                return $topic;
            });
    }

    /**
     * Determine revision priority from topic performance.
     */
    protected function getPriority(float $percentage): string
    {
        if ($percentage < 20) {
            return 'High';
        }

        if ($percentage < 40) {
            return 'Medium';
        }

        return 'Low';
    }

    /**
     * Provide a useful revision recommendation.
     */
    protected function getRecommendation(
        float $percentage,
        int $wrongAnswers,
        int $unanswered
    ): string {
        if ($percentage < 20) {
            return 'Revise this topic first and practice more questions.';
        }

        if ($unanswered > $wrongAnswers) {
            return 'Review the topic and attempt more questions without skipping.';
        }

        if ($wrongAnswers > 0) {
            return 'Review the topic and practice the questions you answered incorrectly.';
        }

        return 'Review this topic and continue practicing.';
    }
}