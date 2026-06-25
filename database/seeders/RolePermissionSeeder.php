<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            [
                'name' => 'Administrator',
                'slug' => 'admin',
                'description' => 'Full system access.',
            ],
            [
                'name' => 'Sales Manager',
                'slug' => 'sales-manager',
                'description' => 'Manages sales team, accounts, leads, contacts, and reports.',
            ],
            [
                'name' => 'Sales Representative',
                'slug' => 'sales-rep',
                'description' => 'Works assigned leads, contacts, accounts, and opportunities.',
            ],
            [
                'name' => 'Marketing User',
                'slug' => 'marketing-user',
                'description' => 'Manages campaigns and lead generation.',
            ],
            [
                'name' => 'Support User',
                'slug' => 'support-user',
                'description' => 'Manages cases and customer support records.',
            ],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(
                ['slug' => $role['slug']],
                $role
            );
        }

        $permissions = [
            ['name' => 'View Dashboard', 'slug' => 'dashboard.view', 'module' => 'Dashboard'],

            ['name' => 'View Leads', 'slug' => 'leads.view', 'module' => 'Leads'],
            ['name' => 'Create Leads', 'slug' => 'leads.create', 'module' => 'Leads'],
            ['name' => 'Edit Leads', 'slug' => 'leads.edit', 'module' => 'Leads'],
            ['name' => 'Delete Leads', 'slug' => 'leads.delete', 'module' => 'Leads'],

            ['name' => 'View Contacts', 'slug' => 'contacts.view', 'module' => 'Contacts'],
            ['name' => 'Create Contacts', 'slug' => 'contacts.create', 'module' => 'Contacts'],
            ['name' => 'Edit Contacts', 'slug' => 'contacts.edit', 'module' => 'Contacts'],
            ['name' => 'Delete Contacts', 'slug' => 'contacts.delete', 'module' => 'Contacts'],

            ['name' => 'View Accounts', 'slug' => 'accounts.view', 'module' => 'Accounts'],
            ['name' => 'Create Accounts', 'slug' => 'accounts.create', 'module' => 'Accounts'],
            ['name' => 'Edit Accounts', 'slug' => 'accounts.edit', 'module' => 'Accounts'],
            ['name' => 'Delete Accounts', 'slug' => 'accounts.delete', 'module' => 'Accounts'],

            ['name' => 'View Opportunities', 'slug' => 'opportunities.view', 'module' => 'Opportunities'],
            ['name' => 'Create Opportunities', 'slug' => 'opportunities.create', 'module' => 'Opportunities'],
            ['name' => 'Edit Opportunities', 'slug' => 'opportunities.edit', 'module' => 'Opportunities'],
            ['name' => 'Delete Opportunities', 'slug' => 'opportunities.delete', 'module' => 'Opportunities'],

            ['name' => 'View Campaigns', 'slug' => 'campaigns.view', 'module' => 'Campaigns'],
            ['name' => 'Create Campaigns', 'slug' => 'campaigns.create', 'module' => 'Campaigns'],
            ['name' => 'Edit Campaigns', 'slug' => 'campaigns.edit', 'module' => 'Campaigns'],
            ['name' => 'Delete Campaigns', 'slug' => 'campaigns.delete', 'module' => 'Campaigns'],

            ['name' => 'View Cases', 'slug' => 'cases.view', 'module' => 'Cases'],
            ['name' => 'Create Cases', 'slug' => 'cases.create', 'module' => 'Cases'],
            ['name' => 'Edit Cases', 'slug' => 'cases.edit', 'module' => 'Cases'],
            ['name' => 'Delete Cases', 'slug' => 'cases.delete', 'module' => 'Cases'],

            ['name' => 'View Reports', 'slug' => 'reports.view', 'module' => 'Reports'],
            ['name' => 'Manage Users', 'slug' => 'users.manage', 'module' => 'Users'],
            ['name' => 'Manage Roles', 'slug' => 'roles.manage', 'module' => 'Roles'],
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(
                ['slug' => $permission['slug']],
                $permission
            );
        }

        $admin = Role::where('slug', 'admin')->first();
        $salesManager = Role::where('slug', 'sales-manager')->first();
        $salesRep = Role::where('slug', 'sales-rep')->first();
        $marketingUser = Role::where('slug', 'marketing-user')->first();
        $supportUser = Role::where('slug', 'support-user')->first();

        $admin->permissions()->sync(Permission::pluck('id'));

        $salesManager->permissions()->sync(
            Permission::whereIn('module', [
                'Dashboard',
                'Leads',
                'Contacts',
                'Accounts',
                'Opportunities',
                'Reports',
            ])->pluck('id')
        );

        $salesRep->permissions()->sync(
            Permission::whereIn('slug', [
                'dashboard.view',

                'leads.view',
                'leads.create',
                'leads.edit',

                'contacts.view',
                'contacts.create',
                'contacts.edit',

                'accounts.view',

                'opportunities.view',
                'opportunities.create',
                'opportunities.edit',
            ])->pluck('id')
        );

        $marketingUser->permissions()->sync(
            Permission::whereIn('module', [
                'Dashboard',
                'Leads',
                'Campaigns',
                'Reports',
            ])->pluck('id')
        );

        $supportUser->permissions()->sync(
            Permission::whereIn('module', [
                'Dashboard',
                'Accounts',
                'Contacts',
                'Cases',
            ])->pluck('id')
        );
    }
}
