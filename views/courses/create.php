<!DOCTYPE html>
<html lang="es">
<head><title>Crear Curso</title></head>
<body>
    <h1>Nuevo Curso</h1>
    <?php if (isset($error)): ?><p style="color:red;"><?= htmlspecialchars($error) ?></p><?php endif; ?>
    <form action="/courses" method="POST">
        <label>Nombre:</label>
        <input type="text" name="name" required>
        <button type="submit">Guardar</button>
    </form>
    <br><a href="/courses">Cancelar</a>
</body>
</html>