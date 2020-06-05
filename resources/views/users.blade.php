<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    @foreach ($users as $user)
        <div>
            <a href="{{ route('users.edit', $user->id) }}">
                @if ($user->image)
                <img src="{{ $user->image }}" alt="">
                @endif
                <li>{{ $user->name }}</li>
            </a>
        </div>
    @endforeach
</body>
</html>
