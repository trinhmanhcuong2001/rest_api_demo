<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;
use Illuminate\Http\Request;
use App\Models\Post;
use Symfony\Component\HttpFoundation\Response;

class PostController extends Controller
{

    protected $post;

    public function __construct(Post $post){
        $this->post = $post;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = $this->post->paginate(5);
        $postsResource = PostResource::collection($posts)->response()->getData(true);
        //$postsCollection = new PostCollection($posts);


        return $this->sentSeccessResponse($postsResource, 'Thành công!', Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $dataCreate = $request->all();

        $post = $this->post->create($dataCreate);

        $postResource = new PostResource($post);

        return response()->json([
            'data' => $postResource
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = $this->post->findOrFail($id);

        $postResource = new PostResource($post);

        return $this->sentSeccessResponse($postResource, 'Thành công!', Response::HTTP_OK);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StorePostRequest $request, string $id)
    {
        $dataUpdate = $request->all();

        $post = $this->post->findOrFail($id);

        $post->update($dataUpdate);

        $postResource = new PostResource($post);

        return $this->sentSeccessResponse($postResource, 'Thành công!', Response::HTTP_OK);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = $this->post->findOrFail($id);

        $post->delete();

        return response()->json([
            'message' => 'Successfully deleted'
        ]);
    }
}
