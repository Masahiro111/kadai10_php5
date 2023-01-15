<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $posts = Post::query()
            ->withCount('comments')
            ->get();

        $recent_posts = Post::query()
            ->take(5)
            ->latest()
            ->get();

        $categories = Category::query()
            ->withCount('posts')
            ->orderBy('posts_count', 'desc')
            ->get();

        $tags = Tag::query()
            ->take(50)
            ->get();

        return view('home', compact(
            'posts',
            'recent_posts',
            'categories',
            'tags',
        ));
    }
}
