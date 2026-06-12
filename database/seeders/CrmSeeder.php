<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Contact;
use App\Models\Lead;
use App\Models\Opportunity;
use Illuminate\Database\Seeder;

class CrmSeeder extends Seeder
{
    public function run(): void
    {
        $accounts = [
            [
                'name' => 'Blue Ridge Logistics',
                'industry' => 'Transportation',
                'website' => 'https://example.com',
                'phone' => '540-555-1000',
                'email' => 'info@blueridgelogistics.test',
                'description' => 'Regional logistics company needing CRM modernization.',
            ],
            [
                'name' => 'Star City Health Group',
                'industry' => 'Healthcare',
                'website' => 'https://example.com',
                'phone' => '540-555-2000',
                'email' => 'contact@starcityhealth.test',
                'description' => 'Healthcare organization evaluating patient engagement tools.',
            ],
            [
                'name' => 'Roanoke Tech Partners',
                'industry' => 'Technology',
                'website' => 'https://example.com',
                'phone' => '540-555-3000',
                'email' => 'hello@roanoketech.test',
                'description' => 'Technology consulting company interested in automation.',
            ],
        ];

        foreach ($accounts as $accountData) {
            $account = Account::create($accountData);

            Contact::create([
                'account_id' => $account->id,
                'first_name' => fake()->firstName(),
                'last_name' => fake()->lastName(),
                'title' => 'Director of Operations',
                'email' => fake()->safeEmail(),
                'phone' => fake()->phoneNumber(),
                'mobile' => fake()->phoneNumber(),
                'department' => 'Operations',
                'notes' => 'Primary decision maker.',
            ]);

            Contact::create([
                'account_id' => $account->id,
                'first_name' => fake()->firstName(),
                'last_name' => fake()->lastName(),
                'title' => 'Finance Manager',
                'email' => fake()->safeEmail(),
                'phone' => fake()->phoneNumber(),
                'mobile' => fake()->phoneNumber(),
                'department' => 'Finance',
                'notes' => 'Influences budget approval.',
            ]);
        }

        $stages = [
            'Prospecting',
            'Qualification',
            'Needs Analysis',
            'Proposal',
            'Negotiation',
            'Closed Won',
            'Closed Lost',
        ];

        foreach (Account::all() as $account) {
            foreach ($stages as $index => $stage) {
                Opportunity::create([
                    'account_id' => $account->id,
                    'name' => $stage . ' Deal - ' . $account->name,
                    'amount' => rand(5000, 75000),
                    'stage' => $stage,
                    'probability' => match ($stage) {
                        'Prospecting' => 10,
                        'Qualification' => 25,
                        'Needs Analysis' => 40,
                        'Proposal' => 60,
                        'Negotiation' => 80,
                        'Closed Won' => 100,
                        'Closed Lost' => 0,
                        default => 10,
                    },
                    'close_date' => now()->addDays(rand(10, 120))->toDateString(),
                    'source' => 'Referral',
                    'description' => 'Seeded opportunity for CRM demo.',
                ]);
            }
        }

        $leadStatuses = ['New', 'Working', 'Qualified', 'Unqualified'];

        for ($i = 1; $i <= 15; $i++) {
            Lead::create([
                'company' => fake()->company(),
                'first_name' => fake()->firstName(),
                'last_name' => fake()->lastName(),
                'email' => fake()->safeEmail(),
                'phone' => fake()->phoneNumber(),
                'status' => fake()->randomElement($leadStatuses),
                'source' => fake()->randomElement([
                    'Website',
                    'Referral',
                    'Cold Call',
                    'Email Campaign',
                    'Social Media',
                    'Trade Show',
                    'Other',
                ]),
                'industry' => fake()->randomElement([
                    'Healthcare',
                    'Technology',
                    'Finance',
                    'Education',
                    'Construction',
                    'Retail',
                ]),
                'estimated_value' => rand(2500, 50000),
                'notes' => 'Demo lead generated for CRM testing.',
            ]);
        }
    }
}
