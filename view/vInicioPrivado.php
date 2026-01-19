<?php
/**
 * @author: Enrique Nieto Lorenzo
 * @since: 18/01/2026
 * @description: Vista de Inicio Privado.
 */
?>
<header class="header-app">
    <div class="logo-seccion">
        <span class="titulo-tema">Portal Privado</span>
        <span class="subtitulo-tema">APLICACIÓN FINAL</span>
    </div>
    <div class="nav-derecha">
        <form action="index.php" method="post" style="display:inline;">
             <button name="cuenta" class="btn-header" title="Mi Cuenta">
                <i class="fa-solid fa-user-gear"></i> Cuenta
             </button>
        </form>

        <form action="index.php" method="post" style="display:inline;">
            <button name="cerrarSesion" class="btn-header">
                <i class="fa-solid fa-power-off"></i> Cerrar sesión
            </button>
        </form>
    </div>
</header>

<main>
    <div class="card-central card-dashboard">
        
        <div class="welcome-msg">
            <?php
                $idioma = $_COOKIE["idioma"] ?? "ES";
                if ($idioma == "ES") {
                    echo '<h2>Bienvenido <strong>' . $avInicioPrivado['descUsuario'] . '</strong></h2>';
                    echo '<p>Esta es la <strong>' . $avInicioPrivado['numConexiones'] . 'ª</strong> vez que se conecta.</p>';
                } elseif ($idioma == "EN") {
                    echo '<h2>Welcome <strong>' . $avInicioPrivado['descUsuario'] . '</strong></h2>';
                    echo '<p>This is the <strong>' . $avInicioPrivado['numConexiones'] . 'th</strong> time you connected.</p>';
                } else {
                    echo '<h2>Bienvenue <strong>' . $avInicioPrivado['descUsuario'] . '</strong></h2>';
                }
            ?>
        </div>
        
        <?php if ($avInicioPrivado['numConexiones'] > 1 && $avInicioPrivado['fechaHoraUltimaConexionAnterior'] !== null): ?>
            <div class="info-conexion">
                <i class="fa-regular fa-clock"></i> Última conexión: 
                <strong><?php echo $avInicioPrivado['fechaHoraUltimaConexionAnterior']->format('d/m/Y H:i:s'); ?></strong>
            </div>
        <?php endif; ?>
    
        <div class="dashboard-menu">
            
            <form action="index.php" method="post">
                <button name="mtoDepartamentos" class="btn-dashboard btn-blue">
                    <i class="fa-solid fa-building-user"></i> Mto. Departamentos
                </button>
            </form>

            <form action="index.php" method="post">
                <button name="rest" class="btn-dashboard btn-blue">
                    <i class="fa-solid fa-cloud"></i> REST
                </button>
            </form>

            <form action="index.php" method="post">
                <button name="detalle" class="btn-dashboard btn-gray">
                    <i class="fa-solid fa-eye"></i> Detalle
                </button>
            </form>

            <form action="index.php" method="post">
                <button name="error" class="btn-dashboard btn-red">
                    <i class="fa-solid fa-bug"></i> Test Error
                </button>
            </form>

        </div>
        
    </div>
</main>