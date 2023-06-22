<!DOCTYPE html>
<html>
<head>
    <title>Restablecer contraseña</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f8f8;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .error {
            color: #ff0000;
            margin-bottom: 20px;
        }
        .button {
            display: inline-block;
            background-color: #2d85ec;
            color: #ffffff;
            text-decoration: none;
            padding: 15px 30px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
        }
        .button:hover {
            background-color: #2468b8;
        }
        @media (max-width: 600px) {
            .container {
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Restablecer contraseña</h1>
        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="email" value="{{ $email }}">

            <div>
                <label for="password">Nueva contraseña</label>
                <input type="password" id="password" name="password" required>
                @if ($errors->has('password'))
                    <span class="error">{{ $errors->first('password') }}</span>
                @endif
            </div>

            <div>
                <label for="password_confirmation">Confirmar contraseña</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required>
                @if ($errors->has('password_confirmation'))
                    <span class="error">{{ $errors->first('password_confirmation') }}</span>
                @endif
            </div>

            <div>
                <button class="button" type="submit">Restablecer contraseña</button>
            </div>
        </form>
    </div>
</body>
</html>
