<?php

    //FUNCION PARA CONECTAR A LA BASE DE DATOS
    function conectarServidor(){
        $con=new mysqli('localhost', 'root', '', 'kingz');
        $con->set_charset('utf8');

        return $con;
    }

    // FUNCIONES RELACIONADAS CON LOS USUARIOS
    ////////////////////////////////////////////////////////////////////
    //FUNCION PARA COMPROBAR SI EL USUARIO ES ADMIN
    function comprobarAdmin($nick,$pass){
        $con=conectarServidor();

        $buscar=$con->prepare("SELECT id from usuario where nick=? and pass=?");
        $buscar->bind_result($id);
        $buscar->bind_param("ss",$nick,$pass);
        $buscar->execute();
        $buscar->store_result();
        $buscar->fetch();

        if($id===0){
            $res=true;
        }else{
            $res=false;
        }

        $buscar->close();
        $con->close();
        
        return $res;
    }

    //FUNCION PARA OBTENER ID DE UN JUGADOR POR SU NICK
    function id_jugador_por_nick($nick){
        $con = conectarServidor();
    
        $sentencia = "SELECT id from usuario where nick=?";
        $buscar = $con->prepare($sentencia);
        $buscar->bind_param("s", $nick);
        $buscar->execute();
        $buscar->store_result();
    
        if ($buscar->num_rows > 0) {
            $buscar->bind_result($id);
            $buscar->fetch();
        } else {
            $id = null;
        }
    
        $con->close();
        return $id;
    }

    //FUNCION PARA OBTENER UN JUGADOR POR SU ID
    function jugador_por_id($id){
        $con=conectarServidor();

        $buscar=$con->query("SELECT * from usuario where id=$id");

        if($buscar->num_rows>0){
            $fila=$buscar->fetch_array(MYSQLI_ASSOC);
            $datos['id']=$fila['id'];
            $datos['nick']=$fila['nick'];
            $datos['pass']=$fila['pass'];
            $datos['correo']=$fila['correo'];
            $datos['foto']=$fila['foto'];
            $datos['mmr']=$fila['mmr'];
            $datos['estado']=$fila['estado'];
            $datos['en_partida']=$fila['en_partida'];
            $datos['buscando']=$fila['buscando'];
        }else{
            $datos=null;
        }

        $con->close();
        return $datos;
    }

    //FUNCION PARA OBTENER NUMERO DE PARTIDAS TOTALES DE UN JUGADOR
    function partidas_totales($id){
        $con=conectarServidor();

        $sentencia="SELECT count(*) from participa,partida where id_partida=id and id_usuario=$id and partida.estado=1";
        $resultado=$con->query($sentencia);

        $fila=$resultado->fetch_array(MYSQLI_NUM);
        $num=$fila[0];

        $con->close();
        return $num;
    }

    //FUNCION PARA OBTENER NUMERO DE PARTIDAS GANADAS DE UN JUGADOR
    function partidas_ganadas($id){
        $con=conectarServidor();

        $sentencia="SELECT count(id_usuario) from participa,partida where id_partida=id and id_usuario=$id and partida.estado=1 and (
            (participa.equipo = 'A' and partida.resultado_a > partida.resultado_b) or (participa.equipo = 'B' and partida.resultado_b > partida.resultado_a)
        )";

        $resultado=$con->query($sentencia);

        $fila=$resultado->fetch_array(MYSQLI_NUM);
        $num=$fila[0];

        $con->close();
        return $num;
    }

    //FUNCION PARA OBTENER LA CLASIFICACION GLOBAL DE LOS JUGADORES
    function obtener_clasificacion(){
        $con=conectarServidor();

        $consulta = "SELECT id, nick, mmr, 
                    (select count(*) from usuario where id <> 0 and (mmr > u.mmr or (mmr = u.mmr and id <= u.id))) as posicion 
                    from usuario u 
                    where id <> 0 and estado=1
                    order by mmr desc, id asc";

        $buscar=$con->query($consulta);

        if($buscar->num_rows>0){
            $i=0;
            while($fila_buscar=$buscar->fetch_array(MYSQLI_ASSOC)){
                $datos[$i]['id']=$fila_buscar['id'];
                $datos[$i]['nick']=$fila_buscar['nick'];
                $datos[$i]['mmr']=$fila_buscar['mmr'];
                $i++;
            }
        }else{
            $datos=null;
        }

        $con->close();
        return $datos;
    }

    //FUNCION PARA OBTENER EL RANK DE UN JUGADOR DENTRO DE LA CLASIFICACION GLOBAL
    function obtener_rank_jugador($id){
        $con = conectarServidor();
        
        $consulta = "SELECT id, nick, mmr, 
                    (select count(*) from usuario where id <> 0 and estado=1 and (mmr > u.mmr or (mmr = u.mmr and id <= u.id))) as posicion 
                    from usuario u 
                    where id = $id";
    
        $resultado=$con->query($consulta);
        
        if($resultado->num_rows > 0){
            $fila=$resultado->fetch_assoc();
            $rank=$fila['posicion'];
        } else {
            $rank=null;
        }

        $con->close();
        return $rank;
    }

    //FUNCION PARA OBTENER HISTORIAL DE PARTIDAS DE UN JUGADOR
    function obtener_historial_partidas($id){
        $con=conectarServidor();

        $consulta="SELECT partida.*,participa.equipo,mapa.nombre nommap from partida,participa,mapa where id_mapa=mapa.id and id_partida=partida.id and partida.estado=1 and id_usuario=$id order by fecha desc limit 10";

        $resultado=$con->query($consulta);

        if($resultado->num_rows>0){
            $i=0;
            while($fila=$resultado->fetch_array(MYSQLI_ASSOC)){
                $datos[$i]['id']=$fila['id'];
                $datos[$i]['resultado_a']=$fila['resultado_a'];
                $datos[$i]['resultado_b']=$fila['resultado_b'];
                $datos[$i]['fecha']=$fila['fecha'];
                $datos[$i]['mapa']=$fila['nommap'];

                if($fila['equipo']=='A' && $fila['resultado_a']>$fila['resultado_b']) {
                    $datos[$i]['ganado'] = true;
                }else if($fila['equipo']=='B' && $fila['resultado_b']>$fila['resultado_a']) {
                    $datos[$i]['ganado']=true;
                }else{
                    $datos[$i]['ganado']=false;
                }

                $i++;
            }
        }else{
            $datos=null;
        }

        $con->close();
        return $datos;
    }

    // FUNCIONES RELACIONADAS CON EL PARTIDO
    ////////////////////////////////////////////////////////////////////
    //FUNCION PARA OBTENER UN PARTIDO POR SU ID
    function partido_por_id($id){
        $con = conectarServidor();

        $buscar=$con->query("SELECT * from partida where id=$id");

        if($buscar->num_rows>0){
            $fila=$buscar->fetch_array(MYSQLI_ASSOC);
            $datos['id']=$fila['id'];
            $datos['resultado_a']=$fila['resultado_a'];
            $datos['resultado_b']=$fila['resultado_b'];
            $datos['fecha']=$fila['fecha'];
            $datos['estado']=$fila['estado'];
            $datos['id_mapa']=$fila['id_mapa'];
        }else{
            $datos=null;
        }

        $con->close();
        return $datos;
    }

    function obtener_partida_abierta($id){
        $con = conectarServidor();
    
        $sentencia = "SELECT id_partida from participa,partida where participa.id_partida=partida.id and participa.id_usuario=$id and partida.estado=0 and partida.resultado_a is null and partida.resultado_b is null";
        
        $resultado = $con->query($sentencia);
    
        if($resultado->num_rows > 0){
            $fila = $resultado->fetch_array(MYSQLI_NUM);
            $id_partida = $fila[0];
        } else {
            $id_partida = null;
        }
    
        $con->close();
        return $id_partida;
    }

    //FUNCION PARA OBTENER JUGADORES DE UN PARTIDO POR SU ID
    function obtener_jugadores_partida($id_partida){
        $con = conectarServidor();
    
        $buscar=$con->query("SELECT usuario.id,usuario.nick,usuario.foto,participa.equipo,usuario.mmr from usuario,participa where usuario.id=participa.id_usuario and participa.id_partida=$id_partida");
    
        if($buscar->num_rows>0){
            $i=0;
            while($fila=$buscar->fetch_array(MYSQLI_ASSOC)){
                $jugadores[$i]['id']=$fila['id'];
                $jugadores[$i]['nick']=$fila['nick'];
                $jugadores[$i]['foto']=$fila['foto'];
                $jugadores[$i]['equipo']=$fila['equipo'];
                $jugadores[$i]['mmr']=$fila['mmr'];

                $i++;
            }
        }else{
            $jugadores=null;
        }

        $con->close();
        return $jugadores;
    }

    //FUNCION PARA OBTENER TODOS LOS MENSAJES DE UN PARTIDO POR ID
    function todos_mensajes_partida($id_partida){
        $con=conectarServidor();
        $buscar=$con->query("SELECT mensaje.texto,mensaje.marca,usuario.nick from mensaje,usuario where usuario.id=id_usuario and id_partida=$id_partida order by marca asc");

        if($buscar->num_rows>0){
            $i=0;
            while($fila_buscar=$buscar->fetch_array(MYSQLI_ASSOC)){
                $datos[$i]['nick']=$fila_buscar['nick'];
                $datos[$i]['texto']=$fila_buscar['texto'];
                $datos[$i]['marca']=$fila_buscar['marca'];
                $i++;
            }
        }else{
            $datos=null;
        }

        $con->close();
        return $datos;
    }

    // FUNCIONES PARA ADMIN
    ////////////////////////////////////////////////////////////////////
    // OBTENER TODOS LOS USUARIOS
    function todos_usuarios(){
        $con=conectarServidor();
        $buscar=$con->query("SELECT * from usuario where id <> 0 order by id asc");

        if($buscar->num_rows>0){
            $i=0;
            while($fila_buscar=$buscar->fetch_array(MYSQLI_ASSOC)){
                $datos[$i]['id']=$fila_buscar['id'];
                $datos[$i]['nick']=$fila_buscar['nick'];
                $datos[$i]['correo']=$fila_buscar['correo'];
                $datos[$i]['estado']=$fila_buscar['estado'];
                $i++;
            }
        }else{
            $datos=null;
        }

        $con->close();
        return $datos;
    }

    // BUSCAR USUARIO POR NOMBRE
    function buscar_usuario_por_nombre($cadena){;
        $con=conectarServidor();

        $param="%$cadena%";

        $buscar=$con->prepare("SELECT id,nick,correo,estado from usuario where id <> 0 and nick like ?");
        $buscar->bind_result($id,$nick,$correo,$estado);
        $buscar->bind_param("s",$param);
        $buscar->execute();
        $buscar->store_result();

        if($buscar->num_rows>0){
            $i=0;
            while($buscar->fetch()){
                $datos[$i]['id']=$id;
                $datos[$i]['nick']=$nick;
                $datos[$i]['correo']=$correo;
                $datos[$i]['estado']=$estado;
                $i++;
            }
        }else{
            $datos=null;
        }

        $con->close();
        return $datos;
    }

    // OBTENER TODAS LAS PARTIDAS ABIERTAS
    function todas_partidas_abiertas(){
        $con=conectarServidor();
        $buscar=$con->query("SELECT * from partida where estado=0 order by id desc");

        if($buscar->num_rows>0){
            $i=0;
            while($fila_buscar=$buscar->fetch_array(MYSQLI_ASSOC)){
                $datos[$i]['id']=$fila_buscar['id'];
                $datos[$i]['resultado_a']=$fila_buscar['resultado_a'];
                $datos[$i]['resultado_b']=$fila_buscar['resultado_b'];
                $datos[$i]['fecha']=$fila_buscar['fecha'];
                $datos[$i]['estado']=$fila_buscar['estado'];
                $datos[$i]['id_mapa']=$fila_buscar['id_mapa'];
                $i++;
            }
        }else{
            $datos=null;
        }

        $con->close();
        return $datos;
    }

    // OBTENER TODAS LAS PARTIDAS CERRADAS
    function todas_partidas_cerradas(){
        $con=conectarServidor();
        $buscar=$con->query("SELECT * from partida where estado=1 order by id desc");

        if($buscar->num_rows>0){
            $i=0;
            while($fila_buscar=$buscar->fetch_array(MYSQLI_ASSOC)){
                $datos[$i]['id']=$fila_buscar['id'];
                $datos[$i]['resultado_a']=$fila_buscar['resultado_a'];
                $datos[$i]['resultado_b']=$fila_buscar['resultado_b'];
                $datos[$i]['fecha']=$fila_buscar['fecha'];
                $datos[$i]['estado']=$fila_buscar['estado'];
                $datos[$i]['id_mapa']=$fila_buscar['id_mapa'];
                $i++;
            }
        }else{
            $datos=null;
        }

        $con->close();
        return $datos;
    }

    // BUSCAR PARTIDA POR ID
    function buscar_partida_por_id($id){;
        $con=conectarServidor();

        $buscar=$con->prepare("SELECT * from partida where id=?");
        $buscar->bind_result($id,$resultado_a,$resultado_b,$fecha,$estado,$id_mapa);
        $buscar->bind_param("i",$id);
        $buscar->execute();
        $buscar->store_result();

        if($buscar->num_rows>0){
            $i=0;
            while($buscar->fetch()){
                $datos[$i]['id']=$id;
                $datos[$i]['resultado_a']=$resultado_a;
                $datos[$i]['resultado_b']=$resultado_b;
                $datos[$i]['fecha']=$fecha;
                $datos[$i]['estado']=$estado;
                $datos[$i]['id_mapa']=$id_mapa;
                $i++;
            }
        }else{
            $datos=null;
        }

        $con->close();
        return $datos;
    }

    // FUNCIONES PARA HEADER
    ////////////////////////////////////////////////////////////////////
    //HEADER INDEX INVITADO
    function headerIndexGuest(){
        echo '<header>
            <a href="index.php" class="logo">KINGZ</a>
            <nav>
                <form action="php/play.php" method="post">
                    <input type="submit" id="btn-play" name="play" value="PLAY">
                </form>
                <a href="php/leaderboard.php">LEADERBOARD</a>
                <form action="php/buscar_perfil.php" method="post">
                    <input placeholder="Search player" id="buscar_perfil" name="buscador">
                </form>
            </nav>
            <div class="headerLogin">
                <form action="php/signup.php" method="post">
                    <input type="submit" id="btn-signin" name="signin" value="Sign up">
                </form>
                <form action="php/login.php" method="post">
                    <input type="submit" id="btn-login" name="login" value="Log in">
                </form>
            </div>
        </header>';
    }

    //HEADER INDEX ADMIN
    function headerIndexAdmin(){
        echo '<header>
            <a href="index.php" class="logo">KINGZ</a>
            <nav>
                <form action="php/panel_admin.php" method="post">
                    <input type="submit" id="btn-admin" name="admin" value="Panel Admin">
                </form>
                <a href="php/leaderboard.php">LEADERBOARD</a>
                <form action="php/buscar_perfil.php" method="post">
                    <input placeholder="Search player" id="buscar_perfil" name="buscador">
                </form>
            </nav>
            <div class="headerLogin">
                <form action="php/cerrar_sesion.php" method="post">
                    <input type="submit" id="btn-salir" name="salir" value="Salir">
                </form>
            </div>
        </header>';
    }

    //HEADER INDEX PLAYER
    function headerIndexPlayer(){
        echo '<header>
            <a href="index.php" class="logo">KINGZ</a>
            <nav>
                <form action="php/play.php" method="post">
                    <input type="submit" id="btn-play" name="play" value="PLAY">
                </form>
                <a href="php/leaderboard.php">LEADERBOARD</a>
                <form action="php/buscar_perfil.php" method="post">
                    <input placeholder="Search player" id="buscar_perfil" name="buscador">
                </form>
            </nav>
            <div class="headerLogin">
                <form action="php/perfil.php" method="post">
                    <input type="submit" id="btn-perfil" name="perfil" value="Perfil">
                </form>
                <form action="php/cerrar_sesion.php" method="post">
                    <input type="submit" id="btn-salir" name="salir" value="Salir">
                </form>
            </div>
        </header>';
    }

    //HEADER DEFAULT INVITADO
    function headerGuest(){
        echo '<header>
            <a href="../index.php" class="logo">KINGZ</a>
            <nav>
                <form action="play.php" method="post">
                    <input type="submit" id="btn-play" name="play" value="PLAY">
                </form>
                <a href="leaderboard.php">LEADERBOARD</a>
                <form action="buscar_perfil.php" method="post">
                    <input placeholder="Search player" id="buscar_perfil" name="buscador">
                </form>
            </nav>
            <div class="headerLogin">
                <form action="signup.php" method="post">
                    <input type="submit" id="btn-signin" name="signin" value="Sign up">
                </form>
                <form action="login.php" method="post">
                    <input type="submit" id="btn-login" name="login" value="Log in">
                </form>
            </div>
        </header>';
    }

    //HEADER DEFAULT ADMIN
    function headerAdmin(){
        echo '<header>
            <a href="../index.php" class="logo">KINGZ</a>
            <nav>
                <form action="panel_admin.php" method="post">
                    <input type="submit" id="btn-admin" name="admin" value="Panel Admin">
                </form>
                <a href="leaderboard.php">LEADERBOARD</a>
                <form action="buscar_perfil.php" method="post">
                    <input placeholder="Search player" id="buscar_perfil" name="buscador">
                </form>
            </nav>
            <div class="headerLogin">
                <form action="cerrar_sesion.php" method="post">
                    <input type="submit" id="btn-salir" name="salir" value="Salir">
                </form>
            </div>
        </header>';
    }

    //HEADER DEFAULT PLAYER
    function headerPlayer(){
        echo '<header>
            <a href="../index.php" class="logo">KINGZ</a>
            <nav>
                <form action="play.php" method="post">
                    <input type="submit" id="btn-play" name="play" value="PLAY">
                </form>
                <a href="leaderboard.php">LEADERBOARD</a>
                <form action="buscar_perfil.php" method="post">
                    <input placeholder="Search player" id="buscar_perfil" name="buscador">
                </form>
            </nav>
            <div class="headerLogin">
                <form action="perfil.php" method="post">
                    <input type="submit" id="btn-perfil" name="perfil" value="Perfil">
                </form>
                <form action="cerrar_sesion.php" method="post">
                    <input type="submit" id="btn-salir" name="salir" value="Salir">
                </form>
            </div>
        </header>';
    }

    // FUNCIONES PARA FOOTER
    ////////////////////////////////////////////////////////////////////
    //FOOTER INDEX
    function footerIndex(){
        echo '<footer>
            <a href="index.php" class="logo">KINGZ</a>
            <div>
                <a href="#">Política de privacidad</a>
                <a href="#">Condiciones</a>
                <a href="php/soporte.php">Soporte</a>
                <a href="#"><i class="fa-brands fa-twitter"></i></a>
                <a href="#"><i class="fa-brands fa-twitch"></i></a>
                <a href="#"><i class="fa-brands fa-youtube"></i></a>
            </div>
        </footer>';
    }

    //FOOTER DEFAULT
    function footer(){
        echo '<footer>
            <a href="../index.php" class="logo">KINGZ</a>
            <div>
                <a href="#">Política de privacidad</a>
                <a href="#">Condiciones</a>
                <a href="soporte.php">Soporte</a>
                <a href="#"><i class="fa-brands fa-twitter"></i></a>
                <a href="#"><i class="fa-brands fa-twitch"></i></a>
                <a href="#"><i class="fa-brands fa-youtube"></i></a>
            </div>
        </footer>';
    }

?>