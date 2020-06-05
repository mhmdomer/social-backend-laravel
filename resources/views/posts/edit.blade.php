<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <select name="category">
            @foreach ($categories as $category)
            <option value="{{ $category->id }}" {{ $category->id == $post->category_id ? 'selected' : '' }}>
                {{ $category->name }}
            </option>
            @endforeach
        </select>
        <input type="text" name="body" value="{{ $post->body }}">
        <input type="file" name="image">
        <button type="submit">edit</button>
    </form>
</body>
</html>
