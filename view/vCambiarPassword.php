<?php
/**
 * @author: Enrique Nieto Lorenzo
 * @since: 02/02/2026
 * @description: Vista Cambiar Contraseña.
 */
?>
<main>
    <div class="card-central">
        
        <div class="seccion-titulo cabecera-cambio-pass">
            <i class="fa-solid fa-key icono-clave-grande"></i>
            <h2 class="titulo-login">Cambiar Contraseña</h2>
            <p class="subtitulo-login">Introduce tu contraseña actual y la nueva para actualizar tu seguridad.</p>
        </div>

        <form action="index.php" method="post">
            
            <div class="grupo-input">
                <label for="contrasenaActual" class="label-form">Contraseña actual</label>
                <div class="input-icon-wrapper">
                    <i class="fa-solid fa-lock icon-input"></i>
                    <input type="password" name="contrasenaActual" id="contrasenaActual" 
                           class="input-microsoft" placeholder="Escribe tu contraseña actual"
                           value="<?php echo $_REQUEST['contrasenaActual'] ?? ''; ?>">
                </div>
                <span class="error-msg"><?php echo $aErrores['contrasenaActual']; ?></span>
            </div>

            <hr class="separador-form">

            <div class="grupo-input">
                <label for="contrasenaNueva" class="label-form">Nueva contraseña</label>
                <div class="input-icon-wrapper">
                    <i class="fa-solid fa-key icon-input"></i>
                    <input type="password" name="contrasenaNueva" id="contrasenaNueva" 
                           class="input-microsoft" placeholder="Mínimo 4 caracteres"
                           value="<?php echo $_REQUEST['contrasenaNueva'] ?? ''; ?>">
                </div>
                <span class="error-msg"><?php echo $aErrores['contrasenaNueva']; ?></span>
            </div>

            <div class="grupo-input">
                <label for="repiteContrasena" class="label-form">Repite la nueva contraseña</label>
                <div class="input-icon-wrapper">
                    <i class="fa-solid fa-check-double icon-input"></i>
                    <input type="password" name="repiteContrasena" id="repiteContrasena" 
                           class="input-microsoft" placeholder="Vuelve a escribirla"
                           value="<?php echo $_REQUEST['repiteContrasena'] ?? ''; ?>">
                </div>
                <span class="error-msg"><?php echo $aErrores['repiteContrasena']; ?></span>
            </div>

            <div class="grupo-botones botones-cambio-pass">
                <button type="submit" name="guardar" class="btn-primary btn-full-width">
                    Aceptar
                </button>
                
                <button type="submit" name="cancelar" class="btn-primary btn-gris btn-full-width">
                    Cancelar
                </button>
            </div>

        </form>
    </div>
</main>

