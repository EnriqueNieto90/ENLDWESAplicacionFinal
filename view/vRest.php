<main>
    <div class="contenedor-rest">
        
        <div class="columna-api">
            <div class="tarjeta-api">
                <div class="seccion-titulo">
                    <h3><i class="fa-solid fa-user-astronaut"></i> Astronomy Picture</h3>
                </div>

                <div class="seccion-input">
                    <form method="post">
                        <div class="grupo-input-api">
                            <input type="date" name="fechaNasaEnCurso" class="input-microsoft" 
                                   value="<?php echo $avRest['fechaNasaEnCurso']; ?>" 
                                   max="<?php echo date('Y-m-d'); ?>">
                            
                            <button type="submit" name="entrar" class="btn-primary btn-api">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </button>
                        </div>
                        <span class="error-msg">
                            <?php echo $aErrores['fechaNasaEnCurso'] ?? ''; ?>
                        </span>
                    </form>
                </div>

                <div class="seccion-contenido sin-fondo">
                    <h4><?php echo $avRest['fotoNasaEnCursoTitulo']; ?></h4>

                    <div class="contenedor-imagen-nasa">
                        <img src="<?php echo $avRest['fotoNasaEnCursoUrl']; ?>" alt="Foto NASA">
                        <a href="<?php echo $avRest['fotoNasaEnCursoUrlHD']; ?>" target="_blank" class="btn-hd-overlay">
                            <i class="fa-solid fa-expand"></i> HD
                        </a>
                    </div>

                    <div class="descripcion-nasa">
                        <strong>Explicación:</strong><br>
                        <?php echo $avRest['fotoNasaEnCursoDescripcion'] ?? 'Sin descripción disponible.'; ?>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="columna-api">
            <div class="tarjeta-api">
                <div class="seccion-titulo">
                    <h3><i class="fa-solid fa-cloud-sun"></i> Tiempo Actual</h3>
                </div>

                <div class="seccion-input">
                    <div class="grupo-input-api">
                        <input type="text" class="input-microsoft" placeholder="Ciudad (ej: Madrid)">
                        <button class="btn-primary btn-api">
                            <i class="fa-solid fa-location-dot"></i>
                        </button>
                    </div>
                </div>

                <div class="seccion-contenido">
                    <div class="mensaje-vacio">
                        <i class="fa-solid fa-circle-info"></i>
                        <p>Introduce una ubicación para consultar el servicio meteorológico externo.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="columna-api">
            <div class="tarjeta-api">
                <div class="seccion-titulo">
                    <h3><i class="fa-solid fa-database"></i> Mi Propia API</h3>
                </div>

                <div class="seccion-input">
                    <div class="grupo-input-api">
                        <input type="text" class="input-microsoft" placeholder="Buscar por código...">
                        <button class="btn-primary btn-api">
                            <i class="fa-solid fa-server"></i>
                        </button>
                    </div>
                </div>

                <div class="seccion-contenido">
                    <div class="mensaje-vacio">
                        <i class="fa-solid fa-code"></i>
                        <p>Consulta tus propios recursos locales a través del servicio REST interno.</p>
                    </div>
                </div>
            </div>
        </div>

        </div>
</main>