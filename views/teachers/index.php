<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Profesores</title>
</head>
<body>
    <h1>Lista de Profesores</h1>
    <a href="/teachers/create">Crear Nuevo Profesor</a>
    <ul>
        <?php foreach ($teachers as $teacher): ?>
            <li><?= htmlspecialchars($teacher['id']) ?> - <?= htmlspecialchars($teacher['name']) ?></li>
        <?php endforeach; ?>
    </ul>
    <br>
    <a href="/">Volver al inicio</a>
</body>
</html>