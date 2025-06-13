<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Modifica Post</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Modifica il post</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('post.update', $post->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label">Titolo</label>
            <input type="text" name="title" id="title" value="{{ old('title', $post->title) }}" class="form-control">
        </div>

        <div class="mb-3">
            <label for="content" class="form-label">Contenuto</label>
            <textarea name="content" id="content" rows="5" class="form-control">{{ old('content', $post->content) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Immagine</label>
            <input type="file" class="form-control" id="image" name="image">
            @if ($post->image)
                <p class="mt-2">Immagine attuale: <br>
                    <img src="{{ asset('storage/' . $post->image) }}" alt="Immagine attuale" style="max-width: 200px;">
                </p>
            @endif
        </div>

        <button type="submit" class="btn btn-success">Aggiorna</button>
        <a href="{{ route('my.posts') }}" class="btn btn-secondary">Annulla</a>
    </form>
</div>
</body>
</html>
