<?php
/**
 * @author: Enrique Nieto Lorenzo
 * @since: 15/12/2025
 * @description: Vista de Inicio Público.
 */
?>
<header class="header-app">
    <div class="logo-seccion">
        <span class="titulo-tema">Bienvenido</span>
        <span class="subtitulo-tema">LOGIN LOGOFF</span>
    </div>

    <div class="header-controls">
        <form action="indexLoginLogoff.php" method="post" class="idioma-buttons">
            <?php $lang = $_COOKIE['idioma'] ?? 'ES'; ?>
            
            <button type="submit" name="idioma" value="ES" class="btn-flag <?php echo ($lang=='ES')?'active':''; ?>" title="Español">
                <img src="webroot/images/esp.png" alt="ES">
            </button>
            <button type="submit" name="idioma" value="EN" class="btn-flag <?php echo ($lang=='EN')?'active':''; ?>" title="English">
                <img src="webroot/images/uk.png" alt="EN">
            </button>
            <button type="submit" name="idioma" value="FR" class="btn-flag <?php echo ($lang=='FR')?'active':''; ?>" title="Français">
                <img src="webroot/images/francia.png" alt="FR">
            </button>
        </form>

        <form action="indexLoginLogoff.php" method="post" class="form-no-margin">
            <button name="iniciarSesion" class="btn-login-header">
                Iniciar Sesión
            </button>
        </form>
    </div>
</header>

<main>
    <div class="card-central card-dashboard card-center-text">
        <h2 class="titulo-login text-center">Bienvenido a la aplicación Login Logoff</h2>
        <p>Sistema de gestión de usuarios con autenticación y control de sesiones.</p>
        
        <div class="home-image-container">
            <img src="webroot/images/arbol.png" alt="Diagrama de navegación" onerror="this.style.display='none'">
        </div>
    </div>
</main>
