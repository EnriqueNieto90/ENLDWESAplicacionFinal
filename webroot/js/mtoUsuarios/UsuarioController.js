/**
 * Controlador del módulo de Mantenimiento de Usuarios.
 * Actúa como intermediario entre Modelo y Vista.
 * Gestiona la lógica de negocio del cliente y la persistencia temporal en SessionStorage.
 * @author Enrique Nieto Lorenzo
 * @since 16/02/2026
 */
export class UsuarioController {
    
    constructor(model, view) {
        this.model = model;
        this.view = view;
        this.CLAVE_SESION = "busquedaUsuarioEnCurso";

        // Conectamos la Vista con este Controlador.
        // Usamos .bind para asegurar que la función ejecutarBusqueda mantenga el acceso a las propiedades del controlador aunque sea llamada desde la vista.
        this.view.alBuscarUsuario(this.ejecutarBusqueda.bind(this));
        this.view.alBorrarUsuario(this.ejecutarBorrado.bind(this));
    }

    /**
     * Inicializa el módulo verificando si existe una búsqueda anterior pendiente.
     * Esto permite mantener la experiencia de usuario al navegar entre páginas.
     */
    async iniciar() {
        const busquedaGuardada = sessionStorage.getItem(this.CLAVE_SESION);

        if (busquedaGuardada) {
            // Si hay memoria, restauramos la vista y ejecutamos la búsqueda
            this.view.setDescripcion(busquedaGuardada);
            await this.ejecutarBusqueda(busquedaGuardada);
        } else {
            // Si es la primera vez, cargamos el listado completo
            await this.ejecutarBusqueda(""); 
        }
    }

    /**
     * Flujo principal de la funcionalidad de búsqueda.
     * Coordina el almacenamiento, la petición de datos y la actualización visual.
     * * @param {string} descripcionBuscada Texto a buscar.
     */
    async ejecutarBusqueda(descripcionBuscada) {
        // Persistencia: Guardamos el estado actual en la sesión del navegador
        sessionStorage.setItem(this.CLAVE_SESION, descripcionBuscada);

        // Datos: Esperamos a que el modelo nos traiga la información actualizada
        const usuarios = await this.model.obtenerUsuarios(descripcionBuscada);

        // Interfaz: Ordenamos a la vista que pinte los resultados
        this.view.mostrarUsuarios(usuarios);
    }
    
    /**
     * Flujo principal de la funcionalidad de borrado.
     * Pide confirmación visual al usuario, ejecuta el borrado y refresca la tabla.
     * @param {string} codUsuario Código del usuario a eliminar.
     * @param {string} descUsuario Nombre del usuario (para mostrarlo en la confirmación).
     */
    async ejecutarBorrado(codUsuario, descUsuario) {
        // Pedimos confirmación a la Vista
        const confirmado = await this.view.mostrarConfirmacionBorrado(descUsuario);

        // Si el usuario cancela no hacemos nada
        if (!confirmado) {
            return;
        }

        // Pedimos al Modelo que ejecute el borrado en el servidor
        const resultado = await this.model.borrarUsuario(codUsuario);

        // Si se borró correctamente, refrescamos la tabla con la búsqueda actual
        if (resultado.exito) {
            const busquedaActual = sessionStorage.getItem(this.CLAVE_SESION) || "";
            await this.ejecutarBusqueda(busquedaActual);
        } else {
            alert(resultado.mensaje);
        }
    }
}

