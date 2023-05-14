<?php
    require_once "php/funciones.php";

    session_start();

    if(isset($_COOKIE['sesion'])){
        session_decode($_COOKIE['sesion']);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="css/estilos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Play&display=swap" rel="stylesheet">
</head>
<body>
    <?php
        if(isset($_SESSION['nick']) && isset($_SESSION['pass'])){
            $nick=$_SESSION['nick'];
            $pass=$_SESSION['pass'];

            $esAdmin=comprobarAdmin($nick,$pass);
            
            if($esAdmin){
                headerIndexAdmin();
            }else{
                headerIndexPlayer();
            }
        }else{
            headerIndexGuest();
        }
    ?>
    <main>
        <!-- FOTO DE CABECERA WAPA TAL VEZ CON ALGUNAS NOTICIAS O EXPLICAR UN POCO QUE ES LA APLICACION -->
        <img src="img/valorant.avif" alt="foto header" id="imgCabecera">
        <!-- SECCION CON ALGUNAS FICHAS EXPLICANDO LO QUE PODRÍAS HACER EN EL SITIO WEB -->
        <section id="bienvenida">
            <h1>PLATAFORMA DE COMPETICIÓN EN LÍNEA</h1>
            <div class="div_wrapper">
                <article>
                    <i class="fa-solid fa-ranking-star"></i>
                    <p>
                        Compite en partidas clasificatorias para escalar en el ranking.
                    </p>
                </article>
                <article>
                    <i class="fa-solid fa-sheet-plastic"></i>
                    <p>
                        Conoce tus estadísticas a medida que escalas posiciones.
                    </p>
                </article>
                <article>
                    <i class="fa-solid fa-user-clock"></i>
                    <p>
                        Emparejate con jugadores similares y compite por ser el mejor.
                    </p>
                </article>
                <article>
                    <i class="fa-solid fa-user-plus"></i>
                    <p>
                        Juega con amigos y conoce a otros nuevos.
                    </p>
                </article>
            </div>
        </section>
    </main>
    <?php
        footerIndex();
    ?>
</body>
</html>