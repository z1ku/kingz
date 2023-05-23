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
    <title>Perfil</title>
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
        <section id="perfil_jugador" class="seccion">
            <?php
                if($tipo_usu!="player"){
                    header("Location:../index.php");
                }

                $id=id_jugador_por_nick($nick);
                $datos_jugador=jugador_por_id($id);
            ?>
            <div id="jugador">
                <?php
                    if($datos_jugador['foto']!=null){
                        echo "<img src=\"../img/jugador/$datos_jugador[foto]\">";
                    }else{
                        echo "<img src=\"../img/jugador/jugador.png\">";
                    }
                ?>
                <div id="datos_jugador">
                    <div id="cabecera_perfil_jugador">
                        <?php
                            echo "<h2>$datos_jugador[nick]</h2>";

                            if($datos_jugador['nick']==$nick){
                                echo '<form action="editar_perfil.php" method="post">
                                <input type="submit" id="editar_perfil" name="editar_perfil" value="Editar">
                                <input type="hidden" name="id_usuario" value="'.$id.'">
                                </form>';
                            }
                        ?>
                    </div>
                    <div id="estadisticas">
                        <div>
                            <?php
                                $rank=obtener_rank_jugador($id);

                                echo "<p>Rank: $rank</p>";
                                echo "<p>MMR: $datos_jugador[mmr]</p>";

                                $partidas_totales=partidas_totales($id);

                                if($partidas_totales>0){
                                    $partidas_ganadas=partidas_ganadas($id);

                                    $win_rate=($partidas_ganadas/$partidas_totales) * 100;
                                    $win_truncado = intval($win_rate);

                                    echo "<p>Partidas jugadas: $partidas_totales</p>";
                                    echo "<p>W/L Rate: $win_truncado%</p>";
                                }else{
                                    echo "<p>Partidas jugadas: 0</p>";
                                    echo "<p>W/L Rate: -</p>";
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- HISTORIAL DE LAS ULTIMAS PARTIDAS DEL JUGADOR -->
            <div id="historial_jugador">
                <?php
                    $historial=obtener_historial_partidas($id);
                ?>
                <h2>HISTORIAL DE PARTIDAS</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Score</th>
                            <th>Result</th>
                            <th>Mapa</th>
                            <th>Ver</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if($historial!=null){
                                for($i=0;$i<count($historial);$i++){
                                    $fecha=date("d-m-Y",strtotime($historial[$i]['fecha']));
                                    echo '<tr>
                                    <td>'.$fecha.'</td>
                                    <td>'.$historial[$i]['resultado_a'].'/'.$historial[$i]['resultado_b'].'</td>';
                                    if($historial[$i]['ganado']==true){
                                        echo '<td class="win">WIN</td>';
                                    }else{
                                        echo '<td class="lose">LOSE</td>';
                                    }   
                                    echo '<td>'.$historial[$i]['mapa'].'</td>
                                    <td><a href="match.php?id_partida='.$historial[$i]['id'].'">Ver</a></td>
                                    </tr>';
                                }
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
    <?php
        footer();
    ?>
</body>
</html>