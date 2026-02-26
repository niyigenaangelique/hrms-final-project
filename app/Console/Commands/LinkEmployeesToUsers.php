<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class LinkEmployeesToUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:link-employees-to-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Link existing employee records to their corresponding user accounts';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Linking employees to users...');
        
        $users = \App\Models\User::all();
        $linkedCount = 0;
        
        foreach ($users as $user) {
            $employee = \App\Models\Employee::where('email', $user->email)->first();
            if ($employee && !$employee->user_id) {
                $employee->update(['user_id' => $user->id]);
                $this->info("Linked employee {$employee->id} to user {$user->id} ({$user->email})");
                $linkedCount++;
            }
        }
        
        $this->info("Done! Linked {$linkedCount} employees to their user accounts.");
        
        return 0;
    }
}
