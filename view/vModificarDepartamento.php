<?php
/**
 * @author: Enrique Nieto Lorenzo
 * @since: 07/02/2026
 * @description: Vista Modificar Departamento.
 */
?>
<main>
    <div class="card-central card-media">
        
        <div class="seccion-titulo encabezado-centrado">
            <i class="fa-solid fa-pen-to-square icono-alta color-azul"></i>
            <h2 class="titulo-login">Editar Departamento</h2>
        </div>

        <form action="index.php" method="post">
            
            <div class="grupo-input">
                <label class="label-form">Código</label>
                <div class="input-icon-wrapper">
                    <i class="fa-solid fa-barcode icon-input"></i>
                    <input type="text" class="input-microsoft" disabled readonly
                           value="<?php echo $avModificarDepartamento['codDepartamento']; ?>">
                </div>
            </div>

            <div class="grupo-input">
                <label class="label-form">Descripción</label>
                <div class="input-icon-wrapper">
                    <i class="fa-regular fa-file-lines icon-input"></i>
                    <input type="text" name="descDepartamento" class="input-microsoft input-busc"
                           value="<?php echo $avModificarDepartamento['descDepartamento']; ?>">
                </div>
                <span class="error-msg"><?php echo $aErrores['descDepartamento']; ?></span>
            </div>
            
            <div class="grupo-input">
                <label class="label-form">Volumen Negocio</label>
                <div class="input-icon-wrapper">
                    <i class="fa-solid fa-euro-sign icon-input"></i>
                    <input type="text" name="volumenDeNegocio" class="input-microsoft input-busc"
                           value="<?php echo $avModificarDepartamento['volumenDeNegocio']; ?>">
                </div>
                <span class="error-msg"><?php echo $aErrores['volumenDeNegocio']; ?></span>
            </div>
            
            <div class="grupo-input">
                <label class="label-form">Fecha Alta</label>
                <input type="text" class="input-microsoft" disabled readonly
                       value="<?php echo $avModificarDepartamento['fechaCreacion']; ?>">
            </div>

            <hr class="separador-horizontal">

            <div class="grupo-botones grupo-botones-vertical">
                <button type="submit" name="aceptar" class="btn-primary btn-full">
                    Aceptar
                </button>
                <button type="submit" name="cancelar" class="btn-primary btn-gris btn-full">
                    Cancelar
                </button>
            </div>
        </form>
    </div>
</main>
