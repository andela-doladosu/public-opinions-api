<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    /**
     * Test user create route is not protected
     *
     * @return void
     */
    public function testUserCanCreateAccounts()
    {
        $totalUsersBeforeSignup = count(User::all());

        $email = 'me@mmmail.com';
        $password = 'pass1234';

        $response = $this->json(
            'POST',
            '/api/users/create',
            [
                'email' => $email,
                'name' => 'Sally',
                'password' => $password,
                'password_confirmation' => $password
            ]
        );
        $response->assertStatus(200);

        $totalUsersAfterSignup = count(User::all());
        $this->assertNotEquals($totalUsersBeforeSignup, $totalUsersAfterSignup);
    }
}
