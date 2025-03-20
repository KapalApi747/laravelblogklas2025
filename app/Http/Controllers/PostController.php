<?php

namespace App\Http\Controllers;

use App\Events\PostCreated;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Category;
use App\Models\Photo;
use App\Models\Post;
use App\Services\ExportService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    use AuthorizesRequests;
    protected ExportService $exportService; // Object Variabele

    public function __construct(ExportService $exportService) {
        $this->exportService = $exportService;
    }

    public function exportAll($format) {
        $posts = Post::all();
        $headers = ['ID','Picture_ID','Author','Title','Published','Created_at','Updated_at'];
        return $this->exportService->export($format, $posts, $headers, 'posts');
    }

    public function exportOnePost($format, $id) {
        $post = Post::where('id', $id)->get();
        $headers = ['ID','Picture_ID','Author','Title','Published','Created_at','Updated_at'];

        return $this->exportService->export($format, $post, $headers, 'post');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $search = request('search');
        $categoryIds = request('category_ids', []);

        // Concreet voorbeeld zonder author.roles:
        // SELECT * FROM posts; -- Haalt alle posts op
        // SELECT * FROM users WHERE id = ?; -- Wordt herhaald voor elke post
        // SELECT * FROM roles INNER JOIN role_user WHERE user_id = ?; -- Wordt herhaald voor elke user

        $posts = Post::with(['author.roles', 'photo', 'categories'])
            ->published()
            ->filter($search)
            ->inCategories($categoryIds)
            ->sortable()
            ->paginate(5)
            ->appends(request()->query()); // ;

        $categories = Category::pluck('name', 'id');

        return view('backend.posts.index', compact('posts', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $categories = Category::pluck('name', 'id');

        return view('backend.posts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        //
        $validated = $request->validated();

        $validated['author_id'] = auth()->user()->id;

        // Genereer basis slug
        $slug = Str::slug($validated['title']);
        $originalSlug = $slug;
        $counter = 1;
        // Controleer of de slug al bestaat en pas deze aan indien nodig
        while (Post::where('slug', $slug)->exists()) {
            $slug = $originalSlug.'-'.$counter;
            $counter++;
        }
        $validated['slug'] = $slug;
        // afbeelding opslaan
        if ($request->hasFile('photo_id')) {
            $file = $request->file('photo_id');
            $path = $file->store('posts', 'public');
            $photo = Photo::create([
                'path' => $path,
                'alternate_text' => $validated['title'],
            ]);
            $validated['photo_id'] = $photo->id;
        }
        $post = Post::create($validated);
        $post->categories()->sync($request->categories);

        // events triggeren
        PostCreated::dispatch($post);

        return redirect()->route('posts.index')->with('message', 'Post created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
        return view('backend.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
        $categories = Category::pluck('name', 'id');

        return view('backend.posts.edit', compact('post', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        //

        $this->authorize('update', $post);
        $validated = $request->validated();
        $validated['slug'] = Str::slug($validated['title']);
        $validated['author_id'] = $post->author_id;
        // Afbeelding bijwerken
        if ($request->hasFile('photo_id')) {
            if ($post->photo && Storage::disk('public')->exists($post->photo->path)) {
                Storage::disk('public')->delete($post->photo->path);
            }
            $file = $request->file('photo_id');
            $path = $file->store('posts', 'public');
            // Controleer of de post al een afbeelding heeft
            if ($post->photo) {
                $post->photo->update([
                    'path' => $path,
                    'alternate_text' => $validated['title'],
                ]);
                $validated['photo_id'] = $post->photo->id;
            } else {
                // Maak een nieuwe foto aan
                $photo = Photo::create([
                    'path' => $path,
                    'alternate_text' => $validated['title'],
                ]);
                $validated['photo_id'] = $photo->id;
            }
        } else {
            // Voorkom dat een null-waarde wordt toegevoegd aan photo_id
            unset($validated['photo_id']);
        }
        $post->update($validated);
        $post->categories()->sync($request->categories);

        return redirect()->route('posts.index')->with('message', 'Post succesvol bijgewerkt.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        // fysisch op de schijf
        if ($post->photo && Storage::disk('public')->exists($post->photo->path)) {
            Storage::disk('public')->delete($post->photo->path);
        }
        // delete zelf db
        $post->delete();

        return redirect()->route('posts.index')->with('message', 'Post deleted successfully!');
    }
}
