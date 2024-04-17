<?php

namespace App\Http\Controllers\Blog;

use App\Helpers\PaginationResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\BlogResource;
use App\Models\Category;
use App\Models\Post;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class BlogController extends Controller
{
    use ApiResponser;

    private array $texts = [
        'list' => 'لیست پست ها',
        'not_found' => 'پستی یافت نشد.',
    ];

    public function index(): \Illuminate\Http\JsonResponse
    {
        // get from cache if exists or query database
        $posts = Cache::remember('blog-posts',now()->addHours(72), function () {
            return Post::latest()->paginate(20);
        });
        return $this->successResponse($this->texts['list'], [
            ...PaginationResource::make($posts),
            'posts' => BlogResource::collection($posts),
        ]);
    }


    public function category($slug): \Illuminate\Http\JsonResponse
    {

        $posts = Cache::remember("blog-posts-{$slug}",now()->addHours(72), function () use ($slug) {
            return Category::blog()->where('slug', $slug)->latest()->paginate(20);
        });


        if ($posts->count() == 0) {
            return $this->errorResponse($this->texts['not_found'], 404);
        }


        return $this->successResponse($this->texts['list'], [
            ...PaginationResource::make($posts),
            'posts' => BlogResource::collection($posts),
        ]);
    }


    public function search(Request $request): \Illuminate\Http\JsonResponse
    {
        if ($request->deep_search) {
            $posts = Post::where('title', 'like', "%{$request->q}%")
                ->orWhere('excerpt', 'like', "%{$request->q}%")
                ->orWhere('body', 'like', "%{$request->q}%")
                ->latest()->paginate(20);
        } else {
            // search in title only (default)
            $posts = Post::where('title', 'like', "%{$request->q}%")->latest()->paginate(20);
        }

        if ($posts->count() == 0) {
            return $this->errorResponse($this->texts['not_found'], 404);
        }

        return $this->successResponse($this->texts['list'], [
            ...PaginationResource::make($posts),
            'posts' => BlogResource::collection($posts),
        ]);
    }

}
