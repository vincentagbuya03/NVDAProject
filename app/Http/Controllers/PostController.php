<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('user')->latest()->paginate(10);
        return view('post.index', compact('posts'));
    }

    public function create()
    {
        if (!in_array(Auth::user()->role, ['admin', 'teacher'], true)) {
            abort(403, 'Unauthorized action.');
        }

        $users = [];
        if (Auth::user()->role === 'admin') {
            $users = User::with('student')->get();
        }
        
        return view('post.create', compact('users'));
    }

    public function store(Request $request)
    {
        if (!in_array(Auth::user()->role, ['admin', 'teacher'], true)) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'user_id' => [Auth::user()->role === 'admin' ? 'required' : 'nullable', 'exists:users,id'],
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
        ]);

        // Auto-assign user_id if not an admin or if not provided
        if (Auth::user()->role !== 'admin' || !isset($validated['user_id'])) {
            $validated['user_id'] = Auth::id();
        }

        $post = Post::create($validated);

        Log::info('Post created', [
            'post_id' => $post->id,
            'user_id' => $post->user_id,
            'actor_id' => Auth::id(),
        ]);

        return redirect()->route('posts.index')->with('success', 'Post created successfully.');
    }

    public function show(string $id)
    {
        $post = Post::with('user')->findOrFail($id);
        return view('post.show', compact('post'));
    }

    public function edit(string $id)
    {
        if (!in_array(Auth::user()->role, ['admin', 'teacher'], true)) {
            abort(403, 'Unauthorized action.');
        }

        $post = Post::findOrFail($id);
        $users = User::orderBy('name')->get();

        Log::info('Post edit opened', [
            'post_id' => $post->id,
            'actor_id' => Auth::id(),
        ]);

        return view('post.edit', compact('post', 'users'));
    }

    public function update(Request $request, string $id)
    {
        if (!in_array(Auth::user()->role, ['admin', 'teacher'], true)) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
        ]);

        $post = Post::findOrFail($id);
        $post->update($validated);

        Log::info('Post updated', [
            'post_id' => $post->id,
            'user_id' => $post->user_id,
            'actor_id' => Auth::id(),
        ]);

        return redirect()->route('posts.index')->with('success', 'Post updated successfully.');
    }

    public function destroy(Request $request, string $id)
    {
        if (!in_array(Auth::user()->role, ['admin', 'teacher'], true)) {
            abort(403, 'Unauthorized action.');
        }

        $post = Post::findOrFail($id);
        $deletedPostId = $post->id;

        $post->delete();

        Log::info('Post deleted', [
            'post_id' => $deletedPostId,
            'actor_id' => Auth::id(),
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Post deleted successfully.'
            ]);
        }

        return redirect()->route('posts.index')->with('success', 'Post deleted successfully.');
    }
}
