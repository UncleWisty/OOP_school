<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Alumno</title>
</head>
<body>
    <h1>Nuevo Alumno</h1>
    
    <?php if (isset($error)): ?>
        <p style="color: red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form action="/students" method="POST">
        <label for="email">Email:</label>
        <input type="text" name="email" id="email" required>
        <button type="submit">Guardar</button>
    </form>
    
    <br>
    <a href="/students">Cancelar</a>
</body>
</html>