<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
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
        <section id="perfil_jugador">
            <div id="jugador">
                <img src="img/eldoggo.jpg" alt="imagen de perfil del jugador">
                <div id="datos_jugador">
                    <h2>z1ku</h2>
                    <div id="estadisticas">
                        <div>
                            <p>Rank: 3</p>
                            <p>MMR: 3005</p>
                            <p>Partidas jugadas: 325</p>
                            <p>W/L Rate: 74%</p>
                            <div id="rrss_jugador">
                                <a href="#"><i class="fa-brands fa-steam"></i></a>
                                <a href="#"><i class="fa-brands fa-twitter"></i></a>
                            </div>
                        </div>
                        <div id="equipos_del_jugador">
                            <h3>Equipos</h3>
                            <p>Ramboot Club</p>
                            <p>Baskonia</p>
                            <p>wololooo</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- HISTORIAL DE LAS ULTIMAS PARTIDAS DEL JUGADOR -->
            <div id="historial_jugador">
                <h2>HISTORIAL DE PARTIDAS</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Score</th>
                            <th>Result</th>
                            <th>MMR</th>
                            <th>Mapa</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>23/10/2022</td>
                            <td>16/10</td>
                            <td class="win">WIN</td>
                            <td class="win">+24</td>
                            <td>Cache</td>
                        </tr>
                        <tr>
                            <td>23/10/2022</td>
                            <td>8/16</td>
                            <td class="lose">LOSE</td>
                            <td class="lose">-20</td>
                            <td>Mirage</td>
                        </tr>
                        <tr>
                            <td>21/10/2022</td>
                            <td>16/4</td>
                            <td class="win">WIN</td>
                            <td class="win">+22</td>
                            <td>Inferno</td>
                        </tr>
                        <tr>
                            <td>20/10/2022</td>
                            <td>16/13</td>
                            <td class="win">WIN</td>
                            <td class="win">+19</td>
                            <td>Cache</td>
                        </tr>
                    </tbody>
                </table>
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