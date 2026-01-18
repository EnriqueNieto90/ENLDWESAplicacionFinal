<?php
/**
 * @author: Enrique Nieto Lorenzo
 * @since: 15/12/2025
 * @description: Vista de Login.
 */
?>
<header class="header-app">
    <div class="logo-seccion">
        <span class="titulo-tema">Login</span>
        <span class="subtitulo-tema">LOGIN LOGOFF</span>
    </div>
    <div class="nav-derecha">
        <form action="indexLoginLogoff.php" method="post">
            <button type="submit" name="cancelar" class="btn-header">
                <i class="fa-solid fa-arrow-right-from-bracket"></i> Salir
            </button>
        </form>
    </div>
</header>

<main>
    <div class="card-central">
        <div class="logo-app-img">
            <i class="fa-brands fa-microsoft" style="font-size: 2.5rem; color: #0078D4;"></i>
        </div>

        <h2 class="titulo-login">Iniciar sesión</h2>
        <p class="subtitulo-login">Utilice su cuenta corporativa para acceder.</p>
        
        <form action="indexLoginLogoff.php" method="post"> 
            
            <div class="grupo-input">
                <input type="text" class="input-microsoft" name="usuario" value="<?php echo $_REQUEST['usuario']??''; ?>" placeholder="Usuario">
            </div>
            
            <div class="grupo-input">
                <input type="password" class="input-microsoft" name="password" value="<?php echo $_REQUEST['password']??''; ?>" placeholder="Contraseña">
            </div>

            <div class="acciones-login">
                <span class="btn-link">¿No tienes cuenta? <br>
                <button type="submit" name="registrarse" class="btn-link btn-bold">Crea una aquí</button></span>
                
                <button type="submit" name="entrar" class="btn-primary">Entrar</button>
            </div>
        </form>
    </div>
</main>
