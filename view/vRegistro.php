<?php
/**
 * @author: Enrique Nieto Lorenzo
 * @since: 19/01/2026
 * @description: Vista de Registro de usuario.
 */
?>
<main>
    <div class="card-central">
        <div class="logo-app-img">
            <i class="fa-solid fa-user-plus"></i>
        </div>

        <h2 class="titulo-login">Crear cuenta</h2>
        <p class="subtitulo-login">Rellene los datos para acceder a la aplicación.</p>
        
        <form action="index.php" method="post"> 
            
            <div class="grupo-input">
                <input type="text" 
                       class="input-microsoft" 
                       name="codUsuario" 
                       value="<?php echo $aRespuestas['codUsuario']; ?>" 
                       placeholder="Código Usuario (mín 4 caracteres)">
                
                <?php echo !empty($aErrores['codUsuario']) ? '<span class="error-msg">'.$aErrores['codUsuario'].'</span>' : ''; ?>
            </div>
            
            <div class="grupo-input">
                <input type="text" 
                       class="input-microsoft" 
                       name="descUsuario" 
                       value="<?php echo $aRespuestas['descUsuario']; ?>" 
                       placeholder="Nombre y Apellidos">

                <?php echo !empty($aErrores['descUsuario']) ? '<span class="error-msg">'.$aErrores['descUsuario'].'</span>' : ''; ?>
            </div>
            
            <div class="grupo-input">
                <input type="password" 
                       class="input-microsoft" 
                       name="password" 
                       placeholder="Contraseña (mín 4 caracteres)">

                <?php echo !empty($aErrores['password']) ? '<span class="error-msg">'.$aErrores['password'].'</span>' : ''; ?>
            </div>

            <div class="grupo-input">
                <input type="password" 
                       class="input-microsoft" 
                       name="repetirPassword" 
                       placeholder="Repetir Contraseña">

                <?php echo !empty($aErrores['repetirPassword']) ? '<span class="error-msg">'.$aErrores['repetirPassword'].'</span>' : ''; ?>
            </div>

            <div class="acciones-registro">
                <button type="submit" name="registrarse" class="btn-primary">Registrarse</button>
            </div>
            
            <div class="enlace-login-registro">
                <span class="texto-gris">¿Ya tienes cuenta? </span>
                <button type="submit" name="cancelar" class="btn-link btn-bold">Inicia sesión</button>
            </div>

        </form>
    </div>
</main>
