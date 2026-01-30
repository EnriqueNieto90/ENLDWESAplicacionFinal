<?php
/**
 * @author: Enrique Nieto Lorenzo
 * @since: 30/01/2026
 * @description: Vista para consultar y modificar un departamento.
 */
?>
<main>
    <div class="contenedor-rest" style="justify-content: center;"> <div class="tarjeta-api" style="width: 100%; max-width: 600px; min-height: auto;">
            
            <div class="seccion-titulo">
                <h3><?php echo ($_SESSION['paginaEnCurso'] == 'consultarDepartamento') ? 'CONSULTAR' : 'EDITAR'; ?> DEPARTAMENTO</h3>
            </div>

            <div class="seccion-contenido">
                <form method="post">
                    
                    <div class="grupo-input-api" style="margin-bottom: 15px; display: block;">
                        <label style="display:block; margin-bottom: 5px; font-weight: 600; color: var(--ms-blue);">Código</label>
                        <input type="text" class="input-microsoft input-disabled" 
                               value="<?php echo $avDepartamento['codDepartamento']; ?>" readonly disabled>
                    </div>

                    <div class="grupo-input-api" style="margin-bottom: 15px; display: block;">
                        <label style="display:block; margin-bottom: 5px; font-weight: 600;">Descripción</label>
                        <input type="text" name="descDepartamento" class="input-microsoft" 
                               value="<?php echo $avDepartamento['descDepartamento']; ?>"
                               <?php echo ($_SESSION['paginaEnCurso'] == 'consultarDepartamento') ? 'readonly' : ''; ?>>
                        <span class="error-msg" style="color: var(--error-color); font-size: 0.85em;">
                            <?php echo $aErrores['descDepartamento']; ?>
                        </span>
                    </div>

                    <div class="grupo-input-api" style="margin-bottom: 15px; display: block;">
                        <label style="display:block; margin-bottom: 5px; font-weight: 600; color: #605e5c;">Fecha de Alta</label>
                        <input type="text" class="input-microsoft input-disabled" 
                               value="<?php echo $avDepartamento['fechaCreacion']; ?>" readonly disabled>
                    </div>

                    <div class="grupo-input-api" style="margin-bottom: 15px; display: block;">
                        <label style="display:block; margin-bottom: 5px; font-weight: 600;">Volumen de Negocio (€)</label>
                        <input type="text" name="volumenDeNegocio" class="input-microsoft" 
                               value="<?php echo $avDepartamento['volumenDeNegocio']; ?>"
                               <?php echo ($_SESSION['paginaEnCurso'] == 'consultarDepartamento') ? 'readonly' : ''; ?>>
                        <span class="error-msg" style="color: var(--error-color); font-size: 0.85em;">
                            <?php echo $aErrores['volumenDeNegocio']; ?>
                        </span>
                    </div>

                    <div class="grupo-input-api" style="margin-bottom: 25px; display: block;">
                        <label style="display:block; margin-bottom: 5px; font-weight: 600; color: #605e5c;">Fecha de Baja</label>
                        <input type="text" class="input-microsoft input-disabled" 
                               value="<?php echo $avDepartamento['fechaBaja']; ?>" readonly disabled>
                    </div>

                    <div style="display: flex; justify-content: space-between; gap: 10px; border-top: 1px solid #edebe9; padding-top: 20px;">
                        <?php if ($_SESSION['paginaEnCurso'] != 'consultarDepartamento'): ?>
                            <button type="submit" name="aceptar" class="btn-primary btn-api" style="flex: 1;">
                                Aceptar
                            </button>
                        <?php endif; ?>

                        <button type="submit" name="cancelar" class="btn-primary btn-api" style="background-color: #a4262c; border-color: #a4262c; flex: 1;">
                            <?php echo ($_SESSION['paginaEnCurso'] == 'consultarDepartamento') ? 'Volver' : 'Cancelar'; ?>
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</main>

