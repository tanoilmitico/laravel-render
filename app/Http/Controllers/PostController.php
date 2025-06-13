<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;

class PostController extends Controller
{
    // Mostra i post dell'utente autenticato
    public function myPosts()
    {
        $user = Auth::user();
        $posts = $user->posts; // Relazione definita nel modello User
        return view('posts.my-posts', compact('user', 'posts'));
    }

    // Mostra il form per creare un nuovo post
    public function create()
    {
        return view('posts.create');
    }

    // Salva un nuovo post nel database (con immagine)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:15120',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
        }

        $post = new Post();
        $post->title = $validated['title'];
        $post->content = $validated['content'];
        $post->user_id = Auth::id();
        $post->image = $imagePath;
        $post->save();

        return view('posts.create', ['post' => $post]);
    }

    // Mostra il form di modifica
    public function edit($id)
    {
        $post = Post::findOrFail($id);

        if ($post->user_id !== Auth::id()) {
            abort(403);
        }

        return view('posts.edit', compact('post'));
    }

    // Aggiorna il post con gestione immagine
    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        if ($post->user_id !== Auth::id()) {
            abort(403);
        }
  // Modifica un nuovo post nel database (con immagine)
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:15120',
        ]);

        $post->title = $validated['title'];
        $post->content = $validated['content'];

        if ($request->hasFile('image')) {
            // Elimina immagine vecchia se esiste
            if ($post->image && \Storage::disk('public')->exists($post->image)) {
                \Storage::disk('public')->delete($post->image);
            }

            // Salva nuova immagine
            $imagePath = $request->file('image')->store('images', 'public');
            $post->image = $imagePath;
        }

        $post->save();

        return redirect()->route('my.posts')->with('success', 'Post aggiornato con successo!');
    }

    // Elimina più post selezionati
    public function deleteMultiple(Request $request)
    {
        $postIds = $request->input('post_ids', []);

        if (!empty($postIds)) {
            Post::whereIn('id', $postIds)
                ->where('user_id', Auth::id())
                ->delete();

            return redirect()->route('my.posts')->with('success', 'Post selezionati eliminati con successo!');
        }

        return redirect()->route('my.posts')->with('success', 'Nessun post selezionato.');
    }
    //controller per vedere tutti i post se utente admin
public function allPosts()
{
    if (!Auth::user()->is_admin) {
        abort(403, 'Accesso negato');
    }

    $posts = Post::with('user')->latest()->get();
    return view('posts.all-posts', compact('posts'));
}
// con funzione json php artisan install:api lo trovi con api.php
    public function index(){
        return response()->json(Post::all(),200);
    }

    // Elimina un singolo post
    public function delete($id)
    {
        $post = Post::findOrFail($id);

        if ($post->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Non sei autorizzato a eliminare questo post.');
        }

        // Elimina immagine associata, se presente
        if ($post->image && \Storage::disk('public')->exists($post->image)) {
            \Storage::disk('public')->delete($post->image);
        }

        $post->delete();

        return redirect()->back()->with('success', 'Post eliminato con successo.');
    }
}
