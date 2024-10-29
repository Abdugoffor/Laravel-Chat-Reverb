<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite(['resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body class="bg-secondary">
    <div class="container">
        <div class="row">
            <div class="col-4">
                <ul class="list-group">
                    {{ auth()->user()->name }}
                    @foreach ($users as $user)
                        <li class="list-group-item">
                            <a href="/messages/{{ $user->id }}">{{ $user->name }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="col-8">
                <h2 class="text-center">{{ $chatUser->name }}</h2>
                <div class="card">
                    <div class="card-body">
                        <ul class="list-group" id="messages">
                            @foreach ($messages as $message)
                                <li class="list-group-item">
                                    <p>{{ $message->from->name }}:
                                        {{ $message->text }}
                                        <span
                                            class="badge rounded-pill text-bg-success">{{ $message->created_at }}</span>
                                    </p>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="card-footer">
                        <form action="{{ route('messages.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="to_id" value="{{ $chatUser->id }}"\>
                            <input type="text" name="text" class="form-control" placeholder="Enter message...">

                            <button type="submit" class="btn btn-primary mt-2">Send</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    window.currentUserId = {{ auth()->id() }};
    window.chatUserId = {{ $chatUser->id }};
</script>

</html>
