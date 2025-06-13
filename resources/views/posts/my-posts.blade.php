<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>I miei post</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-5">
    <h2 class="mb-4">👋 Ciao {{ $user->name }}, ecco i tuoi post</h2>

    {{-- Messaggio di successo --}}
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Nessun post --}}
    @if ($posts->isEmpty())
        <div class="alert alert-info">
            <p>Non hai ancora scritto nessun post.</p>
            <a href="{{ route('home') }}" class="btn btn-success mt-2">🏠 Torna alla Homepage</a>
        </div>
    @else

        {{-- Form per eliminazione multipla --}}
        <form action="{{ route('posts.deleteMultiple') }}" method="POST">
            @csrf
            @method('DELETE')

            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                <button type="submit" class="btn btn-danger"
                        onclick="return confirm('Vuoi davvero eliminare i post selezionati?')">
                    🗑️ Elimina selezionati
                </button>
                <a href="{{ route('home') }}" class="btn btn-outline-success">🏠 Homepage</a>
            </div>

            <div class="row g-4">
                @foreach ($posts as $post)
                    <div class="col-md-6 col-lg-4">
                        <div class="card shadow-sm h-100">
                            @if ($post->image)
                                <img src="{{ asset('storage/' . $post->image) }}" alt="Immagine post" class="card-img-top" style="height: 180px; object-fit: cover;">
                            @else
                                <img src="https://source.unsplash.com/400x200/?blog,post" alt="Placeholder" class="card-img-top" style="height: 180px; object-fit: cover;">
                            @endif

                            <div class="card-body d-flex flex-column justify-content-between">
                                <div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="post_ids[]" value="{{ $post->id }}" id="post-{{ $post->id }}">
                                        <label class="form-check-label fw-bold" for="post-{{ $post->id }}">
                                            {{ $post->title }}
                                        </label>
                                    </div>

                                    <p class="card-text">{{ Str::limit($post->content, 100) }}</p>
                                    <small class="text-muted">🕒 {{ $post->created_at->format('d/m/Y H:i') }}</small>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    {{-- Modifica --}}
                                    <a href="{{ route('post.edit', $post->id) }}" class="btn btn-sm btn-warning">✏️ Modifica</a>

                                    {{-- Elimina singolo --}}
                                    <form action="{{ route('post.delete', $post->id) }}" method="POST" onsubmit="return confirm('Eliminare questo post?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">🗑️</button>
                                    </form>

                                    {{-- Pagamento --}}
                                    <form action="{{ route('checkout', $post->id) }}" method="POST" class="ms-2">
                                        @csrf
                                        <input type="hidden" name="amount" value="{{ floatval($post->content) }}">
                                        <button type="submit" class="btn btn-sm btn-outline-primary"
                                                onclick="return confirm('Vuoi procedere con il pagamento di €{{ floatval($post->content) }}?')">
                                            💳 Paga €{{ floatval($post->content) }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </form>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
