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
    <title>Partidas</title>
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
        <section id="seccionPartidas" class="seccion">
            <h1>Partidas</h1>
            <div class="contenedor_buscar_nuevo">
                <form action="#" method="post">
                    <input type="number" placeholder="Id partida" name="numero">
                    <input type="submit" name="buscar_partida" value="Buscar">
                    <a href="panel_partidas.php">Reset</a>
                </form>
                <div class="contenedor_abiertas_cerradas">
                    <form action="#" method="post">
                        <input type="submit" name="ver_abiertas" value="Abiertas">
                    </form>
                    <form action="#" method="post">
                        <input type="submit" name="ver_cerradas" value="Cerradas">
                    </form>
                </div>
            </div>
            <div class="contenedorTabla">
                <?php
                    if($tipo_usu=="admin"){

                        if(isset($_POST['buscar_partida'])){
                            $numero=$_POST['numero'];

                            $partidas=buscar_partida_por_id($numero);
                        }else if(isset($_POST['ver_cerradas'])){
                            $partidas=todas_partidas_cerradas();
                        }else if(isset($_POST['ver_abiertas'])){
                            $partidas=todas_partidas_abiertas();
                        }else{
                            $partidas=todas_partidas_abiertas();
                        }

                        echo '<table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Fecha</th>
                                <th>Score</th>
                            </tr>
                        </thead>
                        <tbody>';
                        if($partidas!=null){
                            for($i=0;$i<count($partidas);$i++){
                                $fecha_formateada=date("d-m-Y",strtotime($partidas[$i]['fecha']));

                                echo '<tr>
                                    <td><a href="match.php?id_partida='.$partidas[$i]['id'].'">'.$partidas[$i]['id'].'</a></td>
                                    <td>'.$fecha_formateada.'</td>
                                    <td>'.$partidas[$i]['resultado_a'].'/'.$partidas[$i]['resultado_b'].'</td>
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