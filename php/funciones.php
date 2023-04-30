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
        $con=conectarServidor();

        $sentencia="SELECT id from usuario where nick='$nick'";
        $resultado=$con->query($sentencia);

        $fila=$resultado->fetch_array(MYSQLI_NUM);
        $id=$fila[0];

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

        $sentencia="SELECT count(*) from participa where id_usuario=$id";
        $resultado=$con->query($sentencia);

        $fila=$resultado->fetch_array(MYSQLI_NUM);
        $num=$fila[0];

        $con->close();
        return $num;
    }

    //FUNCION PARA OBTENER NUMERO DE PARTIDAS GANADAS DE UN JUGADOR
    function partidas_ganadas($id){
        $con=conectarServidor();

        $sentencia="SELECT count(id_usuario) from participa,partida where id_partida=id and id_usuario=$id and (
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
                    order by mmr desc, id desc";

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
        $con = conectarServidor();

        $consulta = "SELECT partida.*,participa.equipo,mapa.nombre nommap from partida,participa,mapa where id_mapa=mapa.id and id_partida=partida.id and partida.estado=1 and id_usuario=$id order by fecha desc limit 10";

        $resultado = $con->query($consulta);

        if ($resultado->num_rows > 0) {
            $i = 0;
            while ($fila = $resultado->fetch_array(MYSQLI_ASSOC)) {
                $datos[$i]['id'] = $fila['id'];
                $datos[$i]['resultado_a'] = $fila['resultado_a'];
                $datos[$i]['resultado_b'] = $fila['resultado_b'];
                $datos[$i]['fecha'] = $fila['fecha'];
                $datos[$i]['mapa'] = $fila['nommap'];

                if($fila['equipo'] == 'A' && $fila['resultado_a'] > $fila['resultado_b']) {
                    $datos[$i]['ganado'] = true;
                }else if($fila['equipo'] == 'B' && $fila['resultado_b'] > $fila['resultado_a']) {
                    $datos[$i]['ganado'] = true;
                }else{
                    $datos[$i]['ganado'] = false;
                }

                $i++;
            }
        } else {
            $datos = null;
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
                <form action="php/buscadorheader.php" method="post">
                    <input placeholder="Search" id="buscadorheader" name="buscador">
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
                <form action="php/buscadorheader.php" method="post">
                    <input placeholder="Search" id="buscadorheader" name="buscador">
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
                <form action="php/buscadorheader.php" method="post">
                    <input placeholder="Search" id="buscadorheader" name="buscador">
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
                <form action="buscadorheader.php" method="post">
                    <input placeholder="Search" id="buscadorheader" name="buscador">
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
                <form action="buscadorheader.php" method="post">
                    <input placeholder="Search" id="buscadorheader" name="buscador">
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
                <form action="buscadorheader.php" method="post">
                    <input placeholder="Search" id="buscadorheader" name="buscador">
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
                <a href="#">Contacto</a>
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
                <a href="#">Contacto</a>
                <a href="#"><i class="fa-brands fa-twitter"></i></a>
                <a href="#"><i class="fa-brands fa-twitch"></i></a>
                <a href="#"><i class="fa-brands fa-youtube"></i></a>
            </div>
        </footer>';
    }

?>