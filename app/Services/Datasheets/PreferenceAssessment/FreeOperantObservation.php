<?php

namespace App\Services\Datasheets\PreferenceAssessment;

class FreeOperantObservation extends PreferenceAssessmentAbstract
{
    const LEGEND = [
        [
            "key" => "A",
            "value" => "Approached",
            "points" => 1,
        ],
        [
            "key" => "DNA",
            "value" => "Did Not Approached",
            "points" => 0
        ],
        [
            "key" => "EW",
            "value" => "Engaged With",
            "points" => 2,
        ],
    ];
    function report(): array
    {
        $items = collect($this->data['items'])->keyBy('key');
        $legend = collect(self::LEGEND)->keyBy('key');

        // Initialize item scores
        $scores = collect($this->data['items'])->mapWithKeys(fn($item) => [$item['key'] => 0]);

        // Process sessions
        foreach ($this->data['sessions'] as $session) {
            foreach ($session['answers']['rows'] as [$itemKey, $answerKey]) {
                if (isset($legend[$answerKey]) && isset($scores[$itemKey])) {
                    $scores[$itemKey] += $legend[$answerKey]['points'];
                }
            }
        }

        // Sort results by points descending, then by item name ascending
        $sortedScores = $scores->sortDesc()->map(function ($points, $key) use ($items) {
            return ['item' => $items[$key]['key'], 'points' => $points];
        })->values();

        // Assign order based on ranking logic
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

        return [
            'columns' => ['Order', 'Item', 'Points'],
            'rows' => $rankedRows,
        ];
    }
}
