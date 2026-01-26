<?php
/**
 * @author: Enrique Nieto Lorenzo
 * @since: 18/01/2026
 * @description: Vista de Inicio Público con Carrusel de Diagramas.
 */
?>
<main>
    <div class="intro-inicio text-center">
        <h2 class="titulo-grande-ms">Documentación técnica y diagramas de la arquitectura</h2>
    </div>

    <div class="contenedor-carrusel-ms">
        
        <input type="radio" name="slider" id="slide1" checked>
        <input type="radio" name="slider" id="slide2">
        <input type="radio" name="slider" id="slide3">
        <input type="radio" name="slider" id="slide4">
        <input type="radio" name="slider" id="slide5">

        <div class="carrusel-slides">
            <div class="slide-item">
                <img src="webroot/images/ArbolNavegacion.png" alt="Árbol de Navegación">
                <div class="etiqueta-diagrama">Árbol de Navegación</div>
            </div>
            <div class="slide-item">
                <img src="webroot/images/MapaWeb.png" alt="Mapa Web">
                <div class="etiqueta-diagrama">Mapa Web</div>
            </div>
            <div class="slide-item">
                <img src="webroot/images/DiagramaDeClases.png" alt="Diagrama de Clases">
                <div class="etiqueta-diagrama">Diagrama de Clases</div>
            </div>
            <div class="slide-item">
                <img src="webroot/images/ModeloFisico.png" alt="Modelo Físico de Datos">
                <div class="etiqueta-diagrama">Modelo Físico</div>
            </div>
            <div class="slide-item">
                <img src="webroot/images/UsoSession.png" alt="Uso de Sesión">
                <div class="etiqueta-diagrama">Estructura de Sesión</div>
            </div>
        </div>

        <div class="carrusel-nav">
            <label for="slide1" class="nav-dot"></label>
            <label for="slide2" class="nav-dot"></label>
            <label for="slide3" class="nav-dot"></label>
            <label for="slide4" class="nav-dot"></label>
            <label for="slide5" class="nav-dot"></label>
        </div>
    </div>
</main>
