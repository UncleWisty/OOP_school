<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Profesor</title>
</head>
<body>
    <h1>Nuevo Profesor</h1>
    
    <?php if (isset($error)): ?>
        <p style="color: red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form action="/teachers" method="POST">
        <label for="name">Nombre:</label>
        <input type="text" name="name" id="name" required>
        <button type="submit">Guardar</button>
    </form>
    
    <br>
    <a href="/teachers">Cancelar</a>
</body>
</html>