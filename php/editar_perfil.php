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
        <section class="seccion">
            <h1>Editar perfil</h1>
            <?php
                if($tipo_usu!="player"){
                    header("Location:../index.php");
                }

                $id=id_jugador_por_nick($nick);
                $datos_jugador=jugador_por_id($id);

                if(isset($_POST['guardar_perfil'])){
                    if($_POST['nick']==""){
                        $mensaje="Nick no puede estar vacío";
                    }else if(strlen($_POST['nick'])>20){
                        $mensaje="El nick no puede ser superior a 20 caracteres";
                    }else if(strlen($_POST['pass'])>20){
                        $mensaje="La contraseña no puede ser superior a 20 caracteres";
                    }else if(!ctype_alnum($_POST['nick'])){
                        $mensaje="El nick solo puede contener caracteres alfanuméricos";
                    }else if($_POST['pass']!=$_POST['passrepe']){
                        $mensaje="Las constraseñas no coinciden";
                    }else if(strlen($_POST['correo'])>20){
                        $mensaje="Correo no puede ser superior a 50 caracteres";
                    }else if($_FILES['foto']['type']!="image/jpeg" && is_uploaded_file($_FILES['foto']['tmp_name'])){
                        $mensaje="La foto debe estar en formato jpg";
                    }else{
                        $con=conectarServidor();

                        $nick_antiguo=$nick;
                        $nick=$_POST['nick'];

                        $correo=$_POST['correo'];
                        $foto=$id.".jpg";

                        if($_POST['pass']!=""){
                            $pass=md5(md5($_POST['pass']));
                            $_SESSION['pass']=$pass;
                        }else{
                            $buscar_pass=$con->query("SELECT pass from usuario where id=$id");
                            $fila_pass=$buscar_pass->fetch_array(MYSQLI_ASSOC);
                            $pass=$fila_pass['pass'];
                        }

                        $buscar=$con->prepare("SELECT count(id) from usuario where nick=?");
                        $buscar->bind_param("s", $nick);
                        $buscar->execute();
                        $buscar->bind_result($num);
                        $buscar->fetch();

                        $buscar->close();

                        if($num>0 && $nick!=$nick_antiguo){
                            $mensaje="Ese nick ya esta en uso";
                        }else{
                            $sentencia=$con->prepare("UPDATE usuario set nick=?, pass=?, correo=?, foto=? where id=?");
            
                            $sentencia->bind_param("ssssi",$nick,$pass,$correo,$foto,$id);
            
                            if($sentencia->execute()){
                                if(is_uploaded_file($_FILES['foto']['tmp_name'])){
                                    move_uploaded_file($_FILES['foto']['tmp_name'], "../img/jugador/$foto");
                                }

                                $_SESSION['nick']=$nick;

                                $mensaje="Perfil editado correctamente";
                            }else{
                                echo "<p>ERROR:</p> " . $sentencia->error;
                            }
            
                            $sentencia->close();
                        }

                        $con->close();
                        header("refresh:2; url=perfil.php");
                    }
                }

                if(isset($mensaje)){
                    echo '<p class="mensajeError">'.$mensaje.'</p>';

                    $id=id_jugador_por_nick($nick);
                    $datos_jugador=jugador_por_id($id);
                }

                echo '<form action="#" method="post" enctype="multipart/form-data" class="formkingz">
                <div>
                    <label for="nick">Nick:</label>
                    <input type="text" name="nick" value="'.$datos_jugador['nick'].'" required>
                </div>
                <div>
                    <label for="correo">Correo:</label>
                    <input type="email" name="correo" value="'.$datos_jugador['correo'].'">
                </div>
                <div>
                    <label for="pass">Constraseña:</label>
                    <input type="password" name="pass">
                </div>
                <div>
                    <label for="passrepe">Repetir constraseña:</label>
                    <input type="password" name="passrepe">
                </div>
                <div>
                    <label for="foto">Cambiar foto perfil:</label>
                    <input type="file" name="foto" accept="image/jpeg">
                </div>
                <input type="submit" name="guardar_perfil" value="Guardar">
                </form>';
            ?>
        </section>
    </main>
    <?php
        footer();
    ?>
</body>
</html>