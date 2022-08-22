<?php

require_once('chat.controller.php');

// Los datos de conexión a la DB están parametrizados, de esa forma no hace falta modificar archivo por archivo en caso de migración.
// Cualquier base de datos que sea compatible con phpMyAdmin, se puede usar.

define('BASE_URL', '//'.$_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . dirname($_SERVER['PHP_SELF']).'/');

/* datos de conexión a la base de datos */

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'pokemontcgdb');

/* El coso para la sesión */
session_start();

/* Esto permite que no se pueda acceder a los PHP directamente desde el navegador */
if(!empty($_GET['action'])){
    $action = $_GET['action'];
}
else{
    $action = '';
}
$params = explode('/', $action);

$chatController = new ChatController();

function deleteQuery($path) {
    $path = explode('&', $path);
    return $path[0];
}

/* Acá se puede hacer un case para cada una de las acciones que se puedan hacer */
/* Para este código de muestra, no hace falta porque es de muestra */
/* Dependiendo lo que el navegador tenga en el URI, se ejecuta una acción correspondiente */
switch($action[0]){
    // Acá podemos agregar las distintas salas de chat, si no la agregamos acá y tratamos de acceder a ellas te lleva a la sala principal.
    // La verificación de permisos se hace en el controlador.
    case 'LG':
        $chatController->initializeChat('LG');
        break;
    case 'staff':
        $chatController->initializeChat('staff');   
        break;
    default:
        $chatController->initializeChat();
        break;
}