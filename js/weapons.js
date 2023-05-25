"use strict"

const contenedor_weapons = document.getElementById("contenedor_weapons");

const id_vandal="9c82e19d-4575-0200-1a81-3eacf00cf872";
const id_phantom="ee8e8d15-496b-07ac-e5f6-8fae5d4c7b1a";
const id_operator="a03b24d3-4319-996d-0f8c-94bbfba1dfc7";

const endpoint_vandal="https://valorant-api.com/v1/weapons/"+id_vandal;
const endpoint_phantom="https://valorant-api.com/v1/weapons/"+id_phantom;
const endpoint_operator="https://valorant-api.com/v1/weapons/"+id_operator;

let lista_armas=[];

Inicio();

async function Inicio(){
    const respuesta_vandal=await fetch(endpoint_vandal);
    const datos_vandal=await respuesta_vandal.json();

    const respuesta_phantom=await fetch(endpoint_phantom);
    const datos_phantom=await respuesta_phantom.json();

    const respuesta_operator=await fetch(endpoint_operator);
    const datos_operator=await respuesta_operator.json();

    lista_armas.push(datos_vandal.data);
    lista_armas.push(datos_phantom.data);
    lista_armas.push(datos_operator.data);

    console.log(lista_armas);

    renderizar(lista_armas, contenedor_weapons, crearArma);
}

//===========FUNCIONES AUXILIARES============================================
function renderizar(lista, contenedor_dom, creador_dom) {
    contenedor_dom.innerHTML = "";
    lista.forEach((item)=>{
        const dom_item=creador_dom(item);
        contenedor_dom.appendChild(dom_item);
    });
}

function crearArma(a){
    const arma = document.createElement("table");
    arma.innerHTML = `<table>
        <thead>
            <tr>
                <th colspan="2">${a.displayName}</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="2">
                    <img src="${a.displayIcon}" alt="">
                </td>
            </tr>
            <tr>
                <td>Tamaño del cargador:</td>
                <td>${a.weaponStats.magazineSize}</td>
            </tr>
            <tr>
                <td>Cadencia de tiro:</td>
                <td>${a.weaponStats.fireRate}</td>
            </tr>
            <tr>
                <td>Daño a la cabeza:</td>
                <td>${a.weaponStats.damageRanges[0].headDamage}</td>
            </tr>
            <tr>
                <td>Daño al cuerpo:</td>
                <td>${a.weaponStats.damageRanges[0].bodyDamage}</td>
            </tr>
            <tr>
                <td>Daño a la pierna:</td>
                <td>${a.weaponStats.damageRanges[0].legDamage}</td>
            </tr>
        </tbdoy>
    </table>`;

    return arma;
}