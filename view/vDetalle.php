<?php
/**
 * @author: Enrique Nieto Lorenzo
 * @since: 15/12/2025
 * @description: Vista de Detalle.
 */
?>
<header class="header-app">
    <div class="logo-seccion">
        <span class="titulo-tema">Detalles</span>
        <span class="subtitulo-tema">LOGIN LOGOFF</span>
    </div>
    <div class="nav-derecha">
        <form action="indexLoginLogoff.php" method="post">
            <button name="cerrarSesion" class="btn-header">Cerrar sesión</button>
        </form>
    </div>
</header>

<main>
    <div class="contenedor-volver">
        <form action="indexLoginLogoff.php" method="post">
            <button name="volver" class="btn-link btn-volver-color">
                <i class="fa-solid fa-arrow-left"></i> Volver a Inicio
            </button>
        </form>
    </div>

    <div class="card-central card-dashboard card-wide">
        
        <h3 class="titulo-tabla titulo-tabla-first">Variables de Sesión</h3>
        <table class="tabla-microsoft">
            <tr><th>Clave</th><th>Valor</th></tr>
            <?php
            if (!empty($_SESSION)) {
                foreach ($_SESSION as $variable => $resultado) {
                    echo "<tr><td>".$variable."</td><td><pre>" . print_r($resultado, true) . "</pre></td></tr>";
                }
            } else { echo "<tr><td colspan='2'>Vacía</td></tr>"; }
            ?>
        </table>

        <h3 class="titulo-tabla">Cookies</h3>
        <table class="tabla-microsoft">
            <tr><th>Clave</th><th>Valor</th></tr>
            <?php
            if (!empty($_COOKIE)) {
                foreach ($_COOKIE as $variable => $resultado) {
                    echo "<tr><td>".$variable."</td><td><pre>" . $resultado . "</pre></td></tr>";
                }
            } else { echo "<tr><td colspan='2'>Vacía</td></tr>"; }
            ?>
        </table>

        <h3 class="titulo-tabla">Server</h3>
        <div class="scroll-container">
            <table class="tabla-microsoft">
                <tr><th>Clave</th><th>Valor</th></tr>
                <?php
                foreach ($_SERVER as $variable => $resultado) {
                    echo "<tr><td>".$variable."</td><td><pre>" . print_r($resultado, true) . "</pre></td></tr>";
                }
                ?>
            </table>
        </div>
        
        <h3 class="titulo-tabla">PHP Info</h3>
        <div class="phpinfo-container">
            <?php phpinfo(); ?>
        </div>

    </div>
</main>