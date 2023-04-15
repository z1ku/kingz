<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto</title>
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
        <section id="formContacto">
            <!-- FORMULARIO DE CONTACTO -->
            <form action="" method="post">
                <h2>CONTACTO</h2>
                <div>
                    <label for="name">Nombre:</label>
                    <input type="text" name="name">
                </div>
                <div>
                    <label for="email">Email:</label>
                    <input type="email" name="email">
                </div>
                <div>
                    <label for="asunto">Asunto:</label>
                    <input type="text" name="asunto">
                </div>
                <div>
                    <label for="mensaje">Mensaje:</label>
                    <textarea name="mensaje"cols="30" rows="10" placeholder="..."></textarea>
                </div>
                <button type="submit">Enviar</button>
            </form>
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