<?php
/**
 * @author: Enrique Nieto Lorenzo
 * @since: 22/01/2026
 * @description: Vista de Error.
 */
?>
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
