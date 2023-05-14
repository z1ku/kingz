<?php
    require_once "funciones.php";

    if(isset($_POST['desactivar'])){
        $con=conectarServidor();

        $id_mapa=$_POST['id_mapa'];

        $sentencia=$con->query("UPDATE mapa set estado=0 where id=$id_mapa");

        $con->close();
        header("Location:panel_mapas.php");
    }else if(isset($_POST['activar'])){
        $con=conectarServidor();

        $id_mapa=$_POST['id_mapa'];

        $sentencia=$con->query("UPDATE mapa set estado=1 where id=$id_mapa");

        $con->close();
        header("Location:panel_mapas.php");
    }else{
        header("Location:../index.php");
    }
?>