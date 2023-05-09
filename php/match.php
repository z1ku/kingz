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
        <section id="partido" class="seccion">
            <?php
                if(!isset($_GET['id_partida'])){
                    header("Location:../index.php");
                }

                $id_jugador="";

                if($tipo_usu=="player"){
                    $id_jugador=id_jugador_por_nick($nick);
                }

                $id_partida=$_GET['id_partida'];

                $datos_partida=partido_por_id($id_partida);

                if($datos_partida==null){
                    header("Location:../index.php");
                }

                $jugadores=obtener_jugadores_partida($id_partida);

                $id_mayor_elo=0;
                $elo_max=0;

                for($i=0;$i<count($jugadores);$i++){
                    $id_jugadores[$i]=$jugadores[$i]['id'];

                    if($jugadores[$i]['mmr']>$elo_max){
                        $id_mayor_elo=$jugadores[$i]['id'];
                        $elo_max=$jugadores[$i]['mmr'];
                    }
                }
            ?>
            <div id="cabecera_partido">
                <div id="nombre_equipos">
                    <span>TEAM A VS TEAM B</span>
                    <?php
                        echo "<p>ID DE LA PARTIDA: $id_partida</p>";
                    ?>
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
            <div id="cuerpo_partido">
                <div id="equipos">
                    <div class="equipo">
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
                                        <span class="player_nombre">'.$jugadores[$i]["nick"].'</span>
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
                    <div class="equipo">
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
                                        <span class="player_nombre">'.$jugadores[$i]["nick"].'</span>
                                        <span>MMR: '.$jugadores[$i]["mmr"].'</span>
                                    </div>
                                    </div>';
                                }
                            }
                        ?>
                    </div>
                </div>
                <div id="chat_partido">
                    <div id="caja_mensajes">
                        <?php
                            if(isset($_POST['enviar_mensaje'])){
                                $con=conectarServidor();

                                $mensaje=$_POST['mensaje'];

                                if(strlen($_POST['mensaje'])<=100 && $_POST['mensaje']!=null){
                                    $marca=time();

                                    $insertar=$con->prepare("INSERT into mensaje values(null,?,?,?,?)");
                                    $insertar->bind_param("siii",$mensaje,$marca,$id_jugador,$id_partida);

                                    if ($insertar->execute()) {
                                        // inserción exitosa
                                    } else {
                                        // error en la inserción
                                        echo "Error en la inserción del mensaje: " . $con->error;
                                    }

                                    $insertar->close();
                                }

                                $con->close();
                                header("Location:match.php?id_partida=$id_partida");
                            }
                            
                            // IMPRIMIR LOS MENSAJES POR PHP
                            // $todos_mensajes=todos_mensajes_partida($id_partida);

                            // if($todos_mensajes!=null){
                            //     for($i=0;$i<count($todos_mensajes);$i++){
                            //         echo '<p>'.$todos_mensajes[$i]['nick'].': '.$todos_mensajes[$i]['texto'].'</p>';
                            //     }
                            // }
                        ?>
                    </div>
                    <?php
                        if($datos_partida['estado']==0 && in_array($id_jugador, $id_jugadores)){
                            echo '<form action="#" method="post" id="form_enviar_mensaje">
                                <input type="text" name="mensaje" id="mensaje" max_length="100">
                                <input type="submit" name="enviar_mensaje" value="Enviar" id="btn_mensaje">
                            </form>';
                        }
                    ?>
                </div>
            </div>
            <?php
                if($tipo_usu=="admin" || ($datos_partida['estado']==0 && $id_jugador==$id_mayor_elo)){
                    echo '<form action="introducir_resultado.php" method="post">
                        <input type="submit" name="introducir_resultado" value="Introducir resultado" id="btn_resultado">
                        <input type="hidden" name="id_partida" value="'.$id_partida.'">
                    </form>';
                }
            ?>
        </section>
    </main>
    <?php
        footer();
    ?>
</body>
</html>