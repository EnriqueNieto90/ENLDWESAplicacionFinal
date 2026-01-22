<?php
/**
 * @author: Enrique Nieto Lorenzo
 * @since: 22/01/2026
 * @description: Vista del servicio REST
 */
?>

<header class="header-app">
    <div class="logo-seccion">
        <span class="titulo-tema">Servicios REST</span>
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
    <div class="contenedor-volver-rest">
        <form action="index.php" method="post">
            <button name="volver" class="btn-link btn-bold">
                <i class="fa-solid fa-arrow-left"></i> Volver
            </button>
        </form>
    </div>

    <div class="contenedor-rest">
        
        <div class="columna-api">
            <div class="tarjeta-api">
                <div class="seccion-input">
                    <form method="post">
                        <div class="grupo-input-api">
                            <input type="date" name="fechaNasa" class="input-microsoft" 
                                   value="<?php echo $avRest['fechaNasa']; ?>" 
                                   max="<?php echo date('Y-m-d'); ?>">
                            
                            <button type="submit" name="enviarNasa" class="btn-primary btn-api">
                                Buscar
                            </button>
                        </div>
                        <span class="error-msg"><?php echo $avRest['error']; ?></span>
                    </form>
                </div>

                <div class="seccion-titulo">
                    <h3><?php echo $avRest['fotoNasa']->getTitulo(); ?></h3>
                </div>
                
                <div class="seccion-contenido">
                    <img src="<?php echo $avRest['fotoNasa']->getUrl(); ?>" alt="Foto NASA" class="media-nasa">
                </div>
            </div>
        </div>

        <div class="columna-api">
            <div class="tarjeta-api">
                <div class="seccion-input">
                    <div class="grupo-input-api">
                        <input type="text" disabled class="input-microsoft input-disabled" placeholder="No disponible">
                        <button disabled class="btn-primary btn-api btn-disabled">Buscar</button>
                    </div>
                </div>

                <div class="seccion-titulo gris">
                    <h3>API</h3>
                </div>

                <div class="seccion-contenido">
                    <p class="texto-vacio"></p>
                </div>
            </div>
        </div>

        <div class="columna-api">
            <div class="tarjeta-api">
                 <div class="seccion-input">
                     <div class="grupo-input-api">
                         <input type="text" disabled class="input-microsoft input-disabled" placeholder="No disponible">
                         <button disabled class="btn-primary btn-api btn-disabled">Buscar</button>
                     </div>
                 </div>

                 <div class="seccion-titulo gris">
                    <h3>API Propia</h3>
                 </div>

                 <div class="seccion-contenido">
                     <p class="texto-vacio"></p>
                 </div>
            </div>
        </div>

    </div>
</main>