<?php

namespace App\Services\Datasheets\PreferenceAssessment;

abstract class PreferenceAssessmentAbstract
{
    protected array $items;
    protected array $scores;

    public function __construct(
        protected array $data
    )
    {
        $this->items = [];
        $this->scores = [];
        if (array_key_exists('items', $this->data)) {
            $this->items = collect($data['items'])
                ->keyBy('key')
                ->toArray();

            $this->scores = collect($data['items'])
                ->mapWithKeys(
                    fn($item) => [$item['key'] => 0]
                )->toArray();
        }
    }

    abstract protected function processSessions(): void;

    public function report(): array
    {
        if (empty($this->data['items'])) {
            return ['columns' => ['Order', 'Item', 'Points'], 'rows' => []];
        }

        $this->processSessions();

        // Sort and rank
        return $this->generateRankedReport();
    }

    protected function generateRankedReport($highScoresAreLowerRaked = false): array
    {
        $sortedScores =
            collect($this->scores)
                ->{ $this->highScoresAreLowerRaked() ? 'sort' : 'sortDesc' }()
                ->map(
                    fn($points, $key)
                        => [
                            'item' => $this->items[$key]['key'],
                            'points' => $points
                        ]
                )
                ->values();

        $order = 1;
        $lastPoints = null;
        $rankedRows = [];

        foreach ($sortedScores as $index => $entry) {
            if ($lastPoints !== null && $lastPoints != $entry['points']) {
                $order = $index + 1;
            }
            $rankedRows[] = [$order, $entry['item'], $entry['points']];
            $lastPoints = $entry['points'];
        }

        return ['columns' => ['Order', 'Item', 'Points'], 'rows' => $rankedRows];
    }

    public function getReportTemplate(): array
    {
        return [
            'columns' => [
                'Order',
                "Item",
                "Points"
            ],
            "rows" => [
            ]
        ];
    }

    protected function highScoresAreLowerRaked(): bool
    {
        return false;
    }

}
