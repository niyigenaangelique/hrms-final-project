<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Employee;

class CheckEmailDuplicates extends Command
{
    protected $signature = 'emails:check-duplicates';
    protected $description = 'Check for duplicate employee emails';

    public function handle()
    {
        // Check for duplicate emails
        $employees = Employee::all();
        $emailCounts = [];

        $this->info("=== EMAIL DUPLICATE CHECK ===\n");

        foreach ($employees as $emp) {
            $email = strtolower(trim($emp->email ?? ''));
            if ($email) {
                if (!isset($emailCounts[$email])) {
                    $emailCounts[$email] = [];
                }
                $emailCounts[$email][] = [
                    'code' => $emp->code,
                    'id' => $emp->id,
                    'name' => $emp->first_name . ' ' . $emp->last_name,
                    'is_active' => $emp->is_active ?? 'null'
                ];
            }
        }

        // Show duplicates
        $duplicatesFound = false;
        foreach ($emailCounts as $email => $records) {
            if (count($records) > 1) {
                $duplicatesFound = true;
                $this->error("DUPLICATE EMAIL: $email");
                foreach ($records as $record) {
                    $this->line("  - {$record['code']} (ID: {$record['id']}) - {$record['name']} (active: {$record['is_active']})");
                }
                $this->line("");
            }
        }

        if (!$duplicatesFound) {
            $this->info("No duplicate emails found.\n");
        }

        // Check EMP-003 specifically
        $this->info("=== EMP-003 SPECIFIC CHECK ===");
        $emp003 = Employee::where('code', 'EMP-003')->first();
        if ($emp003) {
            $this->info("EMP-003 found:");
            $this->line("  - ID: {$emp003->id}");
            $this->line("  - Email: {$emp003->email}");
            $this->line("  - Name: {$emp003->first_name} {$emp003->last_name}");
            $this->line("  - is_active: " . ($emp003->is_active ?? 'null'));
            $this->line("");

            // Check if anyone else has this email
            $othersWithSameEmail = Employee::where('email', $emp003->email)
                                        ->where('id', '!=', $emp003->id)
                                        ->get();

            if ($othersWithSameEmail->count() > 0) {
                $this->error("OTHER EMPLOYEES WITH SAME EMAIL ({$emp003->email}):");
                foreach ($othersWithSameEmail as $other) {
                    $this->line("  - {$other->code} (ID: {$other->id}) - {$other->first_name} {$other->last_name}");
                }
            } else {
                $this->info("No other employees have this email.");
            }
        } else {
            $this->error("EMP-003 not found!");
        }

        return Command::SUCCESS;
    }
}
