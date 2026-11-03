<?php

it('uses the admin-style dashboard layout for the agent portal', function () {
    $response = $this->get('/agent/dashboard');

    $response->assertStatus(200)
        ->assertSee('EstatePro')
        ->assertSee('Dashboard Overview')
        ->assertSee('Recent Property Listings');
});
