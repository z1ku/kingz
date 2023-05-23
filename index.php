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
    <title>KINGZ</title>
    <link rel="stylesheet" href="css/estilos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Play&display=swap" rel="stylesheet">
    <script type="text/javascript" defer src="js/weapons.js"></script>
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
        <img src="img/valorant.avif" alt="foto header" id="imgCabecera">
        <div id="contendor_noticias_ranking">
                <div id="ultimas_noticias">
                    <h2>ÚLTIMAS NOTICIAS</h2>
                    <?php
                        $noticias=ultimas_noticias();

                        if($noticias!=null){
                            for($i=0;$i<count($noticias);$i++){
                                echo '<p><a href="php/noticia.php?id_noticia='.$noticias[$i]['id'].'">'.$noticias[$i]['titulo'].'</a></p>';
                            }
                        }
                    ?>
                </div>
                <div id="mini_ranking">
                    <h2>TOP 10</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>Posición</th>
                                <th>Jugador</th>
                                <th>Partidos</th>
                                <th>Victorias</th>
                                <th>Win%</th>
                                <th>MMR</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $jugadores=obtener_top10();

                                if($jugadores!=null){
                                    for($i=0;$i<count($jugadores);$i++){
                                        $rank=obtener_rank_jugador($jugadores[$i]['id']);
                                        $partidas_totales=partidas_totales($jugadores[$i]['id']);
                                        $partidas_ganadas=partidas_ganadas($jugadores[$i]['id']);
        
                                        if($partidas_totales>0){
                                            $win_rate=($partidas_ganadas/$partidas_totales) * 100;
                                        }else{
                                            $win_rate=0;
                                        }
                                        
                                        $win_truncado = intval($win_rate);
            
                                        echo '<tr>
                                            <td>'.$rank.'</td>
                                            <td><a href="php/ver_perfil.php?id_player='.$jugadores[$i]['id'].'">'.$jugadores[$i]['nick'].'</a></td>
                                            <td>'.$partidas_totales.'</td>
                                            <td>'.$partidas_ganadas.'</td>
                                            <td>'.$win_truncado.'%</td>
                                            <td>'.$jugadores[$i]['mmr'].'</td>
                                        </tr>';
                                    }
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
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