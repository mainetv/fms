<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class RolesAccessTest extends TestCase
{
    /** @test */
    public function user_must_login_to_access_to_admin_dashboard()
    {
        $this->get(route('dashboard.index'))
             ->assertRedirect('login');
    }

    /** @test */
    public function admin_can_access_to_admin_dashboard()
    {
        //Having
        $adminUser = factory(User::class)->create();

        $adminUser->assignRole('Administrator');

        $this->actingAs($adminUser);

        //When
        $response = $this->get(route('dashboard.index'));

        //Then
        $response->assertOk();
    }

    /** @test */
    public function users_cannot_access_to_admin_dashboard()
    {
        //Having
        $user = factory(User::class)->create();

        $user->assignRole('Division Budget Officer');

        $this->actingAs($user);

        //When
        $response = $this->get(route('dashboard.index'));

        //Then
        $response->assertForbidden();
    }

    /** @test */
    public function user_can_access_to_home()
    {
        //Having
        $user = factory(User::class)->create();

        $user->assignRole('Division Budget Officer');

        $this->actingAs($user);

        //When
        $response = $this->get(route('dashboard.index'));

        //Then
        $response->assertOk();
    }

    /** @test */
    public function admin_can_access_to_home()
    {
        //Having
        $adminUser = factory(User::class)->create();

        $adminUser->assignRole('Administrator');

        $this->actingAs($adminUser);

        //When
        $response = $this->get(route('global.budget_maintenance'));

        //Then
        $response->assertOk();
    }
}
