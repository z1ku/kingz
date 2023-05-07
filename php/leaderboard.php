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
    <title>Leaderboard</title>
    <link rel="stylesheet" href="../css/estilos.css">
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
        <section id="leaderboard" class="seccion">
            <h1>LEADERBOARD</h1>
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
                        $jugadores=obtener_clasificacion();

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
                                    <td><a href="ver_perfil.php?id_player='.$jugadores[$i]['id'].'">'.$jugadores[$i]['nick'].'</a></td>
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
        </section>
    </main>
    <?php
        footer();
    ?>
</body>
</html>