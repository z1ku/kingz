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
    <title>Nuevo mapa</title>
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
            <h1>Nuevo mapa</h1>
            <?php
                if($tipo_usu!="admin"){
                    header("Location:../index.php");
                }

                if(isset($_POST['insertar_mapa'])){
                    if($_POST['nombre']==""){
                        $mensaje="Nombre no puede estar vacío";
                    }else if(strlen($_POST['nombre'])>50){
                        $mensaje="El nombre no puede ser superior a 50 caracteres";
                    }else if(!is_uploaded_file($_FILES['foto']['tmp_name'])){
                        $mensaje="Debes subir una foto";
                    }else if($_FILES['foto']['type']!="image/jpeg" && is_uploaded_file($_FILES['foto']['tmp_name'])){
                        $mensaje="La foto debe estar en formato jpg";
                    }else{
                        $con=conectarServidor();

                        $buscar="select auto_increment from information_schema.tables where table_schema='kingz' and table_name='mapa'";
                        $resultado=$con->query($buscar);

                        $fila=$resultado->fetch_array(MYSQLI_NUM);
                        $id_mapa=$fila[0];

                        $nombre=$_POST['nombre'];
                        $foto=$id_mapa.".jpg";

                        $sentencia=$con->prepare("INSERT into mapa values (null,?,?,1)");
        
                        $sentencia->bind_param("ss",$nombre,$foto);
        
                        if($sentencia->execute()){
                            if(is_uploaded_file($_FILES['foto']['tmp_name'])){
                                move_uploaded_file($_FILES['foto']['tmp_name'], "../img/mapa/$foto");
                            }

                            $mensaje="Mapa nuevo creado correctamente";
                        }else{
                            echo "<p>ERROR:</p> " . $sentencia->error;
                        }
        
                        $sentencia->close();

                        $con->close();
                        header("refresh:2; url=panel_mapas.php");
                    }
                }

                if(isset($mensaje)){
                    echo '<p class="mensajeError">'.$mensaje.'</p>';
                }

                echo '<form action="#" method="post" enctype="multipart/form-data" class="formkingz">
                <div>
                    <label for="nombre">Nombre:</label>
                    <input type="text" name="nombre" value="" required>
                </div>
                <div>
                    <label for="foto">Cambiar foto:</label>
                    <input type="file" name="foto" accept="image/jpeg">
                </div>
                <input type="submit" name="insertar_mapa" value="Guardar">
                </form>';
            ?>
        </section>
    </main>
    <?php
        footer();
    ?>
</body>
</html>