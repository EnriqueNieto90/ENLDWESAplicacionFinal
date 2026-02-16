/**
 * Vista del módulo de Mantenimiento de Usuarios.
 * Responsable de la manipulación del DOM, renderizado de la tabla HTML
 * y captura de eventos de usuario.
 * @author Enrique Nieto Lorenzo
 * @since 16/02/2026
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
     * @param {Function} ejecutarBusqueda Función del controlador que realiza la petición.
     */
    alBuscarUsuario(ejecutarBusqueda) {
        this.inputBusqueda.addEventListener("input", (evento) => {
            const descripcionBuscada = evento.target.value;
            // Delegamos la acción al controlador pasándole el dato limpio
            ejecutarBusqueda(descripcionBuscada);
        });
    }

    /**
     * Vincula el evento de borrado usando delegación de eventos.
     * Como los botones de borrar se crean dinámicamente con cada búsqueda,
     * ponemos un único listener en el tbody que siempre existe.
     * Cuando detecta un click, comprobamos si fue en un botón de borrar.
     * @param {Function} ejecutarBorrado Función del controlador que gestiona el borrado.
     */
    alBorrarUsuario(ejecutarBorrado) {
        this.tablaCuerpo.addEventListener("click", (evento) => {
            // closest() busca el botón de borrar subiendo desde donde se hizo click
            // Esto es necesario porque el click puede ser en el icono <i> dentro del botón
            const botonBorrar = evento.target.closest(".boton-borrar");
            
            if (botonBorrar) {
                const codUsuario = botonBorrar.dataset.cod;
                const descUsuario = botonBorrar.dataset.desc;
                ejecutarBorrado(codUsuario, descUsuario);
            }
        });
    }
    
    /**
     * Vincula el evento de cambiar contraseña usando delegación de eventos.
     * Mismo mecanismo que alBorrarUsuario: un listener en el tbody que detecta
     * clicks en los botones de cambiar contraseña creados dinámicamente.
     * @param {Function} ejecutarCambioPassword Función del controlador que gestiona el cambio.
     */
    alCambiarPassword(ejecutarCambioPassword) {
        this.tablaCuerpo.addEventListener("click", (evento) => {
            const botonPassword = evento.target.closest(".boton-cambiar-password");
            
            if (botonPassword) {
                const codUsuario = botonPassword.dataset.cod;
                const descUsuario = botonPassword.dataset.desc;
                ejecutarCambioPassword(codUsuario, descUsuario);
            }
        });
    }

    /**
     * Actualiza visualmente el campo de búsqueda.
     * Útil para restaurar el estado cuando el usuario regresa a la página.
     * @param {string} descripcionBuscada Texto a mostrar en el input.
     */
    setDescripcion(descripcionBuscada) {
        this.inputBusqueda.value = descripcionBuscada;
    }

    /**
     * Genera y muestra el HTML de la tabla a partir de los datos recibidos.
     * @param {Array} usuarios Lista de objetos usuario recibida del modelo.
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
                    <button class="btn-icon boton-cambiar-password" title="Canbiar contraseña"
                            data-cod="${usuario.codUsuario}" 
                            data-desc="${usuario.descUsuario}">
                        <i class="fa-solid fa-key"></i>
                    </button>
                    <button class="btn-icon boton-borrar" title="Borrar" 
                            data-cod="${usuario.codUsuario}" 
                            data-desc="${usuario.descUsuario}">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </td>
            </tr>
        `).join("");

        // Realizamos una única inserción en el DOM
        this.tablaCuerpo.innerHTML = htmlFilas;
    }

    /**
     * Muestra una ventana de confirmación personalizada antes de borrar.
     * Devuelve una Promesa: se resuelve a true si el usuario pulsa Aceptar,
     * o a false si pulsa Cancelar.
     * @param {string} descUsuario Nombre del usuario que se va a borrar.
     * @returns {Promise<boolean>}
     */
    mostrarConfirmacionBorrado(descUsuario) {
        return new Promise((resolve) => {
            // Creamos el fondo oscuro y el cuadro de confirmación
            const fondoOscuro = document.createElement("div");
            fondoOscuro.className = "fondo-oscuro";

            fondoOscuro.innerHTML = `
                <div class="cuadro-confirmacion">
                    <div class="confirmacion-icono">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </div>
                    <h3 class="confirmacion-titulo">¿Eliminar usuario?</h3>
                    <p class="confirmacion-texto">
                        Estás a punto de eliminar a <strong>${descUsuario}</strong> permanentemente.
                    </p>
                    <div class="confirmacion-botones">
                        <button class="btn-primary btn-peligro confirmacion-btn" id="btnConfirmarSi">
                            Aceptar
                        </button>
                        <button class="btn-primary btn-gris confirmacion-btn" id="btnConfirmarNo">
                            Cancelar
                        </button>
                    </div>
                </div>
            `;

            // Lo añadimos al body
            document.body.appendChild(fondoOscuro);

            // Función que cierra la ventana y devuelve la respuesta
            const cerrarVentana = (respuesta) => {
                fondoOscuro.remove();
                resolve(respuesta);
            };

            // Conectamos los botones
            fondoOscuro.querySelector("#btnConfirmarSi").addEventListener("click", () => cerrarVentana(true));
            fondoOscuro.querySelector("#btnConfirmarNo").addEventListener("click", () => cerrarVentana(false));
        });
    }
    
    /**
     * Muestra una ventana con campos para cambiar la contraseña de un usuario.
     * Incluye validación: los campos deben estar rellenos y coincidir.
     * Devuelve una Promesa: se resuelve con la nueva contraseña si el usuario
     * pulsa Aceptar y la validación es correcta, o con null si pulsa Cancelar.
     * @param {string} descUsuario Nombre del usuario al que se cambia la contraseña.
     * @returns {Promise<string|null>}
     */
    mostrarFormularioCambioPassword(descUsuario) {
        return new Promise((resolve) => {
            const fondoOscuro = document.createElement("div");
            fondoOscuro.className = "fondo-oscuro";

            fondoOscuro.innerHTML = `
                <div class="cuadro-confirmacion">
                    <div class="confirmacion-icono icono-azul">
                        <i class="fa-solid fa-key"></i>
                    </div>
                    <h3 class="confirmacion-titulo">Cambiar Contraseña</h3>
                    <p class="confirmacion-texto">
                        Nueva contraseña para <strong>${descUsuario}</strong>
                    </p>

                    <div class="grupo-input">
                        <input type="password" id="inputNuevaPassword" 
                               class="input-microsoft" 
                               placeholder="Nueva contraseña">
                    </div>
                    <div class="grupo-input">
                        <input type="password" id="inputRepetirPassword" 
                               class="input-microsoft" 
                               placeholder="Repetir contraseña">
                    </div>

                    <p id="errorPassword" class="error-msg" style="display: none;"></p>

                    <div class="confirmacion-botones">
                        <button class="btn-primary confirmacion-btn" id="btnConfirmarSi">
                            Aceptar
                        </button>
                        <button class="btn-primary btn-gris confirmacion-btn" id="btnConfirmarNo">
                            Cancelar
                        </button>
                    </div>
                </div>
            `;

            document.body.appendChild(fondoOscuro);

            // Ponemos el foco en el primer campo para que el usuario pueda escribir directamente
            fondoOscuro.querySelector("#inputNuevaPassword").focus();

            // Función que cierra la ventana y devuelve la respuesta
            const cerrarVentana = (respuesta) => {
                fondoOscuro.remove();
                resolve(respuesta);
            };

            // Botón Cancelar: cerramos sin hacer nada
            fondoOscuro.querySelector("#btnConfirmarNo").addEventListener("click", () => cerrarVentana(null));

            // Botón Aceptar: validamos antes de cerrar
            fondoOscuro.querySelector("#btnConfirmarSi").addEventListener("click", () => {
                const nuevaPassword = fondoOscuro.querySelector("#inputNuevaPassword").value;
                const repetirPassword = fondoOscuro.querySelector("#inputRepetirPassword").value;
                const mensajeError = fondoOscuro.querySelector("#errorPassword");

                // Validación: campos obligatorios
                if (!nuevaPassword || !repetirPassword) {
                    mensajeError.textContent = "Ambos campos son obligatorios.";
                    mensajeError.style.display = "block";
                    return;
                }

                // Validación: mínimo 4 caracteres
                if (nuevaPassword.length < 4) {
                    mensajeError.textContent = "La contraseña debe tener al menos 4 caracteres.";
                    mensajeError.style.display = "block";
                    return;
                }

                // Validación: las contraseñas deben coincidir
                if (nuevaPassword !== repetirPassword) {
                    mensajeError.textContent = "Las contraseñas no coinciden.";
                    mensajeError.style.display = "block";
                    return;
                }

                // Si todo es correcto, cerramos y devolvemos la contraseña
                cerrarVentana(nuevaPassword);
            });
        });
    }
}


