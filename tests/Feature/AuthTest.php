<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{

    public function test_it_redirects_guest_to_login()
    {
        $response = $this->get('/home');

        $response->assertRedirect('/login');
    }

    public function test_it_allow_loggin_in_user_to_visit_home(){
        $user=User::all();
        $this->actingAs($user);
        $response=$this->get('/home');
        $response->assertOk();
    }
}
