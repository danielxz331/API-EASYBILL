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
        <h1>Restablecer contraseña</h1>
        <p>Has solicitado restablecer tu contraseña. Haz clic en el siguiente enlace para crear una nueva contraseña:</p>
        <a class="button" href="{{ $resetPasswordUrl }}">Restablecer contraseña</a>
        <p>Si no has solicitado restablecer tu contraseña, puedes ignorar este correo electrónico.</p>
    </div>
</body>
</html>
