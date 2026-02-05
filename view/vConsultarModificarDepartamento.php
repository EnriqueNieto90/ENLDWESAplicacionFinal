<main>
    <div class="contenedor-centrado">
        <section class="tarjeta-plana tarjeta-formulario">
            
            <header class="cabecera-seccion-ms">
                <h3>
                    <i class="fa-solid <?php echo ($_SESSION['paginaEnCurso'] == 'consultarDepartamento') ? 'fa-eye' : 'fa-pen-to-square'; ?>"></i>
                    <?php echo ($_SESSION['paginaEnCurso'] == 'consultarDepartamento') ? 'Consultar' : 'Editar'; ?> Departamento
                </h3>
            </header>

            <div class="cuerpo-tarjeta">
                <form method="post">
                    <div class="grupo-input">
                        <label class="label-microsoft">Código</label>
                        <input type="text" class="input-microsoft input-disabled" 
                               value="<?php echo $avConsultarModificarDepartamento['codDepartamento']; ?>" readonly disabled>
                    </div>

                    <div class="grupo-input">
                        <label class="label-microsoft">Descripción</label>
                        <input type="text" name="descDepartamento" class="input-microsoft input-busc" 
                               value="<?php echo $avConsultarModificarDepartamento['descDepartamento']; ?>"
                               <?php echo ($_SESSION['paginaEnCurso'] == 'consultarDepartamento') ? 'readonly' : ''; ?>>
                    </div>

                    <div class="grupo-input">
                        <label class="label-microsoft label-tenue">Fecha Alta</label>
                        <input type="text" class="input-microsoft input-disabled" 
                               value="<?php echo $avConsultarModificarDepartamento['fechaCreacion']; ?>" readonly disabled>
                    </div>
                    
                    <div class="grupo-input">
                        <label class="label-microsoft">Volumen Negocio</label>
                        <input type="text" name="volumenDeNegocio" class="input-microsoft input-busc" 
                               value="<?php echo $avConsultarModificarDepartamento['volumenDeNegocio']; ?>"
                               <?php echo ($_SESSION['paginaEnCurso'] == 'consultarDepartamento') ? 'readonly' : ''; ?>>
                    </div>
                    
                    <div class="grupo-input">
                        <label class="label-microsoft label-tenue">Fecha Baja</label>
                        <input type="text" class="input-microsoft input-disabled" 
                               value="<?php echo $avConsultarModificarDepartamento['fechaBaja']; ?>" readonly disabled>
                    </div>

                    <div class="acciones-formulario">
                        <?php if ($_SESSION['paginaEnCurso'] != 'consultarDepartamento'): ?>
                            <button type="submit" name="aceptar" class="btn-primary">
                                Aceptar
                            </button>
                        <?php endif; ?>

                        <button type="submit" name="cancelar" class="btn-secondary">
                            <?php echo ($_SESSION['paginaEnCurso'] == 'consultarDepartamento') ? 'Volver' : 'Cancelar'; ?>
                        </button>
                    </div>
                </form>
            </div>
        </section>
    </div>
</main>