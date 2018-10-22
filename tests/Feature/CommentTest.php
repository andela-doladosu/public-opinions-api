<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\User;
use App\Opinion;
use App\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommentTest extends TestCase
{
    /**
     * Test user can create comment
     *
     * @return void
     */
    public function testUserCanCreateComment()
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
                'title' => 'some title',
                'text' => 'some text'
            ],
            [
                'Authorization' => 'Bearer ' . $token
            ]
        );

        $response->assertStatus(200);

        $opinion = Opinion::latest()->first();

        $response = $this->json(
            'POST',
            "/api/opinions/$opinion->id/comments",
            [
                'text' => 'some comment',
                'opinion_id' => $opinion->id
            ],
            [
                'Authorization' => 'Bearer ' . $token
            ]
        );

        $response->assertStatus(200);
    }
}
