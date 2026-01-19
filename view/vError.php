<?php
/**
 * @author: Enrique Nieto Lorenzo
 * @since: 19/01/2026
 * @description: Vista de Error del sistema (Clean Code).
 */
?>
<header class="header-app">
    <div class="logo-seccion">
        <span class="titulo-tema">Error</span>
        <span class="subtitulo-tema">SISTEMA</span>
    </div>
</header>

<main>
    <div class="card-central card-center-text card-error">
        
        <div class="icon-error-container">
            <i class="fa-solid fa-circle-exclamation"></i>
        </div>

        <h2 class="titulo-login">Ups, algo salió mal</h2>
        <p class="text-description">Se ha producido un error en la aplicación.</p>
        
        <div class="error-details-box">
            <p><strong>Código:</strong> <?php echo $avError['codError']; ?></p>
            <p><strong>Descripción:</strong> <?php echo $avError['descError']; ?></p>
            
            <?php if (!empty($avError['archivoError'])): ?>
                <hr class="error-separator">
                <p class="file-info">
                    <i class="fa-regular fa-file-code"></i> <?php echo basename($avError['archivoError']); ?> 
                    : <strong>Línea <?php echo $avError['lineaError']; ?></strong>
                </p>
            <?php endif; ?>
        </div>

        <form action="index.php" method="post">
            <button class="btn-primary btn-red" type="submit" name="volver">
                <i class="fa-solid fa-arrow-left"></i> Volver
            </button>
        </form>
    </div>
</main>

