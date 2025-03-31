<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SISTEMA BETCOM | <?php echo $titulo; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
</head>

<body class="bg-gray-100">

    <div class="container mx-auto mt-20 shadow bg-white p-10 text-base mb-10 max-w-md rounded">
        <h2 class="text-2xl font-bold mb-6 text-center">Iniciar Sesión</h2>

        <form action="/login" method="POST" class="space-y-4">
            <!-- CSRF Token -->
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token'] ?? ''; ?>">

            <div>
                <label for="usuario" class="block mb-1 font-medium">Usuario</label>
                <input type="text" id="usuario" name="usuario" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label for="clave" class="block mb-1 font-medium">Contraseña</label>
                <input type="password" id="clave" name="clave" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <button type="submit"
                    class="w-full bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Iniciar Sesión
                </button>
            </div>
        </form>

        <!-- Enlace para recuperar contraseña -->
        <div class="mt-4 text-center">
            <a href="/recuperar" class="text-blue-500 hover:underline">¿Olvidaste tu contraseña?</a>
        </div>

        <!-- Mostrar error si existe -->
        <?php if (isset($error)): ?>
            <p class="mt-4 text-red-500 text-center"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
    </div>

</body>
</html>
