<?php
/**
 * @author: Enrique Nieto Lorenzo
 * @since: 18/01/2026
 * @description: Vista de Login.
 */
?>
<main>
    <div class="card-central">
        <div class="logo-app-img">
            <i class="fas fa-layer-group"></i>
        </div>

        <h2 class="titulo-login">Iniciar sesión</h2>
        <p class="subtitulo-login">Utilice su cuenta corporativa para acceder.</p>

        <form action="index.php" method="post"> 

            <div class="grupo-input">
                <input type="text" class="input-microsoft" name="usuario" value="<?php echo $_REQUEST['usuario'] ?? ''; ?>" placeholder="Usuario">
            </div>

            <div class="grupo-input">
                <input type="password" class="input-microsoft" name="password" placeholder="Contraseña">
            </div>

            <div class="acciones-login">
                <button type="submit" name="entrar" class="btn-primary">Entrar</button>

                <div class="bloque-registro">
                    <span>¿No tienes cuenta?</span>
                    <button type="submit" name="registrarse" class="btn-link btn-bold">Crea una aquí</button>
                </div>
            </div>

        </form>
    </div>
</main>