<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ListsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_can_be_accessed_successfully(): void
    {
        $user = \App\Models\User::get()->first();

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertStatus(200);
    }
}
