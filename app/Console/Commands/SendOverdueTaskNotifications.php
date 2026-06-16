<?php

namespace App\Console\Commands;

use App\Models\CrmTask;
use App\Notifications\OverdueTaskNotification;
use Illuminate\Console\Command;

class SendOverdueTaskNotifications extends Command
{
    protected $signature = 'crm:send-overdue-task-notifications';

    protected $description = 'Send notifications for overdue open CRM tasks.';

    public function handle(): int
    {
        $tasks = CrmTask::with('owner')
            ->whereNotNull('user_id')
            ->whereDate('due_date', '<', now()->toDateString())
            ->whereNotIn('status', ['Completed'])
            ->get();

        foreach ($tasks as $task) {
            if ($task->owner) {
                $task->owner->notify(new OverdueTaskNotification($task));
            }
        }

        $this->info("Sent overdue notifications for {$tasks->count()} task(s).");

        return self::SUCCESS;
    }
}
