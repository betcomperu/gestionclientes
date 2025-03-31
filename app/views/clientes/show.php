<div class="container mx-auto mt-5 shadow bg-white p-10 text-base max-w-xl mb-10 flex-grow">
    <h2 class="text-2xl font-bold text-center mb-5"><?php echo $titulo; ?></h2>
    <div class="flex flex-col items-center">
        <?php if (isset($cliente->foto) && !empty($cliente->foto)) { ?>
            <img src="<?php echo "http://gestionclientes.com/" . $cliente->foto; ?>" alt="Profile Picture" class="w-48 h-48 rounded-full mb-4 shadow-lg">
        <?php } ?>
        <div class="space-y-4 text-center">
            <div>
                <p><strong>ID:</strong> <?php echo (isset($cliente->id) && !empty($cliente->id)) ? $cliente->id : ''; ?></p>
            </div>
            <div>
                <p><strong>Nombre:</strong> <?php echo (isset($cliente->nombre) && !empty($cliente->nombre)) ? $cliente->nombre : ''; ?></p>
            </div>
            <div>
                <p><strong>Apellido:</strong> <?php echo (isset($cliente->apellido) && !empty($cliente->apellido)) ? $cliente->apellido : ''; ?></p>
            </div>
            <div>
                <p><strong>Correo:</strong> <?php echo (isset($cliente->correo) && !empty($cliente->correo)) ? $cliente->correo : ''; ?></p>
            </div>
            <div>
                <p><strong>Ciudad:</strong> <?php echo (isset($cliente->ciudad) && !empty($cliente->ciudad)) ? $cliente->ciudad : ''; ?></p>
            </div>
            <div>
                <p><strong>Fecha de Nacimiento:</strong> <?php echo (isset($cliente->fecha_nacimiento) && !empty($cliente->fecha_nacimiento)) ? $cliente->fecha_nacimiento : ''; ?></p>
            </div>
        </div>
    </div>
    <div class="mt-8 text-center">
        <a href="/" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">Volver a la lista</a>
    </div>
</div>