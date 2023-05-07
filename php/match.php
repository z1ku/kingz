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
    <title>Match</title>
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
        <section id="partido" class="seccion">
            <?php
                if(!isset($_GET['id_partida'])){
                    header("Location:../index.php");
                }

                $id_partida=$_GET['id_partida'];

                $datos_partida=partido_por_id($id_partida);

                if($datos_partida==null){
                    header("Location:../index.php");
                }

                $jugadores=obtener_jugadores_partida($id_partida);
            ?>
            <div id="cabecera_partido">
                <div id="nombre_equipos">
                    <span>TEAM A VS TEAM B</span>
                </div>
                <?php
                    if($datos_partida['id_mapa']!=null) {
                        $con = conectarServidor();
                    
                        $buscar_foto=$con->query("SELECT foto from mapa where id=$datos_partida[id_mapa]");
                        $fila=$buscar_foto->fetch_array(MYSQLI_ASSOC);
                    
                        echo '<img src="../img/mapa/'.$fila['foto'].'" alt="" id="foto_mapa">';
                    
                        $con->close();
                    }
                ?>
            </div>
            <div id="equipos">
                <div id="equipoA">
                    <?php
                        for($i=0;$i<count($jugadores);$i++){
                            if($jugadores[$i]["equipo"]=='A'){

                                if($jugadores[$i]["foto"]!=null){
                                    $foto_jugador=$jugadores[$i]['foto'];
                                }else{
                                    $foto_jugador="jugador.png";
                                }

                                echo '<div class="partido_player">
                                <img src="../img/jugador/'.$foto_jugador.'" alt="">
                                <div>
                                    <span>'.$jugadores[$i]["nick"].'</span>
                                    <span>MMR: '.$jugadores[$i]["mmr"].'</span>
                                </div>
                                </div>';
                            }
                        }
                    ?>
                </div>
                <div>
                    <span id="versus">VS</span>
                </div>
                <div id="equipoB">
                    <?php
                        for($i=0;$i<count($jugadores);$i++){
                            if($jugadores[$i]["equipo"]=='B'){

                                if($jugadores[$i]["foto"]!=null){
                                    $foto_jugador=$jugadores[$i]['foto'];
                                }else{
                                    $foto_jugador="jugador.png";
                                }

                                echo '<div class="partido_player">
                                <img src="../img/jugador/'.$foto_jugador.'" alt="">
                                <div>
                                    <span>'.$jugadores[$i]["nick"].'</span>
                                    <span>MMR: '.$jugadores[$i]["mmr"].'</span>
                                </div>
                                </div>';
                            }
                        }
                    ?>
                </div>
                <div id="chat_partido">
                
                </div>
            </div>
        </section>
    </main>
    <?php
        footer();
    ?>
</body>
</html>