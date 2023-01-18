<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class AdminPostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::query()
            ->with('category')
            ->latest()
            ->get();

        return view('admin_dashboard.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::query()
            ->pluck('name', 'id');

        return view('admin_dashboard.posts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:200',
            'slug' => 'required|max:200',
            'excerpt' => 'required|max:300',
            'category_id' => 'required|numeric',
            'thumbnail' => 'required|file|mimes:jpg,png,webp,svg,jpeg|dimensions:max_width=300,max_height=227',
            'body' => 'required',
        ]);

        $validated['user_id'] = auth()->id();
        $post = Post::query()->create($validated);

        if ($request->has('thumbnail')) {
            $thumbnail = $request->file('thumbnail');
            $filename = $thumbnail->getClientOriginalName();
            $file_extension = $thumbnail->getClientOriginalExtension();
            $path = $thumbnail->store('images', 'public');

            $post->image()->create([
                'name' => $filename,
                'extension' => $file_extension,
                'path' => $path,
            ]);

            return redirect()
                ->route('admin.posts.index')
                ->with('success', 'Post has been created');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function edit(Post $post)
    {
        return view('admin_dashboard.posts.edit', [
            'post' => $post,
            'categories' => Category::query()->pluck('name', 'id'),
        ]);
    }

    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'required|max:200',
            'slug' => 'required|max:200',
            'excerpt' => 'required|max:300',
            'category_id' => 'required|numeric',
            'thumbnail' => 'nullable|file|mimes:jpg,png,webp,svg,jpeg|dimensions:max_width=300,max_height=227',
            'body' => 'required',
        ]);

        $post->update($validated);

        if ($request->has('thumbnail')) {
            $thumbnail = $request->file('thumbnail');
            $filename = $thumbnail->getClientOriginalName();
            $file_extension = $thumbnail->getClientOriginalExtension();
            $path = $thumbnail->store('images', 'public');

            $post->image()->update([
                'name' => $filename,
                'extension' => $file_extension,
                'path' => $path,
            ]);
        }

        return redirect()
            ->route('admin.posts.edit', $post)
            ->with('success', 'Post has been updated.');
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()
            ->route('admin.posts.index')
            ->with('success', 'Post has been Deleted.');
    }
}
