<?php

use App\Models\Auth\User;

test('authenticated user can access the dashboard', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get(route('home'));

    $response->assertOk();
});
