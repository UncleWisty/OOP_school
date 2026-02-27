<!DOCTYPE html>
<html lang="es">
<head><title>Cursos</title></head>
<body>
    <h1>Cursos</h1>
    <a href="/courses/create">Crear Curso</a>
    <ul>
        <?php foreach ($courses as $course): ?>
            <li><?= htmlspecialchars($course['id']) ?> - <?= htmlspecialchars($course['name']) ?></li>
        <?php endforeach; ?>
    </ul>
    <br><a href="/">Volver</a>
</body>
</html>