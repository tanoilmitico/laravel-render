<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1> Tutti i post </h1>
    @if ($posts-> isEmpty())
    <p> Non ci sono post disponibili.</p>
    @else
    <ul>
        @foreach ($posts as $post)
        <li> Post ID:{{$post->id}} | Creato il : {{$post->created_at}}</li>
        @endforeach
</ul>
@endif
</body>
</html>