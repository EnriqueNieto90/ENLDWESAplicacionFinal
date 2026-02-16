/**
 * Modelo del módulo de Mantenimiento de Usuarios.
 * Se encarga exclusivamente de la comunicación con la API REST y la gestión de datos.
 * No contiene lógica de interfaz ni manipulación del DOM.
 * @author Enrique Nieto Lorenzo
 * @since 16/02/2026
 */
export class UsuarioModel {
    
    constructor() {
        // Definimos las URLs de los endpoints
        this.urlBuscar = "api/wsBuscaUsuariosPorDescripcion.php";
        this.urlBorrar = "api/wsBorraUsuario.php";
    }

    /**
     * Solicita al servidor la lista de usuarios que coinciden con el criterio.
     * Utilizamos programación asíncrona para no congelar la interfaz mientras esperamos.
     * @param {string} descripcionBuscada Texto introducido por el usuario.
     */
    async obtenerUsuarios(descripcionBuscada) {
        try {
            // Codificamos el texto para asegurar que caracteres especiales como tildes o espacios estén seguros en la URL
            const url = `${this.urlBuscar}?descUsuario=${encodeURIComponent(descripcionBuscada)}`;
            
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

    /**
     * Solicita al servidor la eliminación de un usuario por su código.
     * Usamos POST porque borrar es una operación destructiva que modifica datos.
     * @param {string} codUsuario Código del usuario a eliminar.
     * @returns {Object} Objeto con { exito: boolean, mensaje: string }
     */
    async borrarUsuario(codUsuario) {
        try {
            // Enviamos la petición POST con el código del usuario
            const respuesta = await fetch(this.urlBorrar, {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `codUsuario=${encodeURIComponent(codUsuario)}`
            });

            if (!respuesta.ok) {
                throw new Error(`Error HTTP: ${respuesta.status}`);
            }

            // Devolvemos el objeto { exito, mensaje } que nos envía la API
            return await respuesta.json();

        } catch (error) {
            console.error("Error en la capa de datos (borrado):", error);
            return { exito: false, mensaje: 'Error de conexión con el servidor.' };
        }
    }
}

