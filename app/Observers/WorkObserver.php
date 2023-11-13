<?php

namespace App\Observers;

use App\Models\Work;
use App\Notifications\PayoutNotification;

class WorkObserver
{
    public function created(Work $work)
    {
        $work->notify(new PayoutNotification($work));
    }
}
