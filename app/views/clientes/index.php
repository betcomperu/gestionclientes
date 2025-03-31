<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Clientes</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
</head>
<body class="bg-gray-200 flex flex-col min-h-screen">
    <div class="container mx-auto mt-5 shadow bg-white p-10 text-base mb-10">
        <div class="flex justify-between items-center mb-5">
            <h2 class="text-2xl font-bold">Lista de Clientes</h2>
            <a href="/create" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Agregar Cliente</a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b">ID</th>
                        <th class="py-2 px-4 border-b">Nombre</th>
                        <th class="py-2 px-4 border-b">Apellido</th>
                        <th class="py-2 px-4 border-b">Correo</th>
                        <th class="py-2 px-4 border-b">Ciudad</th>
                        <th class="py-2 px-4 border-b">Fecha de Nacimiento</th>
                        <th class="py-2 px-4 border-b">Usuario</th>
                        <th class="py-2 px-4 border-b">Foto</th>
                        <th class="py-2 px-4 border-b">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($clientes as $cliente): ?>
                    <tr>
                        <td class="py-2 px-4 border-b text-center"><?php echo $cliente['id']; ?></td>
                        <td class="py-2 px-4 border-b text-center"><?php echo $cliente['nombre']; ?></td>
                        <td class="py-2 px-4 border-b text-center"><?php echo $cliente['apellido']; ?></td>
                        <td class="py-2 px-4 border-b text-center"><?php echo $cliente['correo']; ?></td>
                        <td class="py-2 px-4 border-b text-center"><?php echo $cliente['ciudad']; ?></td>
                        <td class="py-2 px-4 border-b text-center"><?php echo $cliente['fecha_nacimiento']; ?></td>
                        <td class="py-2 px-4 border-b text-center"><?php echo $cliente['usuario']; ?></td>
                        <td class="py-2 px-4 border-b text-center">
                            <?php if (!empty($cliente['foto'])): ?>
                                <img src="/public/<?php echo $cliente['foto']; ?>" alt="Foto de <?php echo $cliente['nombre']; ?>" class="w-12 h-12 rounded-full mx-auto">
                            <?php else: ?>
                                <img src="/public/img/default.jpg" alt="Foto Pendiente" class="w-12 h-12 rounded-full mx-auto"> 
                            <?php endif; ?>
                        </td>
                        <td class="py-2 px-4 border-b text-center">
                            <a href="/show/<?php echo $cliente['id']; ?>" class="bg-green-500 text-white px-2 py-1 rounded hover:bg-green-600 text-xs">Ver</a>
                            <a href="/edit/<?php echo $cliente['id']; ?>" class="bg-yellow-500 text-white px-2 py-1 rounded hover:bg-yellow-600 text-xs">Editar</a>
                            <a href="/delete/<?php echo $cliente['id']; ?>" class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600 text-xs">Eliminar</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>