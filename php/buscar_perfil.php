<?php
    require_once "funciones.php";

    if(isset($_POST['buscador'])){
        $nick=$_POST['buscador'];
        $id=id_jugador_por_nick($nick);

        if($id!=null){
            header("Location:ver_perfil.php?id_player=$id");
        }else{
            header("Location:../index.php");
            
        }
    }else{
        header("Location:../index.php");
    }
?>