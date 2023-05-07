<?php
    require_once "funciones.php";

    session_start();

    if(isset($_COOKIE['sesion'])){
        session_decode($_COOKIE['sesion']);
    }

    $tipo_usu="";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Play</title>
    <link rel="stylesheet" href="../css/estilos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Play&display=swap" rel="stylesheet">
    <script type="text/javascript" defer src="../js/matchmaking.js"></script>
</head>
<body>
    <?php
        if(isset($_SESSION['nick']) && isset($_SESSION['pass'])){
            $nick=$_SESSION['nick'];
            $pass=$_SESSION['pass'];

            $esAdmin=comprobarAdmin($nick,$pass);
            
            if($esAdmin){
                headerAdmin();
                $tipo_usu="admin";
                header("Location:../index.php");
            }else{
                headerPlayer();
                $tipo_usu="player";
            }
        }else{
            headerGuest();
            $tipo_usu="guest";
            header("Location:login.php");
        }
    ?>
    <main>
        <section id="play" class="seccion">
            <div id="cargando">
                <h3>Buscando partida</h3>    
                <progress max="100">Buscando partida</progress>
            </div>
            <?php
                //SACO LA INFORMACION DEL JUGADOR
                $id=id_jugador_por_nick($nick);
                $jugador=jugador_por_id($id);

                //SI YA ESTA EN PARTIDA REDIRECCIONO A LA SALA DE SU PARTIDA
                if($jugador['en_partida']==1){
                    //REDIRECCIONAR A EL LOBBY DE LA PARTIDA
                    $id_partida=obtener_partida_abierta($id);
                    header("Location:match.php?id_partida=$id_partida");
                }else{
                    $con=conectarServidor();

                    //PONGO EL CAMPO BUSCANDO=1 PARA SABER QUE ESTE JUGADOR ESTA BUSCANDO PARTIDA
                    $actualizar_buscando=$con->query("UPDATE usuario set buscando=1 where id=$id");

                    $con->close();
                }
            ?>  
        </section>
    </main>
    <?php
        footer();
    ?>
</body>
</html>