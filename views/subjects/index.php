<!DOCTYPE html>
<html lang="es">
<head><title>Asignaturas</title></head>
<body>
    <h1>Asignaturas</h1>
    <a href="/subjects/create">Crear Asignatura</a>
    <ul>
        <?php foreach ($subjects as $subject): ?>
            <li><?= htmlspecialchars($subject['name']) ?> (Curso ID: <?= htmlspecialchars($subject['course_id']) ?>)</li>
        <?php endforeach; ?>
    </ul>
    <br><a href="/">Volver</a>
</body>
</html>