<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SISTEMA BETCOM | <?php echo $titulo; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
</head>
<body class="bg-gray-200 flex flex-col min-h-screen">
    <div class="flex-grow">
        <header class="sticky top-0 p-5 border-b bg-gray-800 shadow z-50">
            <div class="container mx-auto flex justify-between items-center">
                <h1 class="text-4xl font-bold text-gray-200"><a href="/">GestoBet</a></h1>
                <nav class="flex gap-2 items-center">
                    <?php if (isset($_SESSION['cliente_id'])): ?>
                        <a class="font-bold uppercase text-gray-600 text-sm" href="/logout">Salir</a>
                    <?php else: ?>
                        <a class="font-bold uppercase text-gray-600 text-sm" href="/login">Login</a>
                        <a class="font-bold uppercase text-gray-600 text-sm" href="/create">Crear cuenta</a>
                    <?php endif; ?>
                </nav>
            </div>
        </header>
        <div class="container mx-auto mt-10 text-center space-y-3">
            <h1 class="text-4xl font-extrabold text-indigo-600 mb-10">
                Crud con MVC - Bienvenido(a) 
                <?php if (isset($_SESSION['cliente_nombre'])): ?>
                    <?php echo $_SESSION['cliente_nombre']; ?>
                <?php endif; ?>
            </h1>
        </div>