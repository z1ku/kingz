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
                if(isset($_POST['buscar_jugador'])){
                    //SI ACCEDEN AL PERFIL BUSCANDO DESDE LA BARRA, TENGO QUE SACAR LA ID DEL NICK QUE HAN BUSCADO Y SACAR DATOS_JUGADOR DEL BLOQUE
                }else{
                    if($tipo_usu=="admin"){
                        header("Location:../index.php");
                    }

                    $id=id_jugador_por_nick($nick);

                    //SACAR ESTO DEL BLOQUE PROXIMAMENTE
                    $datos_jugador=jugador_por_id($id);
                }
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

                            echo '<form action="editar_perfil.php" method="post">
                                <input type="submit" id="editar_perfil" name="editar_perfil" value="Editar">
                                <input type="hidden" name="id_usuario" value="'.$id.'">
                            </form>';
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

                                    echo "<p>Partidas jugadas: $partidas_totales</p>";
                                    echo "<p>W/L Rate: $win_rate</p>";
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
                <h2>HISTORIAL DE PARTIDAS</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Score</th>
                            <th>Result</th>
                            <th>MMR</th>
                            <th>Mapa</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>23/10/2022</td>
                            <td>16/10</td>
                            <td class="win">WIN</td>
                            <td class="win">+24</td>
                            <td>Cache</td>
                        </tr>
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