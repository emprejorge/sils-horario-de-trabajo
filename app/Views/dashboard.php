<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>

    <h2>Bienvenido <?= esc($user['name']) ?></h2>
    <p>Email: <?= esc($user['email']) ?></p>

    <a href="/logout">Cerrar sesión</a>

</body>
</html>