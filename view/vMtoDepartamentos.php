<?php
/**
 * @author: Enrique Nieto Lorenzo
 * @description: Vista de Mantenimiento de Departamentos.
 */
?>
<header class="header-app">
    <div class="logo-seccion">
        <span class="titulo-tema">MANTENIMIENTO DEPARTAMENTOS</span>
        <span class="subtitulo-tema">APLICACIÓN FINAL</span>
    </div>
    <div class="nav-derecha">
        <form action="index.php" method="post" style="display:inline;">
            <button name="cerrarSesion" class="btn-header">
                <i class="fa-solid fa-power-off"></i> Cerrar sesión
            </button>
        </form>
    </div>
</header>
<main>
    <div class="contenedor-volver">
        <form action="index.php" method="post">
            <button name="volver" class="btn-link btn-bold">
                <i class="fa-solid fa-arrow-left"></i> Volver
            </button>
        </form>
    </div>
    <div class="card-central card-dashboard">
        <div class="welcome-msg">
            Mantenimiento de Departamentos
        </div>
        <div class="seccion-input">
            <div class="grupo-input-api">
                <input type="text" disabled class="input-microsoft input-disabled" placeholder="No disponible">
                <button disabled class="btn-primary btn-api btn-disabled">Buscar</button>
            </div>
        </div>
    </div>
</main>