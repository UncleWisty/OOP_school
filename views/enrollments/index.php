<!DOCTYPE html>
<html lang="es">
<head><title>Matrículas</title></head>
<body>
    <h1>Matrículas</h1>
    <a href="/enrollments/create">Nueva Matrícula</a>
    <ul>
        <?php foreach ($enrollments as $enrollment): ?>
            <li>
                ID: <?= htmlspecialchars($enrollment['id']) ?> | 
                Alumno ID: <?= htmlspecialchars($enrollment['student_id']) ?> | 
                Año: <?= htmlspecialchars($enrollment['academic_year']) ?> | 
                Tipo: <?= htmlspecialchars($enrollment['type']) ?>
            </li>
        <?php endforeach; ?>
    </ul>
    <br><a href="/">Volver</a>
</body>
</html>