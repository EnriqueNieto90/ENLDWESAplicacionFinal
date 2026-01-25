<?php
/**
 * @author: Enrique Nieto Lorenzo
 * @since: 25/01/2026
 * @description: Vista de Detalle.
 */
?>
<main>
    <div class="card-central card-dashboard card-wide">
        
        <h3 class="titulo-tabla titulo-tabla-first">Variables de Sesión</h3>
        <table class="tabla-microsoft">
            <tr><th>Clave</th><th>Valor</th></tr>
            <?php
            if (!empty($avDetalle['session'])) {
                foreach ($avDetalle['session'] as $variable => $resultado) {
                    echo "<tr><td>".$variable."</td><td><pre>" . print_r($resultado, true) . "</pre></td></tr>";
                }
            } else { 
                echo "<tr><td colspan='2'>Vacía</td></tr>"; 
            }
            ?>
        </table>

        <h3 class="titulo-tabla">Cookies</h3>
        <table class="tabla-microsoft">
            <tr><th>Clave</th><th>Valor</th></tr>
            <?php
            if (!empty($avDetalle['cookie'])) {
                foreach ($avDetalle['cookie'] as $variable => $resultado) {
                    echo "<tr><td>".$variable."</td><td><pre>" . print_r($resultado, true) . "</pre></td></tr>";
                }
            } else { 
                echo "<tr><td colspan='2'>Vacía</td></tr>"; 
            }
            ?>
        </table>

        <h3 class="titulo-tabla">Server</h3>
        <div class="scroll-container">
            <table class="tabla-microsoft">
                <tr><th>Clave</th><th>Valor</th></tr>
                <?php
                // Usamos $avDetalle['server']
                foreach ($avDetalle['server'] as $variable => $resultado) {
                    echo "<tr><td>".$variable."</td><td><pre>" . print_r($resultado, true) . "</pre></td></tr>";
                }
                ?>
            </table>
        </div>
        
        <h3 class="titulo-tabla">PHP Info</h3>
        <div class="phpinfo-container">
            <?php 
                echo $avDetalle['phpInfo']; 
            ?>
        </div>

    </div>
</main>