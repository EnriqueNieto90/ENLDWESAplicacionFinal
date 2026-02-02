<?php
/**
 * @author: Enrique Nieto Lorenzo
 * @since: 01/02/2026
 * @description: Vista Detalle Foto NASA HD.
 */
?>
<main class="main-detalle-nasa">
    
    <div class="detalle-info-container">
        <div class="detalle-header">
            <h2><?php echo $avDetalleNasa['titulo']; ?></h2>
            <span class="fecha-badge">
                <i class="fa-regular fa-calendar"></i> <?php echo $avDetalleNasa['fecha']; ?>
            </span>
        </div>
        
        <div class="detalle-texto">
            <p><?php echo $avDetalleNasa['descripcion']; ?></p>
        </div>
       
    </div>

    <div class="detalle-imagen-full">
        <input type="checkbox" id="zoom-check" class="chk-zoom">
        
        <label for="zoom-check" class="img-contenedor" title="Haz clic para Zoom">
            <img src="<?php echo $avDetalleNasa['urlHD']; ?>" alt="Imagen Alta Definición NASA">
        </label>
    </div>

</main>

