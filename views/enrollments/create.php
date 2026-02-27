<!DOCTYPE html>
<html lang="es">
<head><title>Crear Matrícula</title></head>
<body>
    <h1>Nueva Matrícula</h1>
    <?php if (isset($error)): ?><p style="color:red;"><?= htmlspecialchars($error) ?></p><?php endif; ?>
    <form action="/enrollments" method="POST">
        <label>Alumno:</label>
        <select name="student_id" required>
            <?php foreach ($students as $student): ?>
                <option value="<?= htmlspecialchars($student['id']) ?>"><?= htmlspecialchars($student['email']) ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <label>Año Académico (Inicio):</label>
        <input type="number" name="start_year" value="<?= date('Y') ?>" required>
        <label>(Fin):</label>
        <input type="number" name="end_year" value="<?= date('Y') + 1 ?>" required><br><br>

        <label>Tipo de Matrícula:</label>
        <select name="type" required>
            <option value="full">Curso Completo</option>
            <option value="partial">Asignaturas Sueltas</option>
        </select><br><br>

        <label>Curso (si es completo):</label>
        <select name="course_id">
            <option value="">-- Seleccionar --</option>
            <?php foreach ($courses as $course): ?>
                <option value="<?= htmlspecialchars($course['id']) ?>"><?= htmlspecialchars($course['name']) ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <label>Asignaturas (si es parcial):</label><br>
        <?php foreach ($subjects as $subject): ?>
            <input type="checkbox" name="subject_ids[]" value="<?= htmlspecialchars($subject['id']) ?>">
            <?= htmlspecialchars($subject['name']) ?><br>
        <?php endforeach; ?>
        <br>

        <button type="submit">Guardar</button>
    </form>
    <br><a href="/enrollments">Cancelar</a>
</body>
</html>