<?php
/**
 * @author: Enrique Nieto Lorenzo
 * @since: 05/02/2026
 * @description: Vista Mto. Usuarios .
 */
?>
<main>
    <div class="card-central card-dashboard card-wide">

        <h2 class="titulo-login">Mantenimiento de Usuarios</h2>

        <form onsubmit="event.preventDefault();" class="form-busqueda">
            <div class="grupo-busqueda">
                <input id="campoBusquedaUsuario" type="text" class="input-microsoft input-busc" 
                       name="descUsuarioBuscado" 
                       value="" 
                       placeholder="Buscar usuario por descripción">
            </div>
        </form>

        <div class="tabla-container">
            <table id="tablaUsuarios" class="tabla-microsoft">
                <thead>
                    <tr>
                        <th>Código </th>
                        <th>Descripción</th>
                        <th>Nº Conexiones</th>
                        <th>Última conexión</th>
                        <th>Perfil</th>
                        <th class="text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody id="cuerpoTablaUsuarios">
                    </tbody>
            </table>
            
            <div id="mensajeVacio" class="mensaje-vacio" style="display: none;">
                <i class="fa-solid fa-circle-info"></i> No se han encontrado usuarios.
            </div>
        </div>

    </div>

    <script>
        // Referencias al DOM
        const cuerpoTabla = document.getElementById("cuerpoTablaUsuarios");
        const mensajeVacio = document.getElementById("mensajeVacio");
        const urlApi = "http://192.168.1.131/ENLDWESAplicacionFinal/api/wsBuscaUsuariosPorDescripcion.php";

        function mostrarUsuarios(usuarios) {
            
            cuerpoTabla.innerHTML = "";

            let htmlFilas = "";

            usuarios.forEach(usuario => {
                htmlFilas += `
                    <tr>
                        <td class="td-codigo"><strong>${usuario.codUsuario}</strong></td>
                        <td>${usuario.descUsuario}</td>
                        <td>${usuario.numConexiones}</td>
                        <td>${usuario.fechaHoraUltimaConexion ?? '-'}</td>
                        <td>${usuario.perfil}</td>
                        <td class="text-right">
                            <form method="post" class="form-inline" onsubmit="return false;"> 
                                <button class="btn-icon" title="Ver Detalle">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                                <button class="btn-icon" title="Borrar">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                `;
            });

            cuerpoTabla.innerHTML = htmlFilas;
        }

        // Carga inicial de datos
        fetch(urlApi)
            .then(response => response.json())
            .then(datos => mostrarUsuarios(datos))
            .catch(error => console.error('Error:', error));

        // Evento de búsqueda
        var inputBusqueda = document.getElementById("campoBusquedaUsuario");
        
        inputBusqueda.addEventListener("input", (event) => {
            localStorage.setItem("usuarioEncontradoEnCurso", inputBusqueda.value);
            fetch(urlApi + "?descUsuario=" + inputBusqueda.value)
                .then(response => response.json())
                .then(datos => mostrarUsuarios(datos))
                .catch(error => console.error('Error:', error));
        });
    </script>
</main>