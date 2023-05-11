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
    <title>Usuarios</title>
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
        <section id="seccionUsuarios" class="seccion">
            <h1>Usuarios</h1>
            <div class="contenedor_buscar_nuevo">
                <form action="#" method="post">
                    <input type="text" name="cadena">
                    <input type="submit" name="buscar_usuario" value="Buscar">
                    <a href="panel_usuarios.php">Reset</a>
                </form>
            </div>
            <?php
                if($tipo_usu=="admin"){

                    if(isset($_POST['buscar_usuario'])){
                        $cadena=$_POST['cadena'];

                        $usuarios=buscar_usuario_por_nombre($cadena);
                    }else{
                        $usuarios=todos_usuarios();
                    }

                    echo '<table>
                    <thead>
                        <tr>
                            <th>Nick</th>
                            <th>Correo</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>';
                    if($usuarios!=null){
                        for($i=0;$i<count($usuarios);$i++){
                            echo '<tr>
                                <td><a href="ver_perfil.php?id_player='.$usuarios[$i]['id'].'">'.$usuarios[$i]['nick'].'</a></td>
                                <td>'.$usuarios[$i]['correo'].'</td>';
                            if($usuarios[$i]['estado']==1){
                                echo '<td>
                                    <form action="activar_usuario.php" method="post">
                                        <input type="hidden" name="id_usuario" value="'.$usuarios[$i]['id'].'">
                                        <input type="submit" name="desactivar" class="btn_desactivar" value="Desactivar">
                                    </form>
                                </td>';
                            }else{
                                echo '<td>
                                    <form action="activar_usuario.php" method="post">
                                        <input type="hidden" name="id_usuario" value="'.$usuarios[$i]['id'].'">
                                        <input type="submit" name="activar" class="btn_activar" value="Activar">
                                    </form>
                                </td>';
                            }
                            echo '</tr>';
                        }
                    }
                    echo '</tbody>
                    </table>';
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