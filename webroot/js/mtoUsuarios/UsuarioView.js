/**
 * Vista del módulo de Mantenimiento de Usuarios.
 * Responsable de la manipulación del DOM, renderizado de la tabla HTML
 * y captura de eventos de usuario.
 * @author Enrique Nieto Lorenzo
 * @since 08/02/2026
 */
export class UsuarioView {
    
    constructor() {
        // Guardamos las referencias a los elementos HTML
        this.inputBusqueda = document.getElementById("campoBusquedaUsuario");
        this.tablaCuerpo = document.getElementById("cuerpoTablaUsuarios");
        this.mensajeVacio = document.getElementById("mensajeVacio");
    }

    /**
     * Vincula el evento de escritura del usuario con la lógica del controlador.
     * La vista no sabe buscar, por lo que recibe la función ejecutarBusqueda como parámetro y la llama cuando es necesario.
     * * @param {Function} ejecutarBusqueda Función del controlador que realiza la petición.
     */
    alBuscarUsuario(ejecutarBusqueda) {
        this.inputBusqueda.addEventListener("input", (evento) => {
            const descripcionBuscada = evento.target.value;
            // Delegamos la acción al controlador pasándole el dato limpio
            ejecutarBusqueda(descripcionBuscada);
        });
    }

    /**
     * Actualiza visualmente el campo de búsqueda.
     * Útil para restaurar el estado cuando el usuario regresa a la página.
     * * @param {string} descripcionBuscada Texto a mostrar en el input.
     */
    setDescripcion(descripcionBuscada) {
        this.inputBusqueda.value = descripcionBuscada;
    }

    /**
     * Genera y muestra el HTML de la tabla a partir de los datos recibidos.
     * * @param {Array} usuarios Lista de objetos usuario recibida del modelo.
     */
    mostrarUsuarios(usuarios) {
        // Limpiamos el contenido previo para evitar duplicados
        this.tablaCuerpo.innerHTML = "";

        // Gestionamos el estado visual cuando no hay resultados
        if (!usuarios || usuarios.length === 0) {
            this.mensajeVacio.style.display = "block";
            return;
        } 
        
        this.mensajeVacio.style.display = "none";
        
        // Creamos todo el bloque HTML en memoria
        const htmlFilas = usuarios.map(usuario => `
            <tr>
                <td class="td-codigo"><strong>${usuario.codUsuario}</strong></td>
                <td>${usuario.descUsuario}</td>
                <td>${usuario.numConexiones}</td>
                <td>${usuario.fechaHoraUltimaConexion ?? '-'}</td>
                <td>${usuario.perfil}</td>
                <td class="text-right">
                    <button class="btn-icon" title="Ver Detalle"><i class="fa-solid fa-eye"></i></button>
                    <button class="btn-icon" title="Borrar"><i class="fa-solid fa-trash"></i></button>
                </td>
            </tr>
        `).join("");

        // Realizamos una única inserción en el DOM
        this.tablaCuerpo.innerHTML = htmlFilas;
    }
}


