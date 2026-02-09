/**
 * Modelo del módulo de Mantenimiento de Usuarios.
 * Se encarga exclusivamente de la comunicación con la API REST y la gestión de datos.
 * No contiene lógica de interfaz ni manipulación del DOM.
 * @author Enrique Nieto Lorenzo
 * @since 08/02/2026
 */
export class UsuarioModel {
    
    constructor() {
        // Definimos la URL
        this.apiUrl = "http://daw208.local.ieslossauces.es/ENLDWESAplicacionFinal/api/wsBuscaUsuariosPorDescripcion.php";
    }

    /**
     * Solicita al servidor la lista de usuarios que coinciden con el criterio.
     * Utilizamos programación asíncrona para no congelar la interfaz mientras esperamos.
     * * @param {string} descripcionBuscada Texto introducido por el usuario.
     */
    async obtenerUsuarios(descripcionBuscada) {
        try {
            // Codificamos el texto para asegurar que caracteres especiales como tildes o espacios estén seguros en la URL
            const url = `${this.apiUrl}?descUsuario=${encodeURIComponent(descripcionBuscada)}`;
            
            // Pausamos la ejecución aquí hasta que el servidor responda
            const respuesta = await fetch(url);
            
            // Verificamos si la respuesta HTTP es correcta
            if (!respuesta.ok) {
                throw new Error(`Error HTTP: ${respuesta.status}`);
            }

            // Convertimos el cuerpo de la respuesta a formato JSON
            return await respuesta.json();

        } catch (error) {
            console.error("Error en la capa de datos:", error);
            // En caso de fallo devolvemos una lista vacía para evitar que la vista se rompa
            return []; 
        }
    }
}

