<!DOCTYPE html>
<html>
<head>
    <title>Restablecer contraseña</title>
</head>
<body>
    <h1>Restablecer contraseña</h1>
    <form method="POST" action="{{ route('password.update') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">
        <input type="hidden" name="email" value="{{ $email }}">

        <div>
            <label for="password">Nueva contraseña</label>
            <input type="password" id="password" name="password" required>
        </div>

        <div>
            <label for="password_confirmation">Confirmar contraseña</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required>
        </div>

        <div>
            <button type="submit">Restablecer contraseña</button>
        </div>
    </form>
</body>
</html>
