<?php
/**
 * @author: Enrique Nieto Lorenzo
 * @since: 18/01/2026
 * @description: Vista de Inicio Privado con Control de Acceso.
 */
?>
<main>
    <div class="card-central card-dashboard">
        
        <div class="welcome-msg">
            <?php
                $idioma = $_COOKIE["idioma"] ?? "ES";
                if ($idioma == "ES") {
                    echo '<h2>Bienvenido <strong>' . $avInicioPrivado['descUsuario'] . '</strong></h2>';
                    echo '<p>Esta es la <strong>' . $avInicioPrivado['numConexiones'] . 'ª</strong> vez que se conecta.</p>';
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
            
            <?php if (isset($controlAcceso['mtoDepartamentos']) && in_array($avInicioPrivado['perfil'], $controlAcceso['mtoDepartamentos'])): ?>
                <form action="index.php" method="post">
                    <button name="mtoDepartamentos" class="btn-dashboard btn-blue">
                        <i class="fa-solid fa-building-user"></i> Mto. Departamentos
                    </button>
                </form>
            <?php endif; ?>
            
            <?php if (isset($controlAcceso['mtoUsuarios']) && in_array($avInicioPrivado['perfil'], $controlAcceso['mtoUsuarios'])): ?>
                <form action="index.php" method="post">
                    <button name="mtoUsuarios" class="btn-dashboard btn-blue">
                        <i class="fa-solid fa-users-gear"></i> Mto. Usuarios
                    </button>
                </form>
            <?php endif; ?>

            <?php if (isset($controlAcceso['rest']) && in_array($avInicioPrivado['perfil'], $controlAcceso['rest'])): ?>
                <form action="index.php" method="post">
                    <button name="rest" class="btn-dashboard btn-blue">
                        <i class="fa-solid fa-cloud"></i> REST
                    </button>
                </form>
            <?php endif; ?>

            <?php if (isset($controlAcceso['detalle']) && in_array($avInicioPrivado['perfil'], $controlAcceso['detalle'])): ?>
                <form action="index.php" method="post">
                    <button name="detalle" class="btn-dashboard btn-gray">
                        <i class="fa-solid fa-eye"></i> Detalle
                    </button>
                </form>
            <?php endif; ?>

            <form action="index.php" method="post">
                <button name="error" class="btn-dashboard btn-red">
                    <i class="fa-solid fa-bug"></i> Test Error
                </button>
            </form>

        </div>
        
    </div>
</main>