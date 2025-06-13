<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Crea un nuovo post</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: #f8f9fa;
        }
        .hero {
            background: url('https://source.unsplash.com/1600x400/?writing,notebook') no-repeat center center;
            background-size: cover;
            height: 250px;
            border-radius: 0 0 15px 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .hero h1 {
            background: rgba(0, 0, 0, 0.5);
            padding: 1rem 2rem;
            border-radius: 10px;
        }

        .card {
            border: none;
        }
    </style>
</head>
<body>

    {{-- HERO --}}
    

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                @isset($post)
                    <div class="card shadow p-4 text-center">
                        <h2 class="mb-3 text-success">🎉 Post creato con successo!</h2>
                        <p>Hai creato un nuovo post con ID: <strong>{{ $post->id }}</strong></p>

                        <img src="https://source.unsplash.com/600x300/?success,blog" class="img-fluid rounded mb-4" alt="Success Image">

                        <div class="d-flex justify-content-center gap-3 mt-3 flex-wrap">
                            <a href="{{ route('my.posts') }}" class="btn btn-primary">
                                <i class="bi bi-journal-text"></i> I miei post
                            </a>
                            <a href="{{ route('posts.create') }}" class="btn btn-secondary">
                                <i class="bi bi-plus-circle"></i> Nuovo post
                            </a>
                            <a href="{{ route('home') }}" class="btn btn-success">
                                <i class="bi bi-house-door"></i> Homepage
                            </a>
                        </div>
                    </div>
                @else
                    <div class="card shadow p-4">
                        <h3 class="mb-4">✍️ Inserisci i dettagli del tuo nuovo post</h3>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $errore)
                                        <li>{{ $errore }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label for="title" class="form-label">Titolo</label>
                                <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="content" class="form-label">Contenuto</label>
                                <textarea class="form-control" id="content" name="content" rows="6" required>{{ old('content') }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label for="image" class="form-label">Immagine</label>
                                <input type="file" class="form-control" id="image" name="image">
                            </div>

                            <div class="d-flex gap-2 mt-4 flex-wrap">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-upload"></i> Pubblica
                                </button>
                                <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-house"></i> Torna alla Home
                                </a>
                            </div>
                        </form>
                    </div>
                @endisset

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
