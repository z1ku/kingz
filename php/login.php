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
    <title>Login</title>
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
        <section id="seccionLogin" class="seccion">
            <h1>INICIAR SESIÓN</h1>
            <?php
                require_once "funciones.php";

                if(isset($_POST['logearse'])){
                    $con=conectarServidor();

                    $nick=$_POST['nick'];
                    $pass=md5(md5($_POST['pass']));

                    $buscar=$con->prepare("select id from usuario where nick=? and pass=?");
                    $buscar->bind_result($id);
                    $buscar->bind_param("ss",$nick,$pass);
                    $buscar->execute();
                    $buscar->store_result();

                    if($buscar->num_rows>0){
                        $_SESSION['nick']=$nick;
                        $_SESSION['pass']=$pass;

                        if(isset($_POST['recordar'])){
                            $datos=session_encode();
                            setcookie('sesion', $datos, time()+60*60*7, '/');
                        }
                        
                        $mensaje="Bienvenido $nick";
                        header("refresh:2; url=../index.php");
                    }else{
                        $mensaje="Nick o contraseña incorrectos";
                    }
                    
                    $buscar->close();
                    $con->close();
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
                <label for="recordar">
                    <input type="checkbox" name="recordar">Mantener sesión iniciada
                </label>
                <input type="submit" name="logearse" value="Enviar">
                </form>';
            ?>
        </section>
    </main>
    <?php
        footerIndex();
    ?>
</body>
</html>