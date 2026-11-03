<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

beforeEach(function () {
    Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
    Role::firstOrCreate(['name' => 'agent', 'guard_name' => 'web']);
    Role::firstOrCreate(['name' => 'buyer', 'guard_name' => 'web']);
});

test('admin can view the heavy professional profile page', function () {
    $admin = User::factory()->create([
        'name' => 'Syed Muneeb Shah',
        'email' => 'admin_test@estatepro.com',
        'role' => 'admin',
    ]);
    $admin->assignRole('admin');

    $response = $this->actingAs($admin)->get(route('admin.profile.index'));

    $response->assertStatus(200);
    $response->assertSee('Admin Profile');
    $response->assertSee('Syed Muneeb Shah');
    $response->assertSee('Super Administrator');
    $response->assertSee('Active Account');
    $response->assertSee('Account & Role Status', false);
});

test('admin can update profile details', function () {
    $admin = User::factory()->create([
        'name' => 'Old Admin Name',
        'email' => 'old_admin@estatepro.com',
    ]);
    $admin->assignRole('admin');

    $response = $this->actingAs($admin)->put(route('admin.profile.update'), [
        'name' => 'Updated Admin Master',
        'email' => 'updated_admin@estatepro.com',
        'phone' => '+92 300 1234567',
        'address' => 'EstatePro Executive Tower, Suite 900',
    ]);

    $response->assertRedirect(route('admin.profile.index'));
    $response->assertSessionHas('success');

    $admin->refresh();
    expect($admin->name)->toBe('Updated Admin Master')
        ->and($admin->email)->toBe('updated_admin@estatepro.com')
        ->and($admin->phone)->toBe('+92 300 1234567')
        ->and($admin->address)->toBe('EstatePro Executive Tower, Suite 900');
});

test('admin can update password', function () {
    $admin = User::factory()->create([
        'password' => Hash::make('oldpassword123'),
    ]);
    $admin->assignRole('admin');

    $response = $this->actingAs($admin)->put(route('admin.profile.password'), [
        'current_password' => 'oldpassword123',
        'password' => 'NewSecretPassword123!',
        'password_confirmation' => 'NewSecretPassword123!',
    ]);

    $response->assertRedirect(route('admin.profile.index'));
    $response->assertSessionHas('success');

    $admin->refresh();
    expect(Hash::check('NewSecretPassword123!', $admin->password))->toBeTrue();
});
