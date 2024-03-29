<?php
    require_once "funciones.php";

    sleep(1);

    $info["status"]="";
    $info["id_partida"]="";

    $con=conectarServidor();

    //AJUSTAR JUGADORES PARA LA PARTIDA
    $LIMITE_JUGADORES=4;

    // Obtener X jugadores que estén buscando partida
    $consulta="SELECT * from usuario where buscando=1 LIMIT $LIMITE_JUGADORES";
    $jugadores=$con->query($consulta);
    
    // Si se encontraron X jugadores, crear la partida
    if($jugadores->num_rows==$LIMITE_JUGADORES){
        //FECHA DE HOY
        $fecha=date('Y-m-d');

        //GENERAR ID_MAPA ALEATORIO DE LOS MAPAS ACTIVOS
        $id_mapa_aleatorio=id_mapa_aleatorio();

        // Crear la partida
        $consulta = "INSERT into partida values (null,null,null,'$fecha',0,$id_mapa_aleatorio)";
        $con->query($consulta);

        // Obtener el ID de la partida creada
        $id_partida=mysqli_insert_id($con);

        $i=0;
        while($fila_jugador=$jugadores->fetch_array(MYSQLI_ASSOC)){
            //Guardar las id de cada jugador
            $id_jugador=$fila_jugador['id'];

            //Actualizar sus estados
            $actualizar_estados=$con->query("UPDATE usuario set buscando=0, en_partida=1 where id=$id_jugador");

            //Crear indice en tabla participa para cada jugador, par o impar para asignar equipos
            if($i%2==0){
                $participa=$con->query("INSERT into participa values ($id_jugador,$id_partida,'A')");
            }else{
                $participa=$con->query("INSERT into participa values ($id_jugador,$id_partida,'B')");
            }

            $i++;
        }
        
        $info["status"]="ok";
        $info["id_partida"]=$id_partida;
    }

    $con->close();
    echo json_encode($info);
?>