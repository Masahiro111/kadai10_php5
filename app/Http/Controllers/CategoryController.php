<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return view('categories.index', [
            'categories' => Category::withCount('posts')->latest()->paginate(100)
        ]);
    }

    public function show(Category $category)
    {
        $recent_posts = Post::query()
            ->latest()
            ->take(5)
            ->get();

        $categories = Category::query()
            ->withCount('posts')
            ->latest()
            ->get();

        $tags = Tag::query()
            ->latest()
            ->take(50)
            ->get();

        return view('categories.show', [
            'recent_posts' => $recent_posts,
            'categories' => $categories,
            'tags' => $tags,

            'category' => $category,
            'posts' => $category->posts()->latest()->paginate(10),
        ]);
    }
}
