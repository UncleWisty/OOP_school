<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Alumnos</title>
</head>
<body>
    <h1>Lista de Alumnos</h1>
    <a href="/students/create">Crear Nuevo Alumno</a>
    <ul>
        <?php foreach ($students as $student): ?>
            <li><?= htmlspecialchars($student['id']) ?> - <?= htmlspecialchars($student['email']) ?></li>
        <?php endforeach; ?>
    </ul>
    <br>
    <a href="/">Volver al inicio</a>
</body>
</html>