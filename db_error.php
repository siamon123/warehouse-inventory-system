<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error de Conexión - Warehouse Inventory System</title>
    <link rel="stylesheet" href="libs/css/db_error.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="icon-wrapper">
            <svg class="icon" width="80" height="80" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M4 6C4 4.34315 7.58172 3 12 3C16.4183 3 20 4.34315 20 6M4 6C4 7.65685 7.58172 9 12 9C16.4183 9 20 7.65685 20 6M4 6V18C4 19.6569 7.58172 21 12 21C16.4183 21 20 19.6569 20 18V6M12 15C7.58172 15 4 13.6569 4 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M17 17L21 21M21 17L17 21" stroke="#ef4444" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>
        <h1>Sin Conexión</h1>
        <p>No se pudo establecer la conexión con la base de datos. Por favor, verifica tu configuración.</p>
        
        <?php if (isset($error_message)): ?>
        <div class="error-details">
            <strong>Detalles técnicos:</strong><br>
            <?php echo htmlspecialchars($error_message); ?>
        </div>
        <?php endif; ?>

        <a href="index.php" class="btn">
            Reintentar conexión
        </a>
    </div>
</body>
</html>
