/**
 * Modelo del módulo de Mantenimiento de Usuarios.
 * Se encarga exclusivamente de la comunicación con la API REST y la gestión de datos.
 * No contiene lógica de interfaz ni manipulación del DOM.
 * @author Enrique Nieto Lorenzo
 * @since 16/02/2026
 */
export class UsuarioModel {
    
    constructor() {
        // Definimos la clave de la API
        this.API_KEY = "xK9pQ2mW5vY8nZ4cT1bH7jL0dF3gR6sN";
        
        // Definimos las URLs de las APIs
        this.urlBuscar = "api/wsBuscaUsuariosPorDescripcion.php";
        this.urlBorrar = "api/wsBorraUsuario.php";
        this.urlCambiarPassword = "api/wsCambiaPasswordUsuario.php";
        this.urlCambiarPerfil = "api/wsCambiaPerfilUsuario.php";
    }
    
    /**
     * Devuelve las cabeceras estándar para todas las peticiones con la clave.
     * Este método es para no repetir código en cada fetch.
     */
    get headersSeguros() {
        return {
            'Content-Type': 'application/x-www-form-urlencoded',
            'x-api-key': this.API_KEY
        };
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
            const respuesta = await fetch(url, {
                method: 'GET',
                headers: { 'x-api-key': this.API_KEY }
            });
            
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
                headers: this.headersSeguros,
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
    
    /**
     * Solicita al servidor el cambio de contraseña de un usuario.
     * @param {string} codUsuario Código del usuario.
     * @param {string} nuevaPassword Nueva contraseña.
     * @returns {Object} Objeto con { exito: boolean, mensaje: string }
     */
    async cambiarPassword(codUsuario, nuevaPassword) {
        try {
            const respuesta = await fetch(this.urlCambiarPassword, {
                method: 'POST',
                headers: this.headersSeguros,
                body: `codUsuario=${encodeURIComponent(codUsuario)}&nuevaPassword=${encodeURIComponent(nuevaPassword)}`
            });

            if (!respuesta.ok) {
                throw new Error(`Error HTTP: ${respuesta.status}`);
            }

            return await respuesta.json();

        } catch (error) {
            console.error("Error en la capa de datos (cambio contraseña):", error);
            return { exito: false, mensaje: 'Error de conexión con el servidor.' };
        }
    }
    
    /**
     * Solicita al servidor el cambio de perfil de un usuario.
     * @param {string} codUsuario Código del usuario.
     * @param {string} nuevoPerfil Nuevo perfil ('usuario' o 'administrador').
     * @returns {Object} Objeto con { exito: boolean, mensaje: string }
     */
    async cambiarPerfil(codUsuario, nuevoPerfil) {
        try {
            const respuesta = await fetch(this.urlCambiarPerfil, {
                method: 'POST',
                headers: this.headersSeguros,
                body: `codUsuario=${encodeURIComponent(codUsuario)}&nuevoPerfil=${encodeURIComponent(nuevoPerfil)}`
            });

            if (!respuesta.ok) {
                throw new Error(`Error HTTP: ${respuesta.status}`);
            }

            return await respuesta.json();

        } catch (error) {
            console.error("Error en la capa de datos (cambio perfil):", error);
            return { exito: false, mensaje: 'Error de conexión con el servidor.' };
        }
    }
}

