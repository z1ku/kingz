"use strict"

const urlParams = new URLSearchParams(window.location.search);
const id_partida = urlParams.get('id_partida');

const cajaMensajes = document.querySelector('#caja_mensajes');

//Para que empiece el scroll abajo
cajaMensajes.scrollTop = cajaMensajes.scrollHeight;

let lista=[];
let num_mensajes=0;

imprimirMensajes();

async function imprimirMensajes(url_api=`verificar_mensajes_nuevos.php?id_partida=${id_partida}`) {
    const respuesta=await fetch(url_api);
    const datos=await respuesta.json();

    lista=datos.mensajes;
    lista.sort((a, b) => a.marca - b.marca);

    console.log(datos);
    console.log(lista);

    if(datos.total>num_mensajes){
        renderizar(lista,cajaMensajes,crearMensaje);

        //Para que empiece el scroll abajo
        cajaMensajes.scrollTop = cajaMensajes.scrollHeight;

        // Actualizar el número de mensajes
        num_mensajes = datos.total;
    }
}

setInterval(imprimirMensajes, 3000);

function renderizar(lista_mensajes, contenedor_dom, crear_dom) {
    contenedor_dom.innerHTML="";
    lista_mensajes.forEach(m=>{
        const mensaje = crear_dom(m);
        contenedor_dom.appendChild(mensaje);
    });
}

function crearMensaje(m){
    const mensaje = document.createElement("p");
    mensaje.innerHTML=`${m.nick}: ${m.texto}`;

    return mensaje;
}