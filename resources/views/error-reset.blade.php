<!DOCTYPE html>
<html>
<head>
    <title>Error de restablecimiento</title>
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
            text-align: center;
        }
        .message {
            padding: 20px;
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            border-radius: 5px;
            margin: 20px 0;
        }
        .button {
            display: inline-block;
            background-color: #2d85ec;
            color: #ffffff;
            text-decoration: none;
            padding: 15px 30px;
            border-radius: 5px;
            margin: 10px 0px;
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
        <h1>Error al restablecer contraseña</h1>
        <p class="message">¡Ha ocurrido un error al restablecer la contraseña!</p>
        <a class="button" href="{{ route('password.request') }}">Intentar de nuevo</a>
    </div>
</body>
</html>
