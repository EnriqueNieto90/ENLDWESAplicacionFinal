<?php
/**
 * @author: Enrique Nieto Lorenzo
 * @since: 22/01/2026
 * @description: Vista del servicio REST
 */
?>
<main>
    <div class="contenedor-rest">
        
        <div class="columna-api">
            <div class="tarjeta-api">
                <div class="seccion-input">
                    <form method="post">
                        <div class="grupo-input-api">
                            <input type="date" name="fechaNasa" class="input-microsoft" 
                                   value="<?php echo $avRest['fechaNasa']; ?>" 
                                   max="<?php echo date('Y-m-d'); ?>">
                            
                            <button type="submit" name="enviarNasa" class="btn-primary btn-api">
                                Buscar
                            </button>
                        </div>
                        <span class="error-msg"><?php echo $avRest['error']; ?></span>
                    </form>
                </div>

                <div class="seccion-titulo">
                    <h3><?php echo $avRest['fotoNasa']->getTitulo(); ?></h3>
                </div>
                
                <div class="seccion-contenido sin-fondo">
                    <img src="<?php echo $avRest['fotoNasa']->getUrl(); ?>" alt="Foto NASA" class="media-nasa">
                </div>
            </div>
        </div>

        <div class="columna-api">
            <div class="tarjeta-api">
                <div class="seccion-input">
                    <div class="grupo-input-api">
                        <input type="text" class="input-microsoft" placeholder="" readonly>
                        <button class="btn-primary btn-api">Buscar</button>
                    </div>
                </div>

                <div class="seccion-titulo">
                    <h3>API</h3>
                </div>

                <div class="seccion-contenido">
                    
                </div>
            </div>
        </div>

        <div class="columna-api">
            <div class="tarjeta-api">
                 <div class="seccion-input">
                     <div class="grupo-input-api">
                         <input type="text" class="input-microsoft" placeholder="" readonly>
                         <button class="btn-primary btn-api">Buscar</button>
                     </div>
                 </div>

                 <div class="seccion-titulo">
                    <h3>Mi API</h3>
                 </div>

                 <div class="seccion-contenido">
                     
                 </div>
            </div>
        </div>

    </div>
</main>