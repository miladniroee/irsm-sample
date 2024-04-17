<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Http\Resources\BlogResource;
use App\Http\Resources\PostResource;
use App\Models\Comment;
use App\Models\Post;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PostController extends Controller
{
    use ApiResponser;

    const PAGINATION_COUNT = 10;
    const POSTS_LATEST_COUNT = 5;
    const POSTS_RELATED_COUNT = 5;
    const POST_COMMENTS_COUNT = 5;

    const POSTS_VIEWS_COUNT = 5;


    const CACHE_EXPIRE_TIME = 60 * 60 * 24 * 10; // 10 Days

    public function index($slug)
    {
        $post = Cache::remember('post.' . $slug, self::CACHE_EXPIRE_TIME, function () use ($slug) {
            return Post::where('slug', $slug)->with('comments')->firstOrFail();
        });

        return $this->successResponse($post->title, new PostResource($post));
    }

    public function sidebar(Post $post): \Illuminate\Http\JsonResponse
    {
        $related = Cache::remember('posts.related', self::CACHE_EXPIRE_TIME, function () use ($post) {
                return $this->getRelatedPosts($post);
            });

        $latest = Cache::remember('latest_posts', self::CACHE_EXPIRE_TIME, function () use ($post, $related) {
                return $this->getLatestPosts($post, $related);
            });

        $comments = Cache::remember('comments', self::CACHE_EXPIRE_TIME, function () {
            return $this->getLatestComments();
        });

        $mostViewed = Cache::remember('posts.most-view',self::CACHE_EXPIRE_TIME,function (){
            return $this->getMostViewedPosts();
        });

        return $this->successResponse('اطلاعات سایدبار', [
            'related' => BlogResource::collection($related),
            'latest' => BlogResource::collection($latest),
            'mostViewed' => BlogResource::collection($mostViewed),
            'comments' => $comments,
        ]);
    }


    private function getRelatedPosts(Post $post)
    {
        return Post::whereHas('categories', function ($query) use ($post) {
            $query->whereIn('category_id', $post->categories->pluck('id'));
        })->where('id', '!=', $post->id)->latest()->take(self::POSTS_RELATED_COUNT)->get();
    }

    private function getLatestPosts(Post $post, $related)
    {
        return Post::whereNotIn('id', $related->pluck('id'))->where('id', '!=', $post->id)->latest()->take(self::POSTS_LATEST_COUNT)->get();
    }

    private function getLatestComments()
    {
        return Comment::postComments()
            ->latest()
            ->take(self::POST_COMMENTS_COUNT)
            ->get();
    }

    private function getMostViewedPosts()
    {
        return Post::orderBy('views', 'desc')
            ->take(self::POSTS_VIEWS_COUNT)
            ->get();
    }
}
