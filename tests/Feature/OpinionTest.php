<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OpinionTest extends TestCase
{
    /**
     * Test user token works
     *
     * @return void
     */
    public function testUserCanCreateOpinion()
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
}
