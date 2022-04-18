<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Faker\Factory as Faker;
class AuthTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;
    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed');
        $this->faker = Faker::create();
    }

    public function testAdminLoginSuccess() {
        $response = $this->post('/api/auth/login', [
            'user_code' => "111111",
            'password' => '123456789'
        ]);
        $response->assertJson([
            "code" => 200,
        ], $strict = false);
    }

    public function testLoginWithoutPassword() {
        $response = $this->post('/api/auth/login', [
            'user_code' => "111111",
            'password' => ''
        ]);
        $response->assertJson([
            "code" => 422,
            "message" => "パスワードは、必ず指定してください。",
            "message_content" => null,
            "message_internal" => [
                "password" => [
                    "パスワードは、必ず指定してください。"
                ]
            ],
            "data_error" => null
        ], $strict = false);
    }

    public function testLoginWithoutAccount() {
        $response = $this->post('/api/auth/login', [
            'user_code' => '',
            'password' => '123456789'
        ]);
        $response->assertJson([
            "code" => 422,
            "message" => "user codeは、必ず指定してください。",
            "message_content" => null,
            "message_internal" => [
                "user_code" => [
                    "user codeは、必ず指定してください。"
                ]
            ],
            "data_error" => null
        ], $strict = false);
    }

    public function testLogout() {
        $response = $this->post('/api/auth/login', [
            'user_code' => "111111",
            'password' => '123456789'
        ]);
        $data = json_decode($response->getContent());

        $response = $this->post('/api/auth/logout', [], [
            'Authorization' => $data->data->access_token
        ]);

        $response->assertJson([
            "status" => "success",
            "message" => "logout"
        ], $strict = false);
    }


    public function testUserInformation() {
        $response = $this->post('/api/auth/login', [
            'user_code' => "111111",
            'password' => '123456789'
        ]);
        $data = json_decode($response->getContent());

        $response = $this->get('/api/auth/user', [
            'Authorization' => $data->data->access_token
        ]);

        $response->assertJsonStructure([
            "id",
            "user_code",
            "department_id",
            "user_name",
            "created_by",
            "updated_by" ,
            "created_at",
            "updated_at"
        ]);
    }

    public function testValidationAccount() {
        $response = $this->post('/api/auth/login', [
            'user_code' => "11",
            'password' => '19'
        ]);

        $response->assertJson([
            "code" => 422,
            "message" => "パスワードは、8文字以上にしてください。",
            "message_content" => null,
            "message_internal" => [
                "password" => [
                    "パスワードは、8文字以上にしてください。"
                ]
            ],
            "data_error" => null
        ]);
    }

    public function testLoginFaildByDeletedAccount() {
        User::where('user_code', 111111)->delete();
        $response = $this->post('/api/auth/login', [
            'user_code' => "111111",
            'password' => '123456789'
        ]);

        $response->assertJson([
            "code" => 401,
            "message" => "ID、パスワードの間違った形式を入力しました",
            "message_content" =>null,
            "message_internal" => null,
            "data_error" => null
        ]);
    }



}
