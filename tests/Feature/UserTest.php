<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    /**
     * Test user can create account
     *
     * @return void
     */
    public function testUserCanCreateAccounts()
    {
        User::truncate();

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

    /**
     * Test user token works
     *
     * @return void
     */
    public function testUserTokenWorks()
    {
        User::truncate();

        $email = 'dara@gmail.com';
        $password = 'pass1234';

        $response = $this->json(
            'POST',
            '/api/users/create',
            [
                'email' => $email,
                'name' => 'Dara',
                'password' => $password,
                'password_confirmation' => $password
            ]
        );

        $response->assertStatus(200);

        $response = $this->json(
            'POST',
            '/api/opinions',
            [
                'title' => 'some title',
                'text' => 'some text'
            ],
            [
                'Authorization' => 'Bearer ' . $response->getData()->data->api_token
            ]
        );

        $response->assertStatus(200);
    }

    /**
     * Test user can delete their own account
     *
     * @return void
     */
    public function testUserCanDeleteTheirOwnAccount()
    {
        User::truncate();

        $email = 'dara@gmail.com';
        $password = 'pass1234';

        $response = $this->json(
            'POST',
            '/api/users/create',
            [
                'email' => $email,
                'name' => 'Dee',
                'password' => $password,
                'password_confirmation' => $password
            ]
        );

        $response->assertStatus(200);

        $token = $response->getData()->data->api_token;

        $lastInsertedUser = User::latest()->first();
        $userCountBeforeDelete = User::all()->count();

        $response = $this->json(
            'DELETE',
            "/api/users/$lastInsertedUser->id",
            [],
            [
                'Authorization' => 'Bearer ' . $token
            ]
        );

        $userCountAfterDelete = User::all()->count();

        $this->assertNotEquals($userCountBeforeDelete, $userCountAfterDelete);
    }
}
