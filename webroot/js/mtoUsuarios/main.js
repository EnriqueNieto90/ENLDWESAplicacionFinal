/**
 * Punto de entrada para el módulo de Javascript.
 * Se encarga de ensamblar las piezas de la arquitectura MVC una vez que la página ha cargado completamente.
 * @author Enrique Nieto Lorenzo
 * @since 08/02/2026
 */
import { UsuarioModel } from './UsuarioModel.js';
import { UsuarioView } from './UsuarioView.js';
import { UsuarioController } from './UsuarioController.js';

// Esperamos al evento DOMContentLoaded para asegurar que todos los elementos HTML existen antes de intentar manipularlos
document.addEventListener('DOMContentLoaded', () => {
    // Inyección de dependencias: Creamos Modelo y Vista y se los entregamos al Controlador
    const app = new UsuarioController(
        new UsuarioModel(), 
        new UsuarioView()
    );
    
    // Iniciamos la lógica de la funcionalidad
    app.iniciar();
});

