<?php

namespace App\Actions\Learners;

use App\Models\Learner;

class UpdateLearnerAction
{
    public function execute(Learner $learner, array $updateAttributes): Learner
    {
        $learner->fill($updateAttributes);
        $learner->save();

        return $learner;
    }
}
