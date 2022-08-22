<?php

class ChatModel {
    private $db;
    
    public function __construct() {
        // Esta variable lo que permite es no sólo limitar la cantidad de mensajes que se cargan al abrir el chat, sino que cuando se corre pruneMessages() borra todos los que no se muestran.
        // Esto es para evitar que se carguen mensajes que ya no deberían mostrarse.   
        // Obviamente, se puede cambiar el valor de esta variable para que se muestren más o menos mensajes, aunque no se recomienda que sean más de 100.
        $limiteMensajes = 100;

        $this->db = new PDO('mysql:host='. DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8', DB_USER, DB_PASS);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    function verifyUserRank($usuario, $rank) {
        $query = $this->db->prepare('SELECT rango FROM usuarios WHERE usuario = :usuario');
        $query->bindValue(':usuario', $usuario);
        $query->execute();
        $result = $query->fetch();
        if($result == $rank) {
            return true;
        }
        else {
            return false;
        }
    }
    
    // El = es para que por defecto se lea el canal 'general', pero en caso de necesitar otros canales se puede pasar uno distinto.
    // Vendría siendo como un parámetro "opcional".
    function getAllMessages($canal = 'general') {
        // Obtenemos todos los mensajes de la base de datos.
        $query = $this->db->prepare('SELECT * FROM messages WHERE canal = :canal ORDER BY id DESC LIMIT :limiteMensajes');
        $query->execute([':canal' => $canal, ':limiteMensajes' => $limiteMensajes]);

        $messages = $query->fetchAll(PDO::FETCH_OBJ);
    }
    
    function getAllMessagesByUser($user, $canal = 'general') {
        // Esta función obtiene todos los mensajes de un usuario.
        $query = $this->db->prepare('SELECT * FROM messages WHERE user = :user');
        $query->execute([':user' => $user]);
        
        $messages = $query->fetchAll(PDO::FETCH_OBJ);
        
        return $messages;
    }
    
    function getAllMessagesByDate($date) {
        // Esta función obtiene todos los mensajes de una fecha dada.
        $query = $this->db->prepare('SELECT * FROM messages WHERE date = :date');
        $query->execute([':date' => $date]);
        
        $messages = $query->fetchAll(PDO::FETCH_OBJ);
        
        return $messages;
    }
    
    function pruneMessages() {
        // Esta es la función que borra los mensajes antiguos.
        // Lo ideal es que se ejecute cada 24 horas.
        // Lo recontra ideal sería que en vez de sólo borrarlos los mande a un archivo de texto, y luego borrarlos de la base de datos.
        $query = $this->db->prepare('DELETE FROM messages WHERE `messages`.`id` < (SELECT id FROM (SELECT id FROM messages ORDER BY id DESC LIMIT 1 OFFSET ' . $limiteMensajes . ') AS pruned)');
        $query->execute();
    }
}