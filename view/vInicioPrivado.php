<?php
/**
 * @author: Enrique Nieto Lorenzo
 * @since: 15/12/2025
 * @description: Vista de Inicio Privado.
 */
?>
<header class="header-app">
    <div class="logo-seccion">
        <span class="titulo-tema">Portal Privado</span>
        <span class="subtitulo-tema">LOGIN LOGOFF</span>
    </div>
    <div class="nav-derecha">
        <form action="indexLoginLogoff.php" method="post">
            <button name="cerrarSesion" class="btn-header">Cerrar sesión</button>
        </form>
    </div>
</header>
<main>
    <div class="card-central card-dashboard">
        
        <div class="welcome-msg">
            <?php
                // Obtener idioma de la cookie
                $idioma = $_COOKIE["idioma"] ?? "ES";
                
                if ($idioma == "ES") {
                    echo '<h2>Bienvenido <strong>' . $avInicioPrivado['descUsuario'] . '</strong></h2>';
                    echo '<p>Esta es la <strong>' . $avInicioPrivado['numConexiones'] . 'ª</strong> vez que se conecta.</p>';
                } elseif ($idioma == "EN") {
                    echo '<h2>Welcome <strong>' . $avInicioPrivado['descUsuario'] . '</strong></h2>';
                    echo '<p>This is the <strong>' . $avInicioPrivado['numConexiones'] . '</strong> time you have connected.</p>';
                } else {
                    echo '<h2>Bienvenue <strong>' . $avInicioPrivado['descUsuario'] . '</strong></h2>';
                    echo '<p>C\'est la <strong>' . $avInicioPrivado['numConexiones'] . 'e</strong> fois que vous vous connectez.</p>';
                }
            ?>
        </div>
        
        <?php if ($avInicioPrivado['numConexiones'] > 1 && $avInicioPrivado['fechaHoraUltimaConexionAnterior'] !== null): ?>
            <div class="info-conexion">
                <i class="fa-regular fa-clock"></i> Última conexión: 
                <strong><?php echo $avInicioPrivado['fechaHoraUltimaConexionAnterior']->format('d/m/Y H:i:s'); ?></strong>
            </div>
        <?php endif; ?>
    
        <div class="contenedor-boton-centro">
            <form action="indexLoginLogoff.php" method="post">
                <button name="detalle" class="btn-primary btn-detalle">
                    Ver Detalle <i class="fa-solid fa-arrow-right"></i>
                </button>
            </form>
        </div>
        
    </div>
</main>