<?php
/**
 * @author: Enrique Nieto Lorenzo
 * @since: 03/02/2026
 * @description: Vista Eliminar Departamento.
 */
?>
<main>
    <div class="card-central card-media">
        
        <div class="seccion-titulo encabezado-alerta">
            <div class="icono-alerta">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
            <h2 class="titulo-login titulo-peligro">¿Eliminar Departamento?</h2>
            <p class="texto-descripcion">
                Esta acción es irreversible. Se eliminarán los datos permanentemente.
            </p>
        </div>

        <form action="index.php" method="post">
            
            <div class="grupo-input">
                <label class="label-form">Código</label>
                <input type="text" class="input-microsoft" disabled
                       value="<?php echo $avEliminarDepartamento['codDepartamento']; ?>">
            </div>

            <div class="grupo-input">
                <label class="label-form">Descripción</label>
                <input type="text" class="input-microsoft" disabled
                       value="<?php echo $avEliminarDepartamento['descDepartamento']; ?>">
            </div>

            <div class="fila-flex">
                <div class="grupo-input col-flex">
                    <label class="label-form">Fecha Alta</label>
                    <input type="text" class="input-microsoft" disabled
                           value="<?php echo $avEliminarDepartamento['fechaCreacion']; ?>">
                </div>

                <div class="grupo-input col-flex">
                    <label class="label-form">Fecha Baja</label>
                    <input type="text" class="input-microsoft" disabled
                           value="<?php echo $avEliminarDepartamento['fechaBaja']; ?>">
                </div>
            </div>

            <div class="grupo-input">
                <label class="label-form">Volumen de Negocio</label>
                <input type="text" class="input-microsoft" disabled
                       value="<?php echo $avEliminarDepartamento['volumenNegocio']; ?>">
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

