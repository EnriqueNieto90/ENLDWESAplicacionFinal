<?php
/**
 * @author: Enrique Nieto Lorenzo
 * @since: 01/02/2026
 * @description: Vista Mto. Departamentos.
 */
?>
<main>
    <div class="card-central card-dashboard card-wide">

        <h2 class="titulo-login">Mantenimiento de Departamentos</h2>

        <form action="index.php" method="post" class="form-busqueda">
            <div class="grupo-busqueda">
                <input type="text" class="input-microsoft input-busc" name="descDepartamento" 
                       value="<?php echo $valorBuscar; ?>" 
                       placeholder="Buscar departamento por descripción">

                <button type="submit" name="buscar" class="btn-primary btn-search">
                    <i class="fa-solid fa-magnifying-glass"></i> Buscar
                </button>
            </div>
        </form>

        <div class="acciones-superiores">
            <form action="index.php" method="post">
                <button type="submit" name="anadir" class="btn-primary btn-verde">
                    <i class="fa-solid fa-plus"></i> Añadir Departamento
                </button>
            </form>
        </div>

        <div class="tabla-container">
            <?php if (!empty($avMtoDepartamentos)): ?>
                <table class="tabla-microsoft">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Descripción<i class="fa-solid fa-long-arrow-down"></i></th>
                            <th>Fecha Alta</th>
                            <th>Volumen Negocio</th>
                            <th>Fecha Baja</th>
                            <th class="text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($avMtoDepartamentos as $dep): ?>
                            <?php
                            $estaDeBaja = ($dep['fechaBaja'] !== '-');
                            ?>

                            <tr class="<?php echo $estaDeBaja ? 'fila-baja' : ''; ?>">

                                <td class="td-codigo"><strong><?php echo $dep['cod']; ?></strong></td>
                                <td><?php echo $dep['desc']; ?></td>
                                <td><?php echo $dep['fechaAlta']; ?></td>
                                <td><?php echo $dep['volumen']; ?></td>

                                <td>
                                    <?php echo $dep['fechaBaja']; ?>
                                </td>

                                <td class="text-right">
                                    <form method="post" class="form-inline">

                                        <input type="hidden" name="codDepartamento" value="<?php echo $dep['cod']; ?>">

                                        <button type="submit" name="editar" class="btn-icon" title="Editar">
                                            <i class="fa-solid fa-pen"></i>
                                        </button>

                                        <button type="submit" name="ver" class="btn-icon" title="Ver">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>

                                        <button type="submit" name="borrar" class="btn-icon" title="Borrar Definitivo">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>

                                        <?php if ($estaDeBaja): ?>
                                            <button type="submit" name="alta" class="btn-icon btn-alta" title="Reactivar">
                                                <i class="fa-solid fa-arrow-up"></i>
                                            </button>
                                        <?php else: ?>
                                            <button type="submit" name="baja" class="btn-icon btn-baja" title="Dar de Baja">
                                                <i class="fa-solid fa-arrow-down"></i>
                                            </button>
                                        <?php endif; ?>

                                    </form>
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