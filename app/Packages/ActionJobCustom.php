<?php

namespace App\Packages;

use Illuminate\Queue\SerializesModels;
use Spatie\QueueableAction\ActionJob;

class ActionJobCustom extends ActionJob
{
    use SerializesModels;

    public function handle()
    {
        if ($this->batching() && $this->batch()->cancelled()) {
            return;
        }

        $action = app($this->actionClass);
        $action->{$action->queueMethod()}(...$this->parameters);
    }
}
