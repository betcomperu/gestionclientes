<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container mx-auto mt-5 shadow bg-white p-10 text-base mb-10 max-w-2xl">
    <h2 class="text-2xl font-bold mb-5">Editar Cliente</h2>
    <form action="/update/<?php echo $cliente->id; ?>" method="POST" enctype="multipart/form-data">

        <!-- Eliminado el campo _method -->

        <div class="mb-4">
            <label for="nombre" class="block text-gray-700">Nombre:</label>
            <input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($cliente->nombre) ?>" class="w-full px-3 py-2 border rounded" required>
        </div>
        
        <div class="mb-4">
            <label for="apellido" class="block text-gray-700">Apellido:</label>
            <input type="text" id="apellido" name="apellido" value="<?= htmlspecialchars($cliente->apellido) ?>" class="w-full px-3 py-2 border rounded" required>
        </div>
        
        <div class="mb-4">
            <label for="correo" class="block text-gray-700">Correo:</label>
            <input type="email" id="correo" name="correo" value="<?= htmlspecialchars($cliente->correo) ?>" class="w-full px-3 py-2 border rounded" required>
        </div>
        
        <div class="mb-4">
            <label for="ciudad" class="block text-gray-700">Ciudad:</label>
            <input type="text" id="ciudad" name="ciudad" value="<?= htmlspecialchars($cliente->ciudad) ?>" class="w-full px-3 py-2 border rounded">
        </div>
        
        <div class="mb-4">
            <label for="fecha_nacimiento" class="block text-gray-700">Fecha de Nacimiento:</label>
            <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" value="<?= htmlspecialchars($cliente->fecha_nacimiento) ?>" class="w-full px-3 py-2 border rounded">
        </div>
        
        <div class="mb-4">
            <label for="usuario" class="block text-gray-700 text-sm font-bold mb-2">Usuario:</label>
            <input type="text" name="usuario" id="usuario" value="<?php echo htmlspecialchars($cliente->usuario ?? ''); ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>
        
        <div class="mb-4">
            <label for="clave" class="block text-gray-700">Nueva Clave (opcional):</label>
            <input type="password" id="clave" name="clave" class="w-full px-3 py-2 border rounded">
        </div>
        
        <div class="mb-4">
            <label for="foto" class="block text-gray-700">Foto:</label>
            <input type="file" id="foto" name="foto" class="w-full px-3 py-2 border rounded">
            <?php if (!empty($cliente->foto)) : ?>
                <div class="mt-2">
                    <img src="/<?= htmlspecialchars($cliente->foto) ?>" alt="Foto de <?= htmlspecialchars($cliente->nombre) ?>" class="w-32 h-32 object-cover rounded">
                    <div>
                        <input type="checkbox" id="eliminar_foto" name="eliminar_foto">
                        <label for="eliminar_foto">Eliminar foto</label>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="flex justify-between">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Actualizar</button>
            <a href="/" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Volver a la lista</a>
        </div>
    </form>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>