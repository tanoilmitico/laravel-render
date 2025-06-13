<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width={device-width}, initial-scale=1.0">
    <title>{{$post->title}}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"></head>
<body>
    <div class ="container mt-5">
        <h1> {{$post-> title}}</h1>
        <p class ="text-muted"> Creato il: {{$post->created_at->format ('d-m-Y H:i')}}</p>
        <div class ="mt-4">
            <p> {{ $post-> content}} </p>
</div>

</div>

</body>
</html>