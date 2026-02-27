<!DOCTYPE html>
<html lang="es">
<head><title>Crear Asignatura</title></head>
<body>
    <h1>Nueva Asignatura</h1>
    <?php if (isset($error)): ?><p style="color:red;"><?= htmlspecialchars($error) ?></p><?php endif; ?>
    <form action="/subjects" method="POST">
        <label>Nombre:</label>
        <input type="text" name="name" required><br><br>
        <label>Curso:</label>
        <select name="course_id" required>
            <?php foreach ($courses as $course): ?>
                <option value="<?= htmlspecialchars($course['id']) ?>"><?= htmlspecialchars($course['name']) ?></option>
            <?php endforeach; ?>
        </select><br><br>
        <button type="submit">Guardar</button>
    </form>
    <br><a href="/subjects">Cancelar</a>
</body>
</html>