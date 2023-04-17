<?php

    //FUNCION PARA CONECTAR A LA BASE DE DATOS
    function conectarServidor(){
        $con=new mysqli('localhost', 'root', '', 'kingz');
        $con->set_charset('utf8');

        return $con;
    }

    //FUNCION PARA COMPROBAR SI EL USUARIO ES ADMIN
    function comprobarAdmin($nick,$pass){
        $con=conectarServidor();

        $buscar=$con->prepare("select id from usuario where nick=? and pass=?");
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