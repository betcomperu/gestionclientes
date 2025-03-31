<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$titulo = "Dashboard";

// Convertir la sesión en objeto para facilidad
$cliente = (object) $_SESSION;
?>

<div class="container mx-auto mt-5 shadow bg-white p-10 text-base max-w-4xl mb-10 flex">
    <div class="flex-grow">
        <h2 class="text-2xl font-bold text-center mb-5"><?php echo $titulo; ?></h2>
        <div class="space-y-4">
            <div>
                <p><strong>ID:</strong> <?php echo isset($cliente->id) ? $cliente->id : ''; ?></p>
            </div>
            <div>
                <p><strong>Nombre:</strong> <?php echo isset($cliente->nombre) ? $cliente->nombre : ''; ?></p>
            </div>
            <div>
                <p><strong>Apellido:</strong> <?php echo isset($cliente->apellido) ? $cliente->apellido : ''; ?></p>
            </div>
            <div>
                <p><strong>Correo:</strong> <?php echo isset($cliente->correo) ? $cliente->correo : ''; ?></p>
            </div>
            <div>
                <p><strong>Ciudad:</strong> <?php echo isset($cliente->ciudad) ? $cliente->ciudad : ''; ?></p>
            </div>
            <div>
                <p><strong>Fecha de Nacimiento:</strong> <?php echo isset($cliente->fecha_nacimiento) ? $cliente->fecha_nacimiento : ''; ?></p>
            </div>
            <div class="mt-8">
                <a href="/logout" class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded">Cerrar Sesión</a>
            </div>
        </div>
    </div>

    <!-- Foto del cliente a la derecha -->
    <div class="ml-10 flex-shrink-0">
        <?php if (isset($cliente->foto) && !empty($cliente->foto)) { ?>
            <img src="<?php echo "http://gestionclientes.com/" . $cliente->foto; ?>" 
                 alt="Foto de perfil" 
                 class="w-48 h-48 rounded-full shadow-lg object-cover">
        <?php } else { ?>
            <img src="<?php echo "http://gestionclientes.com/"."/img/default.jpg"; ?>" 
                 alt="Sin foto" 
                 class="w-48 h-48 rounded-full shadow-lg object-cover">
        <?php } ?>
    </div>
</div>
