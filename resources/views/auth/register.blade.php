<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Validation Application' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <main>
        <div class="toast-container position-fixed end-0 p-3">
            @if (session('message'))
                <div class="toast align-items-center show" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            {{ session('message') }}
                        </div>
                        <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast"
                            aria-label="Close"></button>
                    </div>
                </div>
            @endif
        </div>

        <div class="container">
            <div class="pt-5">
                <div class="border mx-auto w-50 p-5">
                    <div class="mb-3">
                        <h1>Register</h1>
                        <hr>
                    </div>
                    <form method="post">
                        @csrf
                        <x-inputs.floating type="email" placeholder="Email Address" value="{{ old('email', '') }}"
                            name="email" message="{{ $errors->first('email') }}" required />
                        <x-inputs.floating value="{{ old('name', '') }}" type="text" placeholder="Nama"
                            name="name" message="{{ $errors->first('name') }}" required />
                        <x-inputs.floating type="password" placeholder="Password" name="password"
                            message="{{ $errors->first('password') }}" required />

                        <div>
                            <button class="btn btn-success" type="submit">Save</button>
                        </div>
                        <a href="{{ route('login') }}" class="">Sudah punya akun</a>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>

</body>

</html>
