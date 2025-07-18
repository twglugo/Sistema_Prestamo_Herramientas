<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="assets/css/login.css">
    <title>Login - Sistema Préstamo Herramientas</title>
    
</head>
<body>
    <div class="login-container">
        <h2>Iniciar Sesión</h2>
        <form method="POST" action="index.php?ruta=login">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="cedula">Cédula:</label>
            <input type="password" id="cedula" name="cedula" required>

            

            <button type="submit">Ingresar</button>
        </form>
        <?php if (isset($error)): ?>
            <div class="error"> <?= htmlspecialchars($error) ?> </div>
        <?php endif; ?>
        
    </div>
</body>
</html>
