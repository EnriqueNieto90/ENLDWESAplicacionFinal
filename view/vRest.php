<main>
    <div class="contenedor-rest">

        <div class="columna-api">
            <div class="tarjeta-api">
                <div class="seccion-titulo">
                    <h3><i class="fa-solid fa-user-astronaut"></i> API Foto Nasa</h3>
                </div>

                <div class="seccion-input">
                    <form method="post">
                        <div class="grupo-input-api">
                            <input type="date" name="fechaNasaEnCurso" class="input-microsoft" 
                                   value="<?php echo $avRest['fechaNasaEnCurso']; ?>" >

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

                        <img src="<?php echo $avRest['fotoNasaEnCursoUrl']; ?>" 
                             alt="Foto NASA" 
                             class="<?php echo $avRest['mostrarBotonDetalle'] ? '' : 'img-error'; ?>">

                        <?php if ($avRest['mostrarBotonDetalle']): ?>
                            <form action="index.php" method="post">
                                <button name="verDetalleNasa" class="btn-hd-overlay">
                                    <i class="fa-solid fa-expand"></i> Ver en detalle
                                </button>
                            </form>
                        <?php endif; ?>

                    </div>

                    <div class="descripcion-nasa">
                        <div class="instrucciones">
                            <h4>Instrucciones:</h4>
                            <ul>
                                <li>Pedimos la key en <strong>api.nasa.gov</strong>.</li>
                                <li>
                                    Construimos la URL con 3 partes (url, fecha y key):<br>
                                    <code>.../apod?date=<?php echo $avRest['fechaNasaEnCurso']; ?>&api_key=...</code>
                                </li>
                                <li>Con <code>file_get_contents()</code> o <code>cURL</code> obtenemos el JSON.</li>
                                <li>Con <code>json_decode($json, true)</code> lo pasamos a array para sacar la foto.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="columna-api">
            <div class="tarjeta-api">
                <div class="seccion-titulo">
                    <h3><i class="fa-solid fa-database"></i> Nueva API </h3>
                </div>

                <div class="seccion-input">
                    <div class="grupo-input-api">
                        <input type="text" class="input-microsoft" placeholder="Buscar...">
                        <button class="btn-primary btn-api">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </div>
                </div>

                <div class="seccion-contenido">
                    <div class="mensaje-vacio">

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
                        <input type="text" class="input-microsoft" placeholder="Buscar...">
                        <button class="btn-primary btn-api">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </div>
                </div>

                <div class="seccion-contenido">
                    <div class="mensaje-vacio">

                    </div>
                </div>
            </div>
        </div>

    </div>
</main>