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
    <title>Soporte</title>
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
        <section id="seccionSoporte" class="seccion">
            <h1>Soporte</h1>
            <p>En esta sección puedes ponerte en contacto con nosotros por si tienes alguna sugerencia o tienes algun problema con la resolución de algún partido.</p>
            <?php
                if($tipo_usu=="player"){
                    $id_usuario=id_jugador_por_nick($nick);

                    if(isset($_POST['enviar_ticket'])){

                        if($_POST['asunto']=="" || $_POST['mensaje']==""){
                            $mensaje="Asunto y mensaje son obligatorios";
                        }else if(strlen($_POST['asunto'])>50){
                            $mensaje="Asunto no puede tener más de 50 caracteres";
                        }else if(strlen($_POST['mensaje'])>500){
                            $mensaje="Mensaje no puede tener más de 500 caracteres";
                        }else if($_FILES['foto']['type']!="image/jpeg" && is_uploaded_file($_FILES['foto']['tmp_name'])){
                            $mensaje="La foto debe estar en formato jpg";
                        }else{
                            $con=conectarServidor();

                            $buscar="select auto_increment from information_schema.tables where table_schema='kingz' and table_name='ticket'";
                            $resultado=$con->query($buscar);

                            $fila=$resultado->fetch_array(MYSQLI_NUM);
                            $id_siguiente=$fila[0];

                            $asunto=$_POST['asunto'];
                            $mensaje=$_POST['mensaje'];
                            $fecha=date("Y-m-d");

                            if(is_uploaded_file($_FILES['foto']['tmp_name'])){
                                $foto=$id_siguiente.".jpg";
                            }else{
                                $foto=null;
                            }

                            $estado=0;

                            $sentencia=$con->prepare("INSERT into ticket values(null,?,?,?,?,?)");
                            $sentencia->bind_param("ssssi",$fecha,$asunto,$mensaje,$foto,$estado,$id_usuario);
            
                            if($sentencia->execute()){
                                if(is_uploaded_file($_FILES['foto']['tmp_name'])){
                                    move_uploaded_file($_FILES['foto']['tmp_name'], "../img/ticket/$foto");
                                }

                                $mensaje="Ticket enviado correctamente";
                            }else{
                                echo "<p>ERROR:</p> " . $sentencia->error;
                            }
            
                            $sentencia->close();

                            $con->close();
                            header("refresh:2; url=../index.php");
                        }

                    }

                    if(isset($mensaje)){
                        echo '<p class="mensajeError">'.$mensaje.'</p>';
                    }

                    echo '<form action="#" method="post" enctype="multipart/form-data" class="formkingz">
                    <input type="hidden" name="id_usuario" value="'.$id_usuario.'">
                    <div>
                        <label for="asunto">Asunto:</label>
                        <input type="text" name="asunto" value="" required>
                    </div>
                    <div>
                        <label for="mensaje">Mensaje:</label>
                        <textarea name="mensaje" rows="10" cols="50" placeholder="..." required></textarea>
                    </div>
                    <div>
                        <label for="foto">Sube una foto jpg:</label>
                        <input type="file" name="foto" accept="image/jpeg">
                    </div>
                    <input type="submit" name="enviar_ticket" value="Enviar">
                    </form>';
                }else{
                    header("Location:login.php");
                }
            ?>
        </section>
    </main>
    <?php
        footer();
    ?>
</body>
</html>