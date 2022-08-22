<?php

require_once('chat.view.php');
require_once('chat.model.php');

// Al hacerlo en una clase, no se puede ejecutar directamente aunque se ingrese al URI del archivo.
// (Se puede pero si el código está encapsulado dentro de la class, no hace nada.)
// No hace falta hacer esa chanchada de $_SESSION['encriptado'] y die().
// Sé que a vos te encanta, Ode, pero no, está mal (?)

class ChatController {
   public function __construct() {
      $this->view = new ChatView();
      $this->model = new ChatModel();
   }

   function initializeChat($room = 'general') {
      switch($room){
         case 'LG':
            // Devuelve true o false dependiendo si el usuario tiene permisos para entrar a la sala.
            // En Chirto se usa un valor numérico si no recuerdo mal, pero se puede adaptar fácilmente.
            $permisos = $this->model->verifyUserRank($usuario, 'LG');
            if($permisos){
               $datos = $this->model->getAllMessages($room);
               $this->view->showChat($datos);
            }
            else{
               echo 'No tienes permisos para entrar a esta sala';
            }
            break;
         case 'staff':
            $permisos = $this->model->verifyUserRank($usuario, 'staff');
            if($permisos){
               $datos = $this->model->getAllMessages($room);
               $this->view->showChat($datos);
            }
            else{
               echo 'No tienes permisos para entrar a esta sala';
            }
            break;   
         default:
         // Si no se especifica una sala, se entra a la sala general.
            $permisos = $this->model->verifyUserRank($usuario, 'general');
            if($permisos){
               $datos = $this->model->getAllMessages($room);
               $this->view->showChat($datos);
            }
            else{
               echo 'No tienes permisos para entrar a esta sala';
            }
            break;   
      }
   }
}