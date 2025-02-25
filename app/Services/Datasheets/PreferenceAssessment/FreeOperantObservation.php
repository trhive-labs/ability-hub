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

    protected function processSessions(): void
    {
        $legend = collect(self::LEGEND)->keyBy('key');

        foreach ($this->data['sessions'] as $session) {
            foreach ($session['answers']['rows'] as [$itemKey, $answerKey]) {
                if (isset($legend[$answerKey]) && isset($this->scores[$itemKey])) {
                    $this->scores[$itemKey] += $legend[$answerKey]['points'];
                }
            }
        }
    }
}
