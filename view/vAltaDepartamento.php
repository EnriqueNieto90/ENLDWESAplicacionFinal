<?php
/**
 * @author: Enrique Nieto Lorenzo
 * @since: 03/02/2026
 * @description: Vista Alta Departamento.
 */
?>
<main>
    <div class="card-central card-media">
        
        <div class="seccion-titulo encabezado-centrado">
            <i class="fa-solid fa-building-circle-check icono-alta"></i>
            <h2 class="titulo-login">Nuevo Departamento</h2>
            <p class="texto-descripcion">Introduce los datos para registrar el departamento.</p>
        </div>

        <form action="index.php" method="post">
            
            <div class="grupo-input">
                <label for="codDepartamento" class="label-form">Código</label>
                <div class="input-icon-wrapper">
                    <i class="fa-solid fa-barcode icon-input"></i>
                    <input type="text" name="codDepartamento" id="codDepartamento" 
                           class="input-microsoft input-uppercase" placeholder="Ej: INF (3 Letras)"
                           value="<?php echo $_REQUEST['codDepartamento'] ?? ''; ?>"
                           maxlength="3">
                </div>
                <span class="error-msg"><?php echo $aErrores['codDepartamento']; ?></span>
            </div>

            <div class="grupo-input">
                <label for="descDepartamento" class="label-form">Descripción</label>
                <div class="input-icon-wrapper">
                    <i class="fa-regular fa-file-lines icon-input"></i>
                    <input type="text" name="descDepartamento" id="descDepartamento" 
                           class="input-microsoft" placeholder="Nombre del departamento"
                           value="<?php echo $_REQUEST['descDepartamento'] ?? ''; ?>">
                </div>
                <span class="error-msg"><?php echo $aErrores['descDepartamento']; ?></span>
            </div>

            <div class="grupo-input">
                <label for="volumenDeNegocio" class="label-form">Volumen de Negocio</label>
                <div class="input-icon-wrapper">
                    <i class="fa-solid fa-euro-sign icon-input"></i>
                    <input type="text" name="volumenDeNegocio" id="volumenDeNegocio" 
                           class="input-microsoft" placeholder="0.00"
                           value="<?php echo $_REQUEST['volumenDeNegocio'] ?? ''; ?>">
                </div>
                <span class="error-msg"><?php echo $aErrores['volumenDeNegocio']; ?></span>
            </div>

            <hr class="separador-horizontal">

            <div class="grupo-botones grupo-botones-vertical">
                <button type="submit" name="crear" class="btn-primary btn-verde btn-full">
                    Aceptar
                </button>
                
                <button type="submit" name="cancelar" class="btn-primary btn-gris btn-full">
                    Cancelar
                </button>
            </div>

        </form>
    </div>
</main>

