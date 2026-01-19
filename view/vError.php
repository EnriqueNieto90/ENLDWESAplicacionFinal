<?php
/**
 * @author: Enrique Nieto Lorenzo
 * @since: 19/01/2026
 * @description: Vista de Error.
 */
?>

<style>
    .header-app, .footer-microsoft { display: none !important; }
    body { background-color: #ffffff; } /* Fondo blanco limpio para error crítico */
</style>

<div class="pantalla-error">
    
    <div class="titulo-error-grande">
        :(
    </div>
    
    <h1 class="subtitulo-error">Ups... Algo salió mal.</h1>
    
    <p style="color: #666; margin-bottom: 30px; font-size: 1.1rem;">
        La aplicación ha encontrado un problema y no puede continuar.
    </p>

    <div class="detalles-tecnicos">
        <p><strong>Código:</strong> <?php echo $avError['codError']; ?></p>
        <p><strong>Descripción:</strong> <?php echo $avError['descError']; ?></p>
        <p><strong>Archivo:</strong> <?php echo basename($avError['archivoError']); ?></p>
        <p><strong>Línea:</strong> <?php echo $avError['lineaError']; ?></p>
        
        <?php if(!empty($avError['paginaSiguiente'])): ?>
            <p><strong>Siguiente:</strong> <?php echo $avError['paginaSiguiente']; ?></p>
        <?php endif; ?>
    </div>

    <form action="index.php" method="post">
        <button class="btn-primary" type="submit" name="volver" style="background-color: #0078D4; padding: 10px 40px;">
            <i class="fa-solid fa-arrow-rotate-left"></i> Volver a intentar
        </button>
    </form>

</div>

