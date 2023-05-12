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
    <title>Ticket</title>
    <link rel="stylesheet" href="../css/estilos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Play&display=swap" rel="stylesheet">
    <script type="text/javascript" defer src="../js/chat.js"></script>
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
            }else{
                headerPlayer();
                $tipo_usu="player";
            }
        }else{
            headerGuest();
            $tipo_usu="guest";
        }
    ?>
    <main>
        <section id="ticket" class="seccion">
            <?php
                if(!isset($_GET['id_ticket']) || $tipo_usu!="admin"){
                    header("Location:../index.php");
                }else{
                    $id_ticket=$_GET['id_ticket'];

                    $datos_ticket=ticket_por_id($id_ticket);

                    $fecha_formateada=date("d-m-Y",strtotime($datos_ticket['fecha']));

                    echo '<div class="contenedorTicket">
                        <p>ID ticket: '.$datos_ticket['id'].'</p>
                        <p>Nick: '.$datos_ticket['nick'].'</p>
                        <p>Fecha: '.$fecha_formateada.'</p>
                        <p>Asunto: '.$datos_ticket['asunto'].'</p>
                        <p>Mensaje: '.$datos_ticket['texto'].'</p>
                    </div>';

                    if($datos_ticket['foto']!=null){
                        echo "<img src=\"../img/ticket/$datos_ticket[foto]\">";
                    }
                }
            ?>
        </section>
    </main>
    <?php
        footer();
    ?>
</body>
</html>