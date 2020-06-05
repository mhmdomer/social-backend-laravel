<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    @if(count($errors) > 0)
    @foreach($errors->all() as $error)
    <div class="lg:mx-12 mx-4 m-2 m-0 px-4 md:px-12 py-5 rounded bg-red-200 text-red-600">
        <li>{!! $error !!}</li>
    </div>
    @endforeach
    @endif

    <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input type="text" name="name" value="{{ $user->name }}">
        <input type="file" name="image">
        <button type="submit">update</button>
    </form>
</body>
</html>
