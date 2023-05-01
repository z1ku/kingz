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
    <title>Play</title>
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
                header("Location:../index.php");
            }else{
                headerPlayer();
                $tipo_usu="player";
            }
        }else{
            headerGuest();
            $tipo_usu="guest";
            header("Location:login.php");
        }
    ?>
    <main>
        <section id="play" class="seccion">
            <?php
                //SACO LA INFORMACION DEL JUGADOR
                $id=id_jugador_por_nick($nick);
                $jugador=jugador_por_id($id);

                //SI YA ESTA EN PARTIDA REDIRECCIONO A LA SALA DE SU PARTIDA
                if($jugador['en_partida']==1){
                    //REDIRECCIONAR A EL LOBBY DE LA PARTIDA
                }

                $con=conectarServidor();

                //PONGO EL CAMPO BUSCANDO=1 PARA SABER QUE ESTE JUGADOR ESTA BUSCANDO PARTIDA
                $actualizar_buscando=$con->query("UPDATE usuario set buscando=1 where id=$id");

                while(true){
                    // Obtener jugadores que estén buscando partida
                    $consulta="SELECT * from usuario where buscando=1 LIMIT 4";
                    $jugadores=$con->query($consulta);
                    
                    // Si se encontraron 2 jugadores, crear la partida
                    if ($jugadores->num_rows==2){
                        //FECHA DE HOY
                        $fecha=date('Y-m-d');

                        // Crear la partida
                        $consulta = "INSERT into partida values (?,0,0,$fecha,0,null)";
                        $con->query($consulta);

                        // Obtener el ID de la partida creada
                        $id_partida=mysqli_insert_id($con);

                        $i=0;
                        while($fila_jugador=$jugadores->fetch_array(MYSQLI_ASSOC)){
                            //Guardar las id de cada jugador
                            $id_jugadores[$i]['id']=$fila_jugador['id'];

                            //Actualizar sus estados
                            $actualizar_estados=$con->query("UPDATE usuario set buscando=0, en_partida=1 where id=$fila_jugador['id']");

                            //Crear indice en tabla participa para cada jugador, par o impar para asignar equipos
                            if($i%2==0){
                                $participa=$con->query("INSERT into participa values ($fila_jugador['id'],$id_partida,'A')");
                            }else{
                                $participa=$con->query("INSERT into participa values ($fila_jugador['id'],$id_partida,'B')");
                            }

                            $i++;
                        }
                        
                        // Redireccionar a los jugadores al lobby de la partida
                        header("Location:match.php?id_partida=$id_partida");
                        exit();
                    }
                    
                    // Esperar 3 segundos antes de volver a comprobar
                    sleep(3);
                }
                  

                $con->close();
            ?>  
        </section>
    </main>
    <?php
        footer();
    ?>
</body>
</html>