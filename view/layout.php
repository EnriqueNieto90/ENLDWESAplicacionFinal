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
<body>
    <header class="header-app">
        
        <div class="marca-corporativa-ms">
            <div class="logo-icono-ms">
                <i class="fa-brands fa-microsoft"></i> 
            </div>
            <div class="logo-texto-ms">
                <span class="texto-principal">APLICACIÓN</span>
                <span class="texto-secundario">FINAL</span>
            </div>
        </div>

        <div class="header-titulo-central">
            <?php echo $titulos[$_SESSION['paginaEnCurso']] ?? 'Aplicación Final'; ?>
        </div>

        <div class="nav-derecha">

            <?php if (isset($_SESSION['usuarioENLAplicacionFinal'])): ?>
                
                <?php if ($_SESSION['paginaEnCurso'] !== 'inicioPrivado'): ?>
                    <form action="index.php" method="post" class="form-header">
                        <button name="volver" class="btn-header" title="Volver al Panel">
                            <i class="fa-solid fa-arrow-left"></i> <span class="btn-text-responsive">Volver</span>
                        </button>
                    </form>
                    <div class="separador-header"></div>
                <?php endif; ?>

                <form action="index.php" method="post" class="form-header">
                     <button name="cuenta" class="btn-header" title="Mi Cuenta">
                        <i class="fa-solid fa-user-gear"></i> <span class="btn-text-responsive">Cuenta</span>
                     </button>
                </form>
                
                <form action="index.php" method="post" class="form-header">
                    <button name="cerrarSesion" class="btn-header">
                        <i class="fa-solid fa-power-off"></i> <span class="btn-text-responsive">Cerrar sesión</span>
                    </button>
                </form>

            <?php else: ?>

                <?php if ($_SESSION['paginaEnCurso'] === 'inicioPublico'): ?>
                    
                    <form action="index.php" method="post" class="idioma-buttons">
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

                    <div class="separador-header"></div>

                    <form action="index.php" method="post" class="form-header">
                        <button name="iniciarSesion" class="btn-login-header">
                            <i class="fa-solid fa-user"></i> Iniciar Sesión
                        </button>
                    </form>
                <?php endif; ?>

                <?php if ($_SESSION['paginaEnCurso'] === 'login'): ?>
                    <form action="index.php" method="post" class="form-header">
                        <button name="cancelar" class="btn-header">
                            <i class="fa-solid fa-arrow-right-from-bracket"></i> Salir
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
                <a href="doc/index.html" target="_blank" class="link-destacado" title="Documentación PHPDoc">
                    <i class="fa-solid fa-book"></i> <span>PHPDoc</span>
                </a>
                <a href="webroot/media/CV_EnriqueNieto.pdf" target="_blank" class="link-destacado" title="Descargar Currículo">
                    <i class="fa-solid fa-file-pdf"></i> <span>CV</span>
                </a>
                <span class="separador-footer">|</span>
                <a href="https://www.microsoft.com/es-es/" target="_blank" title="Web Imitada (Microsoft)">
                    <i class="fa-brands fa-microsoft"></i>
                </a>
                <a href="https://github.com/EnriqueNieto90/ENLDWESAplicacionFinal" target="_blank" title="Repositorio GitHub">
                    <i class="fa-brands fa-github"></i>
                </a>
                <a href="../index.html" title="Web Personal">
                    <i class="fa-solid fa-house"></i>
                </a>
            </div>
        </div>
    </footer>

</body>
</html>