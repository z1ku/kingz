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
    <title>Mapas</title>
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
        <section id="seccionMapas" class="seccion">
            <h1>Mapas</h1>
            <div class="contenedor_buscar_nuevo">
                <form action="nuevo_mapa.php" method="post">
                    <input type="submit" name="nuevo_mapa" value="Nuevo">
                </form>
            </div>
            <?php
                if($tipo_usu=="admin"){

                    $mapas=todos_mapas();

                    echo '<table>
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Estado</th>
                            <th>Foto</th>
                            <th>Editar</th>
                        </tr>
                    </thead>
                    <tbody>';
                    if($mapas!=null){
                        for($i=0;$i<count($mapas);$i++){
                            echo '<tr>
                                <td>'.$mapas[$i]['nombre'].'</td>';
                            if($mapas[$i]['estado']==0){
                                echo '<td>
                                    <form action="activar_mapa.php" method="post">
                                        <input type="hidden" name="id_mapa" value="'.$mapas[$i]['id'].'">
                                        <input type="submit" name="activar" class="btn_desactivar" value="Activar">
                                    </form>
                                </td>';
                            }else{
                                echo '<td>
                                    <form action="activar_mapa.php" method="post">
                                        <input type="hidden" name="id_mapa" value="'.$mapas[$i]['id'].'">
                                        <input type="submit" name="desactivar" class="btn_activar" value="Desactivar">
                                    </form>
                                </td>';
                            }
                            echo '<td><img src="../img/mapa/'.$mapas[$i]['foto'].'" alt=""></td>
                            <td>
                                <form action="editar_mapa.php" method="post">
                                    <input type="hidden" name="id_mapa" value="'.$mapas[$i]['id'].'">
                                    <input type="submit" name="editar_mapa" class="btn_editar" value="Editar">
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
        </section>
    </main>
    <?php
        footer();
    ?>
</body>
</html>