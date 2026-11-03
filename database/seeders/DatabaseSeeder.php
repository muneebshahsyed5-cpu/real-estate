<?php

namespace Database\Seeders;

use App\Models\Property;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // =========================
        // Roles
        // =========================

        $adminRole = Role::firstOrCreate([
            'name' => 'admin',
        ]);

        $ownerRole = Role::firstOrCreate([
            'name' => 'owner',
        ]);

        $agentRole = Role::firstOrCreate([
            'name' => 'agent',
        ]);

        $buyerRole = Role::firstOrCreate([
            'name' => 'buyer',
        ]);

        $userRole = Role::firstOrCreate([
            'name' => 'user',
        ]);

        // =========================
        // Permissions
        // =========================

        $permissions = [
            'view property',
            'create property',
            'edit property',
            'delete property',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
            ]);
        }

        // =========================
        // Role Permissions
        // =========================

        // Admin - All permissions
        $adminRole->syncPermissions(Permission::all());

        // Owner - View, Create, Edit, Delete
        $ownerRole->syncPermissions([
            'view property',
            'create property',
            'edit property',
            'delete property',
        ]);

        // Agent - View, Create, Edit
        $agentRole->syncPermissions([
            'view property',
            'create property',
            'edit property',
        ]);

        // Buyer - Only View
        $buyerRole->syncPermissions([
            'view property',
        ]);

        // User - Only View
        $userRole->syncPermissions([
            'view property',
        ]);

        // =========================
        // Admin User
        // =========================

        $admin = User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Syed Muneeb Shah',
                'phone' => '923284512561',
                'password' => Hash::make('password'),
            ]
        );

        $admin->syncRoles([$adminRole]);

        // =========================
        // Owner User
        // =========================

        $owner = User::firstOrCreate(
            ['email' => 'owner@gmail.com'],
            [
                'name' => 'Owner',
                'password' => Hash::make('password'),
            ]
        );

        $owner->syncRoles([$ownerRole]);

        // =========================
        // Agent User
        // =========================

        $agents = [
            [
                'email' => 'agent@gmail.com',
                'name' => 'Agent',
                'phone' => '03127353356',
                'image' => 'agents/agent.jpg',
            ],

            [
                'email' => 'abdullah@gmail.com',
                'name' => 'Syed Abdullah',
                'phone' => '03001234567',
                'image' => 'agents/abdullah.jpg',
            ],

            [
                'email' => 'rayhan@gmail.com',
                'name' => 'Syed Rayhan',
                'phone' => '03111234567',
                'image' => 'agents/rayhan.jpg',
            ],

            [
                'email' => 'wahab@gmail.com',
                'name' => 'Syed Wahab',
                'phone' => '03221234567',
                'image' => 'agents/wahab.jpg',
            ],
        ];

        foreach ($agents as $agentData) {

            $agent = User::updateOrCreate(
                ['email' => $agentData['email']],
                [
                    'name' => $agentData['name'],
                    'phone' => $agentData['phone'],
                    'image' => $agentData['image'],
                    'password' => Hash::make('password'),
                ]
            );

            $agent->syncRoles([$agentRole]);
        }


        // =========================
        // Buyer User
        // =========================

        $buyers = [
            [
                'email' => 'safia.com',
                'name' => 'Syeda Safia',
                'phone' => '03264330915',
                'address' => 'Islamabad, Pakistan',
            ],
            [
                'email' => 'mukhtar@gmail.com',
                'name' => 'Syed Mukhtar Ahmad',
                'phone' => '03111234567',
                'address' => 'Lahore, Pakistan',
            ],
            [
                'email' => 'hifza@gmail.com',
                'name' => 'Syeda Hifza',
                'phone' => '03284512561',
                'address' => 'Islamabad, Pakistan',
            ],
        ];

        foreach ($buyers as $buyerData) {

            $buyer = User::firstOrCreate(
                ['email' => $buyerData['email']],
                [
                    'name' => $buyerData['name'],
                    'phone' => $buyerData['phone'],
                    'address' => $buyerData['address'],
                    'password' => Hash::make('password'),
                ]
            );

            $buyer->syncRoles([$buyerRole]);
        }

        // =========================
        // Normal User
        // =========================

        $user = User::firstOrCreate(
            ['email' => 'user@gmail.com'],
            [
                'name' => 'User',

                'password' => Hash::make('password'),
            ]
        );

        $user->syncRoles([$userRole]);

        // =========================
        // Delete Properties
        // =========================

        // Property::query()->delete();
    }
    // {
    //     Schema::dropIfExists('buyer-inquiries');
    //     Schema::dropIfExists('buyer_inquiries');
    // }
}
