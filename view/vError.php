<?php
/**
 * @author: Enrique Nieto Lorenzo
 * @description: Vista de Error (Clean Code).
 */
?>
<header class="header-app">
    <div class="logo-seccion">
        <span class="titulo-tema">ERROR 42S02</span>
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
    <div class="pantalla-completa">

        <div class="titulo-grande">:(</div>

        <h1 class="subtitulo-mensaje">Ups... Algo salió mal.</h1>

        <p class="texto-descripcion">
            La aplicación ha encontrado un problema técnico y no puede continuar.
        </p>

        <div class="caja-detalles-tecnicos">
            <p><strong>Código:</strong> <?php echo $avError['codError']; ?></p>
            <p><strong>Descripción:</strong> <?php echo $avError['descError']; ?></p>
            <p><strong>Archivo:</strong> <?php echo basename($avError['archivoError']); ?></p>
            <p><strong>Línea:</strong> <?php echo $avError['lineaError']; ?></p>
        </div>

        <form action="index.php" method="post">
            <button class="btn-primary btn-accion-especial bg-azul" type="submit" name="volver">
                <i class="fa-solid fa-arrow-rotate-left"></i> Volver
            </button>
        </form>

    </div>
</main>
