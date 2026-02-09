<?php
/**
 * @author: Enrique Nieto Lorenzo
 * @since: 07/02/2026
 * @description: Vista Consultar Departamento.
 */
?>
<main>
    <div class="card-central card-media">
        
        <div class="seccion-titulo encabezado-centrado">
            <i class="fa-solid fa-eye icono-alta color-gris"></i>
            <h2 class="titulo-login">Consultar Departamento</h2>
        </div>

        <form action="index.php" method="post">
            
            <div class="grupo-input">
                <label class="label-form">Código</label>
                <input type="text" class="input-microsoft" disabled readonly
                       value="<?php echo $avConsultarDepartamento['codDepartamento']; ?>">
            </div>

            <div class="grupo-input">
                <label class="label-form">Descripción</label>
                <input type="text" class="input-microsoft" disabled readonly
                       value="<?php echo $avConsultarDepartamento['descDepartamento']; ?>">
            </div>

            <div class="grupo-input">
                <label class="label-form">Fecha Alta</label>
                <input type="text" class="input-microsoft" disabled readonly
                       value="<?php echo $avConsultarDepartamento['fechaCreacion']; ?>">
            </div>
            
            <div class="grupo-input">
                <label class="label-form">Volumen Negocio (€)</label>
                <input type="text" class="input-microsoft" disabled readonly
                       value="<?php echo $avConsultarDepartamento['volumenDeNegocio']; ?>">
            </div>
            
            <div class="grupo-input">
                <label class="label-form">Fecha Baja</label>
                <input type="text" class="input-microsoft" disabled readonly
                       value="<?php echo $avConsultarDepartamento['fechaBaja']; ?>">
            </div>

            <hr class="separador-horizontal">

            <div class="grupo-botones">
                <button type="submit" name="volver" class="btn-primary btn-gris btn-full">
                    Volver
                </button>
            </div>
        </form>
    </div>
</main>