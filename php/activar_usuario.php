<?php
    require_once "funciones.php";

    if(isset($_POST['desactivar'])){
        $con=conectarServidor();

        $id_usuario=$_POST['id_usuario'];

        $sentencia=$con->query("UPDATE usuario set estado=0,buscando=0,en_partida=0 where id=$id_usuario");

        $con->close();
        header("Location:panel_usuarios.php");
    }else if(isset($_POST['activar'])){
        $con=conectarServidor();

        $id_usuario=$_POST['id_usuario'];

        $sentencia=$con->query("UPDATE usuario set estado=1 where id=$id_usuario");

        $con->close();
        header("Location:panel_usuarios.php");
    }else{
        header("Location:../index.php");
    }
?>