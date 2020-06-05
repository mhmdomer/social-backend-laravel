<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->
    <style>
        html,
        body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links>a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }

    </style>
</head>
<body>
    <div class="flex-center position-ref full-height">
        @if(count($errors) > 0)
        @foreach($errors->all() as $error)
        <div class="lg:mx-12 mx-4 m-2 m-0 px-4 md:px-12 py-5 rounded bg-red-200 text-red-600">
            <li>{!! $error !!}</li>
        </div>
        @endforeach
        @endif

        @if (Session::has('success'))
        <div class="lg:mx-12 mx-4 m-2 m-0 px-4 md:px-12 py-5 rounded bg-green-200 text-green-600">
            {{ Session::get('success') }}
        </div>
        @endif
        @if (Session::has('error'))
        <div class="lg:mx-12 mx-4 m-2 m-0 px-4 md:px-12 py-5 rounded bg-red-200 text-red-600">
            <strong>Errors:</strong>
            {{ Session::get('error') }}
        </div>
        @endif

        @if (Route::has('login'))
        <div class="top-right links">
            @auth
            <a href="{{ url('/home') }}">Home</a>
            @else
            <a href="{{ route('login') }}">Login</a>

            @if (Route::has('register'))
            <a href="{{ route('register') }}">Register</a>
            @endif
            @endauth
        </div>
        @endif

        <div class="content">
            <div class="title m-b-md">
                Laravel
            </div>

            <div>
                <form action="{{ route('store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <select name="category">
                        @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{$category->name}}</option>
                        @endforeach
                    </select>
                    <input type="text" name="body">
                    <input type="file" name="image">
                    <button type="submit">submit</button>
                </form>
            </div>
            @foreach ($posts as $post)
            <div>
                @if ($post->image)
                <a href="{{ route('posts.show', $post->id) }}"><img src="{{ $post->image }}" alt=""></a>
                @endif
                @if ($post->body)
                <a href="{{ route('posts.show', $post->id) }}">{{ $post->body }}</a>
                @endif
                <form action="{{ route('destroy', $post->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit">delete</button>
                </form>
            </div>
            @endforeach
        </div>
    </div>
</body>
</html>
