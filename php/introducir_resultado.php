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
        <section id="introducir_resultado" class="seccion">
            <h1>Introduce el resultado del partido</h1>
            <?php
                if(isset($_POST['introducir_resultado'])){
                    $id_partida=$_POST['id_partida'];

                    echo '<form action="#" method="post" class="formkingz">
                        <div>
                            <label for="res_A">Resultado equipo A:</label>
                            <input type="number" name="res_A">
                        </div>
                        <div>
                            <label for="res_B">Resultado equipo B:</label>
                            <input type="number" name="res_B">
                        </div>
                        <input type="submit" name="insertar_resultado" value="Introducir resultado">
                        <input type="hidden" name="id_partida" value="'.$id_partida.'">
                    </form>';
                }else if(isset($_POST['insertar_resultado'])){
                    $con=conectarServidor();

                    $id_partida=$_POST['id_partida'];
                    $res_A=$_POST['res_A'];
                    $res_B=$_POST['res_B'];

                    if($res_A>=0 && $res_A<=13 && $res_B>=0 && $res_B<=13 && $res_A!=$res_B){
                        //Insertar los resultados de la partida
                        $insertar=$con->prepare("UPDATE partida set resultado_a=?, resultado_b=?, estado=1 where id=?");
                        $insertar->bind_param("iii",$res_A,$res_B,$id_partida);

                        if($insertar->execute()){
                            $mensaje="Resultado introducido con éxito";
                            
                            //Sumar o restar MMR a los jugadores
                            $jugadores=obtener_jugadores_partida($id_partida);

                            if($res_A>$res_B){
                                $equipo_ganador="A";
                            }else{
                                $equipo_ganador="B";
                            }

                            for($i=0;$i<count($jugadores);$i++){
                                $id_player=$jugadores[$i]['id'];

                                if($jugadores[$i]['equipo']==$equipo_ganador){
                                    $sentencia=$con->prepare("UPDATE usuario set mmr=mmr+20,en_partida=0 where id=?");
                                }else{
                                    $sentencia=$con->prepare("UPDATE usuario set mmr=mmr-20,en_partida=0 where id=?");
                                }

                                $sentencia->bind_param("i", $id_player);
                                $sentencia->execute();
                                $sentencia->close();
                            }

                            header("refresh:2; url=match.php?id_partida=$id_partida");
                        }else{
                            $mensaje="ERROR:" . $insertar->error;
                        }

                        $insertar->close();
                    }else{
                        $mensaje="Resultado no es válido";
                    }

                    $con->close();

                    if(isset($mensaje)){
                        echo '<p class="mensajeError">'.$mensaje.'</p>';
                    }
                    echo '<form action="#" method="post" class="formkingz">
                        <div>
                            <label for="res_A">Resultado equipo A:</label>
                            <input type="number" name="res_A">
                        </div>
                        <div>
                            <label for="res_B">Resultado equipo B:</label>
                            <input type="number" name="res_B">
                        </div>
                        <input type="submit" name="insertar_resultado" value="Introducir resultado">
                        <input type="hidden" name="id_partida" value="'.$id_partida.'">
                    </form>';
                }else{
                    header("Location:../index.php");
                }
            ?>
        </section>
    </main>
    <?php
        footer();
    ?>
</body>
</html>