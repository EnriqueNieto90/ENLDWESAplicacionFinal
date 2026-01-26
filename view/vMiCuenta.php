<?php
/**
 * @author: Enrique Nieto Lorenzo
 * @since: 26/01/2026
 * @description: Vista de Mi Cuenta / Perfil.
 */
?>
<main>
    <div class="card-central card-dashboard">
        
        <div class="perfil-header">
            <div class="avatar-grande">
                <?php echo $avMiCuenta['inicial']; ?>
            </div>
            <h2 class="titulo-login">Tu perfil</h2>
            <p class="subtitulo-login">Gestiona tu información personal y seguridad.</p>
        </div>

        <form action="index.php" method="post" class="form-micuenta">

            <div class="fila-datos">
                <div class="grupo-input">
                    <label class="label-microsoft">Usuario</label>
                    <input type="text" class="input-microsoft input-disabled" 
                           value="<?php echo $avMiCuenta['codUsuario']; ?>" readonly disabled>
                </div>
                
                <div class="grupo-input">
                    <label class="label-microsoft">Perfil</label>
                    <input type="text" class="input-microsoft input-disabled" 
                           value="<?php echo $avMiCuenta['perfil']; ?>" readonly disabled>
                </div>
            </div>

            <div class="grupo-input">
                <label class="label-microsoft">Nombre y Apellidos</label>
                <input type="text" class="input-microsoft <?php echo ($aErrores['descUsuario']) ? 'input-error' : ''; ?>" 
                       name="descUsuario" 
                       value="<?php echo $avMiCuenta['descUsuario']; ?>" 
                       placeholder="Tu nombre completo">
                
                <?php if ($aErrores['descUsuario']): ?>
                    <span class="error-msg"><?php echo $aErrores['descUsuario']; ?></span>
                <?php endif; ?>
            </div>

            <div class="info-bloque-gris">
                <p><i class="fa-solid fa-chart-simple"></i> Conexiones: <strong><?php echo $avMiCuenta['numConexiones']; ?></strong></p>
                <p><i class="fa-regular fa-clock"></i> Último acceso: <strong><?php echo $avMiCuenta['fechaUltimaConexion']; ?></strong></p>
            </div>

            <div class="acciones-login" style="margin-top: 20px;">
                <button type="submit" name="aceptar" class="btn-primary">
                    <i class="fa-solid fa-floppy-disk"></i> Guardar
                </button>
                
                <button type="submit" name="cancelar" class="btn-secondary">
                    Cancelar
                </button>
            </div>

            <div class="opciones-seguridad">
                <button type="submit" name="cambiarPassword" class="btn-link">
                    <i class="fa-solid fa-key"></i> Cambiar contraseña
                </button>
                
                <button type="submit" name="borrarCuenta" class="btn-link btn-danger">
                    <i class="fa-solid fa-trash"></i> Eliminar cuenta
                </button>
            </div>

        </form>
    </div>
</main>