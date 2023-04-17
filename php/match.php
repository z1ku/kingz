<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Match</title>
    <link rel="stylesheet" href="css/estilos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Play&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <a href="index.html" class="logo">KINGZ</a>
        <nav>
            <button id="play">PLAY</button>
            <a href="leaderboard.html">LEADERBOARD</a>
            <div>
                <input placeholder="Search" id="buscador">
            </div>
        </nav>
        <button data-testid="signup-header" id="login">Log in</button>
    </header>
    <main>
        <section id="partido">
            <div id="cabecera_partido">
                <!-- NOMBRE DEL EQUIPO A Y EQUIPO B -->
                <div id="nombre_equipos">
                    <span>TEAM A VS TEAM B</span>
                </div>
                <!-- IMAGEN DEL MAPA A JUGAR -->
                <img src="img/cache.jpg" alt="mapa de el mapa cache" id="foto_mapa">
            </div>
            <div id="contenedor_connect_chat">
                <!-- PARA COPIAR LA DIRECCION DEL SERVIDOR DONDE SE JUEGA EL PARTIDO -->
                <div>
                    <input placeholder="connect ip;">
                    <button>COPY</button>
                </div>
                <!-- BOTON PARA ABRIR UN CHAT EMERGENTE PARA HABLAR CON EL RESTO DE JUGADORES DEL LOBBY -->
                <button>CHAT<i></i></button>
            </div>
            <!-- JUGADORES DEL EQUIPO A -->
            <!-- CON SU NOMBRE Y FOTO DE PERFIL -->
            <div id="equipos">
                <div id="equipoA">
                    <div class="partido_player">
                        <img src="img/capibara.jpg" alt="foto perfil jugador">
                        <div>
                            <span>Zaraki</span>
                            <span>MMR: 2709</span>
                        </div>
                    </div>
                    <div class="partido_player">
                        <img src="img/vizcacha.jpg" alt="foto perfil jugador">
                        <div>
                            <span>Xaxy</span>
                            <span>MMR: 1520</span>
                        </div>
                    </div>
                    <div class="partido_player">
                        <img src="img/eldoggo.jpg" alt="foto perfil jugador">
                        <div>
                            <span>z1ku</span>
                            <span>MMR: 3005</span>
                        </div>
                    </div>
                    <div class="partido_player">
                        <img src="img/gatosandia.jfif" alt="foto perfil jugador">
                        <div>
                            <span>Deeky</span>
                            <span>MMR: 1556</span>
                        </div>
                    </div>
                    <div class="partido_player lastplayer">
                        <img src="img/oscar.webp" alt="foto perfil jugador">
                        <div>
                            <span>Gravis</span>
                            <span>MMR: 1443</span>
                        </div>
                    </div>
                </div>
                <!-- IMAGEN PARA SEPARAR UN EQUIPO DEL OTRO CON UN "VS" -->
                <div>
                    <span id="versus">VS</span>
                </div>
                <!-- JUGADORES DEL EQUIPO A -->
                <!-- CON SU NOMBRE Y FOTO DE PERFIL -->
                <div id="equipoA">
                    <div class="partido_player">
                        <img src="img/eldoggo.jpg" alt="foto perfil jugador">
                        <div>
                            <span>eGo</span>
                            <span>MMR: 2899</span>
                        </div>
                    </div>
                    <div class="partido_player">
                        <img src="img/oscar.webp" alt="foto perfil jugador">
                        <div>
                            <span>Bettis</span>
                            <span>MMR: 1325</span>
                        </div>
                    </div>
                    <div class="partido_player">
                        <img src="img/gatosandia.jfif" alt="foto perfil jugador">
                        <div>
                            <span>Phakun</span>
                            <span>MMR: 1255</span>
                        </div>
                    </div>
                    <div class="partido_player">
                        <img src="img/capibara.jpg" alt="foto perfil jugador">
                        <div>
                            <span>Cloud</span>
                            <span>MMR: 3027</span>
                        </div>
                    </div>
                    <div class="partido_player lastplayer">
                        <img src="img/vizcacha.jpg" alt="foto perfil jugador">
                        <div>
                            <span>Lotis</span>
                            <span>MMR: 2956</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <footer>
        <a href="index.html" class="logo">KINGZ</a>
        <div>
            <a href="#">Política de privacidad</a>
            <a href="#">Condiciones</a>
            <a href="contacto.html">Contacto</a>
            <!-- REDES SOCIALES -->
            <a href="#"><i class="fa-brands fa-twitter"></i></a>
            <a href="#"><i class="fa-brands fa-twitch"></i></a>
            <a href="#"><i class="fa-brands fa-youtube"></i></a>
        </div>
    </footer>
</body>
</html>