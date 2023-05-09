"use strict"

async function matchMaking(url_api="matchmaking.php") {
    const respuesta=await fetch(url_api);
    const datos=await respuesta.json();

    console.log(datos);

    if(datos.status=="ok"){
        let id_partida=datos.id_partida;
        window.location.replace("match.php?id_partida="+id_partida);
    }
}

setInterval(matchMaking, 3000); // Comprobar cada 3 segundos