<?php
/**
 * @author: Enrique Nieto Lorenzo
 * @since: 02/02/2026
 * @description: Vista de confirmación de borrado de cuenta.
 */
?>
<main>
    <div class="card-central" style="max-width: 500px; text-align: center;">
        
        <div class="icono-alerta">
            <i class="fa-solid fa-triangle-exclamation"></i>
        </div>

        <h2 class="titulo-login" style="color: #d13438;">¿Eliminar cuenta?</h2>
        
        <p style="margin: 20px 0; font-size: 1.1em; color: #333;">
            Estás a punto de eliminar tu cuenta <strong>permanentemente</strong>. 
            <br>
            <span style="font-size: 0.9em; color: #666;">Todos tus datos se perderán y no podrás recuperarlos.</span>
        </p>

        <form action="index.php" method="post" class="form-botones-borrar">
            
            <button type="submit" name="eliminar" class="btn-primary btn-peligro">
                <i class="fa-solid fa-trash"></i> Sí, eliminar cuenta
            </button>

            <button type="submit" name="cancelar" class="btn-primary btn-gris">
                Cancelar
            </button>
            
        </form>

    </div>
</main>

