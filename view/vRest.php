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
                    <h3><i class="fa-solid fa-book-journal-whills"></i> Un Día Como Hoy (Wikipedia)</h3>
                </div>

                <div class="seccion-input">
                    <form method="post">
                        <div class="grupo-input-api">
                            <input type="date" name="fechaHistoriaEnCurso" class="input-microsoft" 
                                   value="<?php echo $avRest['fechaHistoriaEnCurso']; ?>" >

                            <button type="submit" name="buscarHistoria" class="btn-primary btn-api" title="Buscar efeméride">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </button>
                        </div>
                        <span class="error-msg">
                            <?php echo $avRest['errorHistoria'] ?? ''; ?>
                        </span>
                    </form>
                </div>

                <div class="seccion-contenido sin-fondo">

                    <?php if ($avRest['historiaAnio'] === 'Error'): ?>
                        <div class="mensaje-vacio">
                            <i class="fa fa-question-circle"></i>
                            <p><?php echo $avRest['historiaDescripcion']; ?></p>
                        </div>
                    <?php else: ?>

                        <h4>Año <?php echo $avRest['historiaAnio']; ?></h4>

                        <div class="contenedor-historia">

                            <p class="historia-texto">
                                <?php echo $avRest['historiaDescripcion']; ?>
                            </p>

                            <?php if ($avRest['historiaUrl'] !== '#'): ?>
                                <a href="<?php echo $avRest['historiaUrl']; ?>" target="_blank" class="btn-secondary btn-wiki">
                                    <i class="fa-brands fa-wikipedia-w"></i> Leer en Wikipedia
                                </a>
                            <?php endif; ?>

                        </div>
                    <?php endif; ?>

                    <div class="descripcion-nasa">
                        <div class="instrucciones">
                            <span class="tip-interactivo">
                                <i class="fa-solid fa-lightbulb"></i> Pulsa la lupa varias veces en la misma fecha para descubrir distintos eventos.
                            </span>
                            <h4>Instrucciones:</h4>
                            <ul>
                                <li><strong>API Abierta:</strong> No requiere API Key.</li>
                                <li>
                                    Construimos la URL con <strong>mes</strong> y <strong>día</strong>: <code>.../events/<?php echo date('m/d', strtotime($avRest['fechaHistoriaEnCurso'])); ?></code>
                                </li>
                                <li>
                                    Es <strong>obligatorio</strong> usar <code>cURL</code> con <code>User-Agent</code>. Si no, devuelve HTTP 403.
                                </li>
                                <li>
                                    Usamos <code>array_rand()</code> para extraer un evento aleatorio de esa fecha.
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="columna-api">
            <div class="tarjeta-api">
                <div class="seccion-titulo">
                    <h3><i class="fa-solid fa-building-user"></i> API Consulta Volumen Negocio Departamento</h3>
                </div>

                <div class="seccion-input">
                    <form method="post">
                        <div class="grupo-input-api">

                            <select name="codDepartamentoEnCursoRest" class="input-microsoft select-departamento">
                                <option value="">Seleccione departamento...</option>
                                <?php foreach ($avRest['listaDepartamentos'] as $depto): ?>
                                    <option value="<?php echo $depto['codDepartamento']; ?>" 
                                            <?php echo ($avRest['codDepartamentoEnCursoRest'] === $depto['codDepartamento']) ? 'selected' : ''; ?>>
                                                <?php echo $depto['codDepartamento'] . ' - ' . $depto['descDepartamento']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>

                            <button type="submit" name="buscarVolumen" class="btn-primary btn-api" title="Consultar Volumen">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </button>
                        </div>
                    </form>
                </div>

                <div class="seccion-contenido sin-fondo">

                    <h4>Resultado de la consulta</h4>

                    <div class="contenedor-historia">

                        <div class="contenido-centrado">
                            <h4 class="titulo-volumen">Volumen de Negocio</h4>
                            <span class="cifra-volumen">
                                <?php
                                $volumenMostrar = $avRest['volumenDeNegocio'] ?? 0;
                                echo number_format($volumenMostrar, 2, ',', '.');
                                ?> €
                            </span>
                        </div>

                    </div>

                    <div class="descripcion-nasa">
                        <div class="instrucciones">
                            <h4>Instrucciones:</h4>
                            <ul>
                                <li><strong>API Cerrada:</strong> Requiere nuestra API Key autorizada.</li>
                                <li>
                                    <strong>Seguridad:</strong> Ocultamos la clave inyectándola en las cabeceras HTTP mediante <code>CURLOPT_HTTPHEADER</code> en lugar de usar la URL.
                                </li>
                                <li>
                                    Usamos PHP <code>cURL</code> para que el servidor se consulte a sí mismo, ocultando así la clave al cliente.
                                </li>
                                <li>
                                    Convertimos la respuesta con <code>json_decode()</code> para aislar el <strong>volumen de negocio</strong> y formatearlo en pantalla.
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

</div>
</main>