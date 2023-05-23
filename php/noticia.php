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
    <title>Noticia</title>
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
        <section id="noticia" class="seccion">
            <?php
                if(!isset($_GET['id_noticia'])){
                    header("Location:../index.php");
                }else{
                    $id_noticia=$_GET['id_noticia'];

                    $datos_noticia=obtener_noticia_por_id($id_noticia);

                    if($datos_noticia==null){
                        header("Location:../index.php");
                    }else{
                        $fecha_formateada=date("d-m-Y",strtotime($datos_noticia['fecha']));

                        echo '<div class="contenedorNoticia">
                            <img src="../img/noticia/'.$datos_noticia['foto'].'">
                            <h1>'.$datos_noticia['titulo'].'</h1>
                            <p>'.$datos_noticia['texto'].'</p>
                            <p>Fecha: '.$fecha_formateada.'</p>
                        </div>';
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