<?php
    require_once "funciones.php";

    session_start();

    if(isset($_SESSION['nick']) && isset($_SESSION['pass'])){
        header("Location:../index.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <link rel="stylesheet" href="../css/estilos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Play&display=swap" rel="stylesheet">
</head>
<body>
    <?php
        headerGuest();
    ?>
    <main>
        <section id="seccionSignup" class="seccion">
            <h1>REGISTRARTE</h1>
            <?php
                require_once "funciones.php";

                if(isset($_POST['registrarse'])){

                    if($_POST['nick']=="" || $_POST['pass']==""){
                        $mensaje="No puedes dejar campos vacíos";
                    }else if(strlen($_POST['nick'])>20){
                        $mensaje="El nick no puede ser superior a 20 caracteres";
                    }else if(strlen($_POST['pass'])>20){
                        $mensaje="La contraseña no puede ser superior a 20 caracteres";
                    }else if(!ctype_alnum($_POST['nick'])){
                        $mensaje="El nick solo puede contener caracteres alfanuméricos";
                    }else if($_POST['pass']!=$_POST['passrepe']){
                        $mensaje="Las constraseñas no coinciden";
                    }else{

                        $con=conectarServidor();

                        $nick=$_POST['nick'];
                        $pass=md5(md5($_POST['pass']));

                        $buscar=$con->prepare("SELECT count(id) from usuario where nick=?");
                        $buscar->bind_param("s", $nick);
                        $buscar->execute();
                        $buscar->bind_result($num);
                        $buscar->fetch();

                        $buscar->close();

                        if($num>0){
                            $mensaje="Ese nick ya esta en uso";
                        }else{
                            $insertar=$con->prepare("INSERT into usuario values(null,?,?,null,null,1100,1,0,0)");
                            $insertar->bind_param("ss", $nick,$pass);

                            if($insertar->execute()){
                                $mensaje="Cuenta registrada con éxito";
                                header("refresh:2; url=../index.php");
                            }else{
                                $mensaje="ERROR:" . $insertar->error;
                            }

                            $insertar->close();
                        }

                        $con->close();
                    }

                }

                if(isset($mensaje)){
                    echo '<p class="mensajeError">'.$mensaje.'</p>';
                }

                echo '<form action="#" method="post" class="formkingz">
                <div>
                    <label for="nick">Nick:</label>
                    <input type="text" name="nick" value="" required>
                </div>
                <div>
                    <label for="pass">Constraseña:</label>
                    <input type="password" name="pass" required>
                </div>
                <div>
                    <label for="passrepe">Repetir constraseña:</label>
                    <input type="password" name="passrepe" required>
                </div>
                <input type="submit" name="registrarse" value="Enviar">
                </form>';
            ?>
        </section>
    </main>
    <?php
        footerIndex();
    ?>
</body>
</html>