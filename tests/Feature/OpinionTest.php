<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\User;
use App\Opinion;
use App\Comment;
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

    /**
     * Test anyone can view opinions
     *
     * @return void
     */
    public function testAnyoneCanViewOpinions()
    {
        User::truncate();
        Opinion::truncate();
        Comment::truncate();

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
        $token = $response->getData()->data->api_token;

        $response = $this->json(
            'POST',
            '/api/opinions',
            [
                'title' => 'some opinion title',
                'text' => 'some opinion text'
            ],
            [
                'Authorization' => 'Bearer ' . $token
            ]
        );

        $response->assertStatus(200);

        $response = $this->json(
            'POST',
            '/api/opinions',
            [
                'title' => 'some other opinion title',
                'text' => 'some other opinion text'
            ],
            [
                'Authorization' => 'Bearer ' . $token
            ]
        );

        $response->assertStatus(200);

        $response = $this->json(
            'GET',
            '/api/opinions'
        );

        $response->assertStatus(200);
        $this->assertNotEquals(0, count($response->getData()->data));
        $this->assertArrayHasKey(
            'comments', json_decode(
                json_encode($response->getData()->data[0]),
                true
            )
        );
    }
}