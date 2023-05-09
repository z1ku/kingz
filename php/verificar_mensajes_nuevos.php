<?php
    require_once "funciones.php";

    $id_partida=$_GET['id_partida'];

    $todos_mensajes=todos_mensajes_partida($id_partida);
    $num_mensajes=count($todos_mensajes);

    $info["total"]=$num_mensajes;
    $info["mensajes"]=$todos_mensajes;

    echo json_encode($info);
?>