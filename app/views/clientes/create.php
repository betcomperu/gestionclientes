<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<div class="container mx-auto mt-5 shadow bg-white p-10 text-base mb-10 max-w-2xl">
    <h2 class="text-2xl font-bold mb-5">Crear Cliente</h2>
    <form action="/store" method="POST" enctype="multipart/form-data"> <!-- Importante: enctype para la foto -->

        <div class="mb-4">
            <label for="nombre" class="block text-gray-700">Nombre:</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo isset($cliente['nombre']) ? htmlspecialchars($cliente['nombre']) : ''; ?>" class="w-full px-3 py-2 border rounded" required>
        </div>
        <div class="mb-4">
            <label for="apellido" class="block text-gray-700">Apellido:</label>
            <input type="text" id="apellido" name="apellido" value="<?php echo isset($cliente['apellido']) ? htmlspecialchars($cliente['apellido']) : ''; ?>" class="w-full px-3 py-2 border rounded" required>
        </div>
        <div class="mb-4">
            <label for="correo" class="block text-gray-700">Correo:</label>
            <input type="email" id="correo" name="correo" value="<?php echo isset($cliente['correo']) ? htmlspecialchars($cliente['correo']) : ''; ?>" class="w-full px-3 py-2 border rounded" required>
        </div>
        <div class="mb-4">
            <label for="ciudad" class="block text-gray-700">Ciudad:</label>
            <input type="text" id="ciudad" name="ciudad" value="<?php echo isset($cliente['ciudad']) ? htmlspecialchars($cliente['ciudad']) : ''; ?>" class="w-full px-3 py-2 border rounded">
        </div>
        <div class="mb-4">
            <label for="fecha_nacimiento" class="block text-gray-700">Fecha de Nacimiento:</label>
            <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" value="<?php echo isset($cliente['fecha_nacimiento']) ? htmlspecialchars($cliente['fecha_nacimiento']) : ''; ?>" class="w-full px-3 py-2 border rounded">
        </div>
        <div class="mb-4">
            <label for="usuario" class="block text-gray-700">Usuario:</label>
            <input type="text" id="usuario" name="usuario" value="<?php echo isset($cliente['usuario']) ? htmlspecialchars($cliente['usuario']) : ''; ?>" class="w-full px-3 py-2 border rounded" required>
        </div>
        <div class="mb-4">
            <label for="clave" class="block text-gray-700">Clave:</label>
            <input type="password" id="clave" name="clave" class="w-full px-3 py-2 border rounded" required>
        </div>

        <!-- Subir Imagen -->
        <div class="mb-4">
            <label for="foto" class="block text-gray-700">Foto:</label>
            <input type="file" id="foto" name="foto" class="w-full px-3 py-2 border rounded">
        </div>

        <div class="flex justify-between">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Guardar</button>
            <a href="/" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Volver</a>
        </div>
    </form>
</div>
<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
