<?php
/**
 * @author: Enrique Nieto Lorenzo
 * @since: 24/01/2026
 * @description: Layout de la aplicación.
 */
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Aplicación Final</title>
        <link rel="stylesheet" href="webroot/css/all.min.css">
        <link rel="stylesheet" href="webroot/css/estilosLogin.css">
    </head>
    <body class="view-<?php echo $_SESSION['paginaEnCurso']; ?>">

        <header class="header-app">
            <div class="marca-corporativa-ms">
                <div class="logo-icono-ms"><i class="fas fa-layer-group"></i></div>
                <div class="logo-texto-ms">
                    <span class="texto-principal">APLICACIÓN</span>
                    <span class="texto-secundario">FINAL</span>
                </div>
            </div>

            <div class="header-titulo-central">
                <?php echo $tituloActual; ?>
            </div>

            <div class="nav-derecha">
                <?php if ($oUsuarioActivo): ?> 
                    <?php if ($mostrarBotonVolver): ?>
                        <form action="index.php" method="post" class="form-header">
                            <button name="volver" class="btn-header" title="Volver">
                                <i class="fa-solid fa-arrow-left"></i> Volver
                            </button>
                        </form>
                    <?php endif; ?>

                    <form action="index.php" method="post" class="form-header">
                        <button name="cuenta" class="btn-header btn-cuenta-circular" title="<?php echo $descUsuario; ?>">
                            <span class="letra-inicial"><?php echo $inicialUsuario; ?></span>
                        </button>
                    </form>

                    <form action="index.php" method="post" class="form-header">
                        <button name="cerrarSesion" class="btn-header">
                            <i class="fa-solid fa-power-off"></i> Cerrar sesión
                        </button>
                    </form>

                <?php else: ?>

                    <?php if ($mostrarBotonLogin): ?>
                        <form action="index.php" method="post" class="form-header">
                            <button name="login" class="btn-login-header">
                                <i class="fa-solid fa-user"></i> Iniciar Sesión
                            </button>
                        </form>
                    <?php endif; ?>

                    <?php if ($mostrarBotonVolverInicio): ?>
                        <form action="index.php" method="post" class="form-header">
                            <button name="cancelar" class="btn-header" title="Volver al Inicio">
                                <i class="fa-solid fa-house"></i> Volver a Inicio
                            </button>
                        </form>
                    <?php endif; ?>

                <?php endif; ?>
            </div>
        </header>

        <?php require_once $view[$_SESSION['paginaEnCurso']]; ?>

        <footer class="footer-microsoft">
            <div class="footer-content">
                <p class="copy-text">2025-26 IES LOS SAUCES. © Todos los derechos reservados.</p>
                <p>Enrique Nieto Lorenzo</p>

                <div class="footer-links">
                    <a href="#" class="link-destacado" title="Documentación PHPDoc">
                        <i class="fa-solid fa-book"></i> <span>PHPDoc</span>
                    </a>
                    <a href="#" class="link-destacado" title="Descargar Currículo">
                        <i class="fa-solid fa-file-pdf"></i> <span>CV</span>
                    </a>
                    <span class="separador-footer">|</span>
                    <a href="https://www.microsoft.com/es-es/" target="_blank" title="Web Imitada (Microsoft)">
                        <i class="fa-brands fa-microsoft"></i>
                    </a>
                    <a href="https://github.com/EnriqueNieto90/ENLDWESAplicacionFinal" target="_blank" title="Repositorio GitHub">
                        <i class="fa-brands fa-github"></i>
                    </a>
                    <a href="../index.html" target="_blank" title="Web Personal">
                        <i class="fa-solid fa-house"></i>
                    </a>
                </div>
            </div>
        </footer>

    </body>
</html>