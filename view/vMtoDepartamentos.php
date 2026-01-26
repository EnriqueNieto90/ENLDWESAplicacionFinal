<?php
/**
 * @author: Enrique Nieto Lorenzo
 * @since: 27/01/2026
 * @description: Vista Mto. Departamentos.
 */
?>
<main>
    <div class="card-central card-dashboard card-wide">
        
        <h2 class="titulo-login">Mantenimiento de Departamentos</h2>
        
        <form action="index.php" method="post" class="form-busqueda">
            <div class="grupo-busqueda">
                <input type="text" class="input-microsoft" name="descDepartamento" 
                       value="<?php echo $valorBuscar; ?>" 
                       placeholder="Buscar departamento por descripción">
                
                <button type="submit" name="buscar" class="btn-primary btn-search">
                    <i class="fa-solid fa-magnifying-glass"></i> Buscar
                </button>
            </div>
        </form>

        <div class="tabla-container">
            <?php if (!empty($aVistaDepartamentos)): ?>
                <table class="tabla-microsoft">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Descripción</th>
                            <th>Fecha Alta</th>
                            <th>Volumen Negocio</th>
                            <th>Fecha Baja</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($aVistaDepartamentos as $dep): ?>
                            <tr>
                                <td class="td-codigo"><strong><?php echo $dep['cod']; ?></strong></td>
                                <td><?php echo $dep['desc']; ?></td>
                                <td><?php echo $dep['fechaAlta']; ?></td>
                                <td><?php echo $dep['volumen']; ?></td>
                                <td class="<?php echo ($dep['fechaBaja'] !== '-') ? 'texto-rojo' : ''; ?>">
                                    <?php echo $dep['fechaBaja']; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="mensaje-vacio">
                    <i class="fa-solid fa-circle-info"></i> No se han encontrado departamentos.
                </div>
            <?php endif; ?>
        </div>

    </div>
</main>