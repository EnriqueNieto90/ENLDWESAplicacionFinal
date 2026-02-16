<?php
/**
 * @author: Enrique Nieto Lorenzo
 * @since: 05/02/2026
 * @description: Vista Mantenimiento de Usuarios (Cliente MVC).
 */
?>
<main>
    <div class="card-central card-dashboard card-wide">

        <h2 class="titulo-login">Mantenimiento de Usuarios</h2>

        <form onsubmit="event.preventDefault();" class="form-busqueda">
            <div class="grupo-busqueda">
                <input id="campoBusquedaUsuario" 
                       type="text" 
                       class="input-microsoft input-busc" 
                       name="descUsuarioBuscado" 
                       value="" 
                       placeholder="Buscar usuario por descripción">
            </div>
        </form>

        <div class="tabla-container tabla-usuarios">
            <table id="tablaUsuarios" class="tabla-microsoft">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Descripción<i class="fa-solid fa-long-arrow-down"></i></th>
                        <th>Nº Conexiones</th>
                        <th>Última conexión</th>
                        <th>Perfil</th>
                        <th class="text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody id="cuerpoTablaUsuarios">
                </tbody>
            </table>
            
            <div id="mensajeVacio" class="mensaje-vacio">
                <i class="fa-solid fa-circle-info"></i> No se han encontrado usuarios.
            </div>
        </div>

    </div>

    <script type="module" src="webroot/js/mtoUsuarios/main.js"></script>
</main>