<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{
    /**
     * Test opinion post route is protected
     *
     * @return void
     */
    public function testOpinionPostRouteIsProtected()
    {
        $response = $this->post('/api/opinions');
        $response->assertStatus(401);
    }

    /**
     * Test opinion delete route is protected
     *
     * @return void
     */
    public function testOpinionDeleteRouteIsProtected()
    {
        $response = $this->delete('/api/opinions/1');
        $response->assertStatus(401);
    }

    /**
     * Test opinion edit route is protected
     *
     * @return void
     */
    public function testOpinionEditRouteIsProtected()
    {
        $response = $this->put('/api/opinions/1');
        $response->assertStatus(401);
    }

    /**
     * Test opinion get route is not protected
     *
     * @return void
     */
    public function testOpinionGetRouteIsNotProtected()
    {
        $response = $this->get('/api/opinions');
        $response->assertStatus(200);
    }

    /**
     * Test user delete route is protected
     *
     * @return void
     */
    public function testUserDeleteRouteIsProtected()
    {
        $response = $this->delete('api/users/delete');
        $response->assertStatus(401);
    }

    /**
     * Test user create route is not protected
     *
     * @return void
     */
    public function testUserCreateRouteIsNotProtected()
    {
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
    }


}
