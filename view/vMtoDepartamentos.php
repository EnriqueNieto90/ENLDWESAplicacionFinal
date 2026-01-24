<?php
/**
 * @author: Enrique Nieto Lorenzo
 * @description: Vista de Mantenimiento de Departamentos.
 */
?>
<main>
    <div class="contenedor-volver">
        <form action="index.php" method="post">
            <button name="volver" class="btn-link btn-bold">
                <i class="fa-solid fa-arrow-left"></i> Volver
            </button>
        </form>
    </div>
    <div class="card-central card-dashboard">
        <div class="welcome-msg">
            Mantenimiento de Departamentos
        </div>
        <div class="seccion-input">
            <div class="grupo-input-api">
                <input type="text" disabled class="input-microsoft input-disabled" placeholder="No disponible">
                <button disabled class="btn-primary btn-api btn-disabled">Buscar</button>
            </div>
        </div>
    </div>
</main>