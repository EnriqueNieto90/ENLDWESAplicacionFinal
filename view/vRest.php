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
                <div class="seccion-titulo">
                    <h3>Astronomy Picture of the Day</h3>
                </div>

                <div class="seccion-input">
                    <form method="post">
                        <div class="grupo-input-api">
                            <input type="date" name="fechaNasaEnCurso" class="input-microsoft" 
                                   value="<?php echo $avRest['fechaNasaEnCurso']; ?>" 
                                   max="<?php echo date('Y-m-d'); ?>">
                            
                            <button type="submit" name="entrar" class="btn-primary btn-api">
                                Buscar
                            </button>
                        </div>
                        <span class="error-msg" style="color: var(--error-color); font-size: 0.9em;">
                            <?php echo $aErrores['fechaNasaEnCurso'] ?? ''; ?>
                        </span>
                    </form>
                </div>

                <div class="seccion-contenido sin-fondo" style="justify-content: flex-start;">
                    
                    <h4 style="margin: 0 0 10px 0; color: var(--ms-blue); text-align: center;">
                        <?php echo $avRest['fotoNasaEnCursoTitulo']; ?>
                    </h4>

                    <div class="contenedor-imagen-nasa" style="position: relative; width: 100%; height: 300px; overflow: hidden; border: 1px solid #ccc;">
                        <img src="<?php echo $avRest['fotoNasaEnCursoUrl']; ?>" alt="Foto NASA" 
                             style="width: 100%; height: 100%; object-fit: cover;">
                        
                        <a href="<?php echo $avRest['fotoNasaEnCursoUrlHD']; ?>" target="_blank" class="btn-hd-overlay">
                            Detalles
                        </a>
                    </div>

                    <div class="descripcion-nasa" style="margin-top: 15px; padding: 10px; background: #fff; border: 1px solid #edebe9; height: 150px; overflow-y: auto; font-size: 0.9rem; line-height: 1.4;">
                        <strong>Explicación:</strong><br>
                        <?php echo $avRest['fotoNasaEnCursoDescripcion'] ?? 'Sin descripción disponible.'; ?>
                    </div>

                </div>
            </div>
        </div>

        <div class="columna-api">
            <div class="tarjeta-api">
                <div class="seccion-titulo">
                    <h3>API EXTERNA 2</h3>
                </div>
                <div class="seccion-input">
                    <div class="grupo-input-api">
                        <input type="text" class="input-microsoft" placeholder="Buscar..." readonly>
                        <button class="btn-primary btn-api">Buscar</button>
                    </div>
                </div>
                <div class="seccion-contenido">
                    
                </div>
            </div>
        </div>

        <div class="columna-api">
            <div class="tarjeta-api">
                 <div class="seccion-titulo">
                    <h3>MI PROPIA API</h3>
                 </div>
                 <div class="seccion-input">
                      <div class="grupo-input-api">
                          <input type="text" class="input-microsoft" placeholder="Buscar..." readonly>
                          <button class="btn-primary btn-api">Buscar</button>
                      </div>
                 </div>
                 <div class="seccion-contenido">
                      
                 </div>
            </div>
        </div>

    </div>
</main>