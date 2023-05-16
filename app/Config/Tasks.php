<?php

namespace Config;

use CodeIgniter\Tasks\Scheduler;

class Tasks
{
    public function handle(Scheduler $schedule)
    {
        $schedule->call('tasks:deleteoldsessions')->every('hour');
    }
}
