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
    <title>Noticias</title>
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
        <section id="seccionNoticias" class="seccion">
            <h1>Noticias</h1>
            <div class="contenedor_buscar_nuevo">
                <form action="nueva_noticia.php" method="post">
                    <input type="submit" name="nueva_noticia" value="Nueva">
                </form>
            </div>
            <div class="contenedorTabla">
                <?php
                    if($tipo_usu=="admin"){

                        $noticias=todas_noticias();

                        echo '<table>
                        <thead>
                            <tr>
                                <th>Título</th>
                                <th>Fecha</th>
                                <th>Editar</th>
                            </tr>
                        </thead>
                        <tbody>';
                        if($noticias!=null){
                            for($i=0;$i<count($noticias);$i++){
                                $fecha_formateada=date("d-m-Y",strtotime($noticias[$i]['fecha']));
                                echo '<tr>
                                    <td><a href="noticia.php?id_noticia='.$noticias[$i]['id'].'">'.$noticias[$i]['titulo'].'</a></td>
                                    <td>'.$fecha_formateada.'</td>
                                    <td>
                                        <form action="editar_noticia.php" method="post">
                                            <input type="hidden" name="id_noticia" value="'.$noticias[$i]['id'].'">
                                            <input type="submit" name="editar_noticia" class="btn_editar" value="Editar">
                                        </form>
                                    </td>
                                </tr>';
                            }
                        }
                        echo '</tbody>
                        </table>';
                    }else{
                        header("Location:../index.php");
                    }
                ?>
            </div>
        </section>
    </main>
    <?php
        footer();
    ?>
</body>
</html>