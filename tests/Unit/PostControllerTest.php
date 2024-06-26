<?php

namespace Tests\Unit;

use App\Http\Controllers\API\PostController;
use App\Models\Post;
use Illuminate\Http\Response;
use Mockery;
use PHPUnit\Framework\TestCase;

class PostControllerTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_example(): void
    {
        $posts = Mockery::mock('Illuminate\Pagination\LengthAwarePaginator');
        $postModel = Mockery::mock(Post::class);
        $postModel->shouldReceive('paginate')->with(5)->andReturn($posts);

        $controller = new PostController($postModel);
        $response = $controller->index();

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
    }
}
