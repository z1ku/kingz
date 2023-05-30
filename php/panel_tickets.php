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
    <title>Tickets</title>
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
        <section id="seccionTickets" class="seccion">
            <h1>Tickets</h1>
            <div class="contenedor_buscar_nuevo">
                <form action="#" method="post">
                    <input type="number" placeholder="Id ticket" name="numero">
                    <input type="submit" name="buscar_ticket" value="Buscar">
                    <a href="panel_tickets.php">Reset</a>
                </form>
                <div class="contenedor_abiertas_cerradas">
                    <form action="#" method="post">
                        <input type="submit" name="ver_abiertas" value="Abiertos">
                    </form>
                    <form action="#" method="post">
                        <input type="submit" name="ver_cerradas" value="Cerrados">
                    </form>
                </div>
            </div>
            <div class="contenedorTabla">
                <?php
                    if($tipo_usu=="admin"){

                        if(isset($_POST['buscar_ticket'])){
                            $numero=$_POST['numero'];

                            $tickets=buscar_ticket_por_id($numero);
                        }else if(isset($_POST['ver_cerradas'])){
                            $tickets=todos_tickets_cerrados();
                        }else if(isset($_POST['ver_abiertas'])){
                            $tickets=todos_tickets_abiertos();
                        }else{
                            $tickets=todos_tickets_abiertos();
                        }

                        echo '<table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Fecha</th>
                                <th>Asunto</th>
                                <th>Estado</th>
                                <th>Usuario</th>
                            </tr>
                        </thead>
                        <tbody>';
                        if($tickets!=null){
                            for($i=0;$i<count($tickets);$i++){
                                $fecha_formateada=date("d-m-Y",strtotime($tickets[$i]['fecha']));

                                echo '<tr>
                                    <td><a href="ticket.php?id_ticket='.$tickets[$i]['id'].'">'.$tickets[$i]['id'].'</a></td>
                                    <td>'.$fecha_formateada.'</td>
                                    <td>'.$tickets[$i]['asunto'].'</td>';
                                if($tickets[$i]['estado']==0){
                                    echo '<td>
                                        <form action="cerrar_ticket.php" method="post">
                                            <input type="hidden" name="id_ticket" value="'.$tickets[$i]['id'].'">
                                            <input type="submit" name="cerrar" class="btn_desactivar" value="Cerrar">
                                        </form>
                                    </td>';
                                }else{
                                    echo '<td>
                                        <form action="cerrar_ticket.php" method="post">
                                            <input type="hidden" name="id_ticket" value="'.$tickets[$i]['id'].'">
                                            <input type="submit" name="abrir" class="btn_activar" value="Abrir">
                                        </form>
                                    </td>';
                                }
                                echo '<td><a href="ver_perfil.php?id_player='.$tickets[$i]['id_usuario'].'">'.$tickets[$i]['nick'].'</a></td>
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