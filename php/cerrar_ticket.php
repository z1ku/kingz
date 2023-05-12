<?php
    require_once "funciones.php";

    if(isset($_POST['cerrar'])){
        $con=conectarServidor();

        $id_ticket=$_POST['id_ticket'];

        $sentencia=$con->query("UPDATE ticket set estado=1 where id=$id_ticket");

        $con->close();
        header("Location:panel_tickets.php");
    }else if(isset($_POST['abrir'])){
        $con=conectarServidor();

        $id_ticket=$_POST['id_ticket'];

        $sentencia=$con->query("UPDATE ticket set estado=0 where id=$id_ticket");

        $con->close();
        header("Location:panel_tickets.php");
    }else{
        header("Location:../index.php");
    }
?>