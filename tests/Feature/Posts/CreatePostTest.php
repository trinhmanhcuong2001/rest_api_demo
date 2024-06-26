<?php

namespace Tests\Feature\Posts;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class CreatePostTest extends TestCase
{
    /** @test */

    public function user_can_create_post_if_data_is_valid(){
        $dataCreate = [
            'name' => $this->faker->name,
            'body' => $this->faker->text
        ];

        $response = $this->json('POST', route('posts.store'), $dataCreate);

        $response->assertStatus(Response::HTTP_OK);

        $response->assertJson(fn (AssertableJson $json) =>
            $json->has('data', fn (AssertableJson $json) =>
                $json->where('name', $dataCreate['name'])->etc()
            )->etc()
        );
        $this->assertDatabaseHas('posts', [
            'name' => $dataCreate['name'],
            'body' => $dataCreate['body']
        ]);
    }

    /** @test */
    public function user_can_create_post_if_name_is_null() {
        $dataCreate =[
            'name' => '',
            'body' => $this->faker->text()
        ];

        $response = $this->postJson(route('posts.store'), $dataCreate);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $response->assertJson(fn (AssertableJson $json) =>
            $json->has('errors', fn (AssertableJson $json) =>
                $json->has('name')
                ->etc()
            )
        );
    }
}
