<?php

require_once('chat.controller.php');
require_once('libs/Smarty.class.php');

class ChatView {
    private $smarty;
    
    function __construct() {
        $this->smarty = new Smarty();
    }
    
    public function showChat($datos) {
        // La variable $datos es un array con los datos de la sala de chat.
        // Trae usuarios, mensajes, fechas, etc.
        // Acá hay que usar una serie de assign para pasar los datos a la vista.
        // Pero como no tengo hecha la vista, sería un lío y no soy bueno imaginando jajaja
        // Así que imaginátelo vos (?)
        $this->smarty->assign('datos', $datos);
        $this->smarty->display('chat.tpl');
    }
}
?>