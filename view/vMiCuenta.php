<?php
/**
 * @author: Enrique Nieto Lorenzo
 * @since: 22/01/2026
 * @description: Vista de Mi Cuenta de Usuario.
 */
?>
<main>
    <div class="card-central">
        <div class="logo-app-img">
            <i class="fa-solid fa-user-plus" style="font-size: 2.5rem; color: #0078D4;"></i>
        </div>

        <h2 class="titulo-login">Crear cuenta</h2>
        <p class="subtitulo-login">Rellene los datos para acceder a la aplicación.</p>
        
        <form action="index.php" method="post"> 
            
            <div class="grupo-input">
                <input type="text" class="input-microsoft" name="codUsuario" 
                       value="<?php echo $_REQUEST['codUsuario'] ?? ''; ?>" 
                       placeholder="Código Usuario (mín 4 caracteres)">
                <?php if (!empty($aErrores['codUsuario'])): ?>
                    <span class="error-msg"><?php echo $aErrores['codUsuario']; ?></span>
                <?php endif; ?>
            </div>
            
            <div class="grupo-input">
                <input type="text" class="input-microsoft" name="descUsuario" 
                       value="<?php echo $_REQUEST['descUsuario'] ?? ''; ?>" 
                       placeholder="Nombre y Apellidos">
                <?php if (!empty($aErrores['descUsuario'])): ?>
                    <span class="error-msg"><?php echo $aErrores['descUsuario']; ?></span>
                <?php endif; ?>
            </div>
            
            <div class="grupo-input">
                <input type="password" class="input-microsoft" name="password" 
                       value="<?php echo $_REQUEST['password'] ?? ''; ?>" 
                       placeholder="Contraseña (mín 4 caracteres)">
                <?php if (!empty($aErrores['password'])): ?>
                    <span class="error-msg"><?php echo $aErrores['password']; ?></span>
                <?php endif; ?>
            </div>

            <div class="acciones-login" style="justify-content: flex-end;"> 
                <button type="submit" name="registrarse" class="btn-primary">Registrarse</button>
            </div>
            
            <div style="margin-top: 20px; text-align: center; font-size: 0.9rem;">
                <span class="btn-link">¿Ya tienes cuenta? </span>
                <button type="submit" name="cancelar" class="btn-link btn-bold">Inicia sesión</button>
            </div>

        </form>
    </div>
</main>