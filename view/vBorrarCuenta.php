<?php
/**
 * @author: Enrique Nieto Lorenzo
 * @since: 07/02/2026
 * @description: Vista de confirmación de borrado de cuenta.
 */
?>
<main>
    <div class="card-central card-media">
        
        <div class="seccion-titulo encabezado-alerta">
            <div class="icono-alerta">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>

            <h2 class="titulo-login titulo-peligro">¿Eliminar tu cuenta?</h2>
            
            <p class="texto-advertencia">
                Estás a punto de eliminar tu usuario <strong>permanentemente</strong>.
                <span class="subtexto-advertencia">
                    Todos tus datos se perderán y no podrás recuperarlos.
                </span>
            </p>
        </div>

        <form action="index.php" method="post">
            
            <div class="fila-flex">
                <div class="grupo-input col-flex">
                    <label class="label-form">Usuario</label>
                    <input type="text" class="input-microsoft" disabled readonly
                           value="<?php echo $avBorrarCuenta['codUsuario']; ?>">
                </div>
                
                <div class="grupo-input col-flex">
                    <label class="label-form">Perfil</label>
                    <input type="text" class="input-microsoft" disabled readonly
                           value="<?php echo $avBorrarCuenta['perfil']; ?>">
                </div>
            </div>

            <div class="grupo-input">
                <label class="label-form">Nombre y Apellidos</label>
                <input type="text" class="input-microsoft" disabled readonly
                       value="<?php echo $avBorrarCuenta['descUsuario']; ?>">
            </div>

            <div class="fila-flex">
                <div class="grupo-input col-flex">
                    <label class="label-form">Nº Conexiones</label>
                    <input type="text" class="input-microsoft" disabled readonly
                           value="<?php echo $avBorrarCuenta['numConexiones']; ?>">
                </div>

                <div class="grupo-input col-flex">
                    <label class="label-form">Última Conexión</label>
                    <input type="text" class="input-microsoft" disabled readonly
                           value="<?php echo $avBorrarCuenta['ultimaConexion']; ?>">
                </div>
            </div>

            <hr class="separador-horizontal">

            <div class="grupo-botones grupo-botones-vertical">
                
                <button type="submit" name="eliminar" class="btn-primary btn-peligro btn-full">
                    Aceptar
                </button>

                <button type="submit" name="cancelar" class="btn-primary btn-gris btn-full">
                    Cancelar
                </button>
                
            </div>

        </form>

    </div>
</main>

