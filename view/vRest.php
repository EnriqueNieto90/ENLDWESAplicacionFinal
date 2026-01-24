<?php
/**
 * @author: Enrique Nieto Lorenzo
 * @since: 22/01/2026
 * @description: Vista del servicio REST (Sin CSS inline)
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
                                Ver
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
                        <input type="text" class="input-microsoft" placeholder="Buscar..." readonly>
                        <button class="btn-primary btn-api">Ver</button>
                    </div>
                </div>

                <div class="seccion-titulo">
                    <h3>Próxima API</h3>
                </div>

                <div class="seccion-contenido">
                    <i class="fa-solid fa-rocket icono-api-vacia"></i>
                    <p class="texto-vacio">Próximamente</p>
                </div>
            </div>
        </div>

        <div class="columna-api">
            <div class="tarjeta-api">
                 <div class="seccion-input">
                     <div class="grupo-input-api">
                         <input type="text" class="input-microsoft" placeholder="Buscar datos..." readonly>
                         <button class="btn-primary btn-api">Ver</button>
                     </div>
                 </div>

                 <div class="seccion-titulo">
                    <h3>Mi API Propia</h3>
                 </div>

                 <div class="seccion-contenido">
                     <i class="fa-solid fa-server icono-api-vacia"></i>
                     <p class="texto-vacio">En desarrollo</p>
                 </div>
            </div>
        </div>

    </div>
</main>