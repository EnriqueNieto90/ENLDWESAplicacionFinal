# ENLDWESAplicacionFinal

## Descripción del Proyecto

Aplicación web completa de gestión empresarial desarrollada con arquitectura MVC y Programación Orientada a Objetos en PHP. Este proyecto integra un sistema robusto de autenticación con control de perfiles, mantenimiento completo de departamentos con operaciones CRUD avanzadas y consumo de servicios web REST externos.

La aplicación representa la culminación del aprendizaje en desarrollo web en entorno servidor, implementando las mejores prácticas profesionales: arquitectura multicapa, separación de responsabilidades, reutilización de código mediante POO, gestión de sesiones, control de acceso basado en roles (Administrador/Usuario) y operaciones avanzadas como baja lógica, rehabilitación y paginación de resultados.

**Tecnologías principales:** PHP 8.3 POO, MySQL/MariaDB, PDO, Apache, MVC, REST API, Sessions, Control de Roles

## Requisitos Técnicos

- **Servidor Web:** Apache 2.4+
- **PHP:** 8.3 o superior con soporte POO
- **Base de Datos:** MySQL 8.0+ / MariaDB 10.5+
- **Motor de BD:** InnoDB
- **Entorno:** LAMP (Linux, Apache, MySQL, PHP)
- **Extensiones PHP requeridas:**
  - PDO
  - pdo_mysql
  - session
  - curl (para consumo de APIs REST)
  - json
  - DateTime

## Instalación

### 1. Clonar el repositorio
```bash
git clone https://github.com/EnriqueNieto90/ENLDWESAplicacionFinal.git
```

### 2. Configurar en servidor local
Copiar el proyecto al directorio de publicación de Apache:
```bash
cp -r ENLDWESAplicacionFinal /var/www/html/httpdocs/
```

### 3. Configurar la base de datos
Ejecutar los scripts SQL en el siguiente orden:

**a) Crear base de datos y usuario:**
```bash
mysql -u adminsql -p < scriptDB/CreaDBENLDWESAplicacionFinal.sql
```

**b) Carga inicial de datos:**
```bash
mysql -u UserENLDWESAplicacionFinal -p DBENLDWESAplicacionFinal < scriptDB/CargaInicialDBENLDWESAplicacionFinal.sql
```

### 4. Configurar credenciales
Editar archivos de configuración:

**Base de datos:**
```php
// config/confDB.php
define('DB_HOST', 'localhost');
define('DB_NAME', 'DBENLDWESAplicacionFinal');
define('DB_USER', 'UserENLDWESAplicacionFinal');
define('DB_PASS', 'paso');
```

### 5. Configurar permisos
```bash
chmod -R 755 /var/www/html/httpdocs/ENLDWESAplicacionFinal
chmod -R 777 /var/www/html/httpdocs/ENLDWESAplicacionFinal/tmp
```

### 6. Acceder a la aplicación
Abrir navegador web y acceder a:
```
http://localhost/httpdocs/ENLDWESAplicacionFinal/index.php
```

## Arquitectura del Proyecto

### Patrón MVC con Control de Roles
```
                    ┌──────────────┐
                    │   USUARIO    │
                    └──────┬───────┘
                           │
                ┌──────────▼───────────┐
                │  AUTENTICACIÓN       │
                │  Control de Sesión   │
                └──────────┬───────────┘
                           │
          ┌────────────────┴────────────────┐
          │                                 │
    ┌─────▼──────┐                  ┌──────▼──────┐
    │ADMINISTRADOR│                  │   USUARIO   │
    │(perfil=admin)│                 │(perfil=user)│
    └─────┬──────┘                  └──────┬──────┘
          │                                 │
          │ Acceso Total                    │ Acceso Limitado
          ▼                                 ▼
┌──────────────────────┐         ┌──────────────────┐
│   CONTROLADORES      │         │  CONTROLADORES   │
│ - Usuarios           │         │ - Departamentos  │
└─────────┬────────────┘         └────────┬─────────┘
          │                               │
          └───────────┬───────────────────┘
                      ▼
              ┌───────────────┐
              │    MODELOS    │
              │   (PDO/BD)    │
              └───────┬───────┘
                      ▼
              ┌───────────────┐
              │ BASE DE DATOS │
              └───────────────┘
```

## Estructura del Proyecto
```
ENLDWESAplicacionFinal/
├── index.php                      # Controlador frontal
├── .htaccess                      # Configuración Apache
│
├── /config/                       # Configuración
│   ├── confDB.php                 # Credenciales BD
│   └── confAPP.php                # Configuración app
│
├── /controller/                   # CONTROLADORES
│   ├── cLogin.php                 # Login/Logoff
│   ├── cRegistro.php              # Registro usuarios
│   ├── cMiCuenta.php              # Editar perfil
│   ├── cCambiarPassword.php       # Cambiar contraseña
│   ├── cBorrarCuenta.php          # Eliminar cuenta
│   ├── cMtoDepartamentos.php      # CRUD Departamentos
│   ├── cBuscarDepartamento.php    # Búsqueda
│   ├── cAltaDepartamento.php      # Alta departamento
│   ├── cConsultarModificar.php    # Consulta/Edición
│   ├── cEliminarDepartamento.php  # Borrado físico
│   ├── cServicioREST.php          # Consumo API REST
│   └── cInicioPrivado.php         # Dashboard
│
├── /model/                        # MODELOS
│   ├── Usuario.php                # Entidad Usuario
│   ├── UsuarioPDO.php             # DAO Usuario
│   ├── Departamento.php           # Entidad Departamento
│   ├── DepartamentoPDO.php        # DAO Departamento
│   ├── DBPDO.php                  # Conexión PDO
│   ├── DB.php                     # Interface BD
│   ├── UsuarioDB.php              # Interface Usuario
│   └── DepartamentoDB.php         # Interface Departamento
│
├── /view/                         # VISTAS
│   ├── Layout.php                 # Plantilla base
│   ├── vLogin.php                 # Vista login
│   ├── vRegistro.php              # Vista registro
│   ├── vMiCuenta.php              # Vista editar perfil
│   ├── vCambiarPassword.php       # Vista cambio password
│   ├── vBorrarCuenta.php          # Vista borrar cuenta
│   ├── vInicioPrivado.php         # Dashboard
│   ├── vMtoDepartamentos.php      # Mantenimiento principal
│   ├── vBuscarDepartamento.php    # Búsqueda
│   ├── vAltaDepartamento.php      # Formulario alta
│   ├── vConsultarModificar.php    # Consulta/Edición
│   ├── vEliminarDepartamento.php  # Confirmación borrado
│   └── vServicioREST.php          # Consumo API REST
│
├── /core/                         # Librerías
│   ├── lValidacionFormularios.php
│
├── /api/                          # APIs REST propias
│   └── (reservado para futuras APIs)
│
├── /doc/                          # Documentación
│   ├── DiagramaCasosDeUso.pdf
│   ├── DiagramaClases.pdf
│   ├── ArbolNavegacion.pdf
│   ├── ModeloFisicoDatos.pdf
│   └── CatalogoRequisitos.pdf
│
├── /error/                        # Páginas de error
│   └── v403.php                   # Acceso denegado
│
├── /webroot/                      # Recursos públicos
│   ├── /css/
│   │   └── estilos.css
│   └── /img/
│       └── (imágenes aplicación)
│
├── /scriptDB/                     # Scripts SQL
    ├── CreaDBENLDWESAplicacionFinal.sql
    ├── CargaInicialDBENLDWESAplicacionFinal.sql
    └── BorraDBENLDWESAplicacionFinal.sql

```

## Modelo de Datos

### Tabla: T01_Usuario

| Campo | Tipo | Restricciones | Descripción |
|-------|------|---------------|-------------|
| **T01_CodUsuario** (PK) | VARCHAR(8) | NOT NULL, UNIQUE | Código de usuario (4-8 caracteres) |
| T01_Password | VARCHAR(255) | NOT NULL | Contraseña (hash bcrypt) |
| T01_DescUsuario | VARCHAR(255) | NOT NULL | Nombre completo del usuario |
| T01_NumConexiones | INT | DEFAULT 0 | Contador de accesos |
| T01_FechaHoraUltimaConexion | DATETIME | NULL | Última conexión |
| T01_FechaHoraUltimaConexionAnterior | DATETIME | NULL | Penúltima conexión |
| T01_Perfil | ENUM('usuario','administrador') | DEFAULT 'usuario' | Rol del usuario |
| T01_ImagenUsuario | VARCHAR(255) | NULL | Ruta imagen perfil |

### Tabla: T02_Departamento

| Campo | Tipo | Restricciones | Descripción |
|-------|------|---------------|-------------|
| **T02_CodDepartamento** (PK) | CHAR(3) | NOT NULL, UNIQUE | Código (3 letras mayúsculas) |
| T02_DescDepartamento | VARCHAR(255) | NOT NULL | Descripción del departamento |
| T02_FechaCreacionDepartamento | DATETIME | NOT NULL, DEFAULT CURRENT_TIMESTAMP | Fecha creación automática |
| T02_VolumenDeNegocio | DECIMAL(10,2) | NOT NULL | Volumen de negocio en euros |
| T02_FechaBajaDepartamento | DATETIME | NULL | Fecha baja lógica (NULL=activo) |

### Credenciales de Base de Datos

- **Base de datos:** DBENLDWESAplicacionFinal
- **Usuario aplicación:** UserENLDWESAplicacionFinal
- **Contraseña:** paso
- **Usuario administrador:** adminsql / paso

## Módulos de la Aplicación

### 1. Sistema de Autenticación

#### Registro de Usuarios (cRegistro.php / vRegistro.php)
**Funcionalidades:**
- Formulario de registro con validación
- Campos: Código usuario, Password, Confirmación password, Nombre completo
- Validaciones:
  - Código usuario único (4-8 caracteres alfanuméricos)
  - Contraseña mínimo 8 caracteres
  - Confirmación de contraseña coincidente
  - Nombre obligatorio
- Perfil por defecto: "usuario"

#### Login (cLogin.php / vLogin.php)
**Funcionalidades:**
- Formulario usuario/password
- Autenticación contra tabla T01_Usuario
- Actualización de:
  - Contador de conexiones (+1)
  - Fecha hora última conexión (actual)
  - Fecha hora última conexión anterior (previa)
- Creación de sesión con datos:
  - Código usuario
  - Descripción usuario
  - Perfil (usuario/administrador)
  - Hora inicio sesión
- Redirección según perfil a zona correspondiente

#### Mi Cuenta (cMiCuenta.php / vMiCuenta.php)
**Funcionalidades:**
- Editar descripción de usuario
- Mostrar información de cuenta:
  - Código usuario (bloqueado)
  - Descripción usuario (editable)
  - Perfil (bloqueado)
  - Número de conexiones
  - Última conexión
  - Penúltima conexión
- Botón "Guardar cambios"
- Botón "Cambiar Password" (enlace)
- Botón "Borrar Cuenta" (enlace)

#### Cambiar Password (cCambiarPassword.php / vCambiarPassword.php)
**Funcionalidades:**
- Formulario cambio de contraseña
- Campos:
  - Password actual (validación contra BD)
  - Password nueva (mínimo 8 caracteres)
  - Confirmar password nueva
- Validaciones:
  - Password actual correcta
  - Password nueva diferente a la actual
  - Confirmación coincidente

#### Borrar Cuenta (cBorrarCuenta.php / vBorrarCuenta.php)
**Funcionalidades:**
- Confirmación de eliminación de cuenta
- Advertencia sobre irreversibilidad
- Solicitar password para confirmar
- Borrado físico del usuario de la BD
- Destrucción de sesión
- Redirección a página pública

#### Logoff (cLogin.php con acción=logoff)
**Funcionalidades:**
- Destrucción completa de sesión
- Limpieza de cookies de sesión
- Redirección a login

### 2. Mantenimiento de Departamentos

#### Búsqueda de Departamentos (cBuscarDepartamento.php / vBuscarDepartamento.php)
**Funcionalidades:**
- Formulario de búsqueda
- Campo: Descripción departamento (búsqueda parcial con LIKE)
- Búsqueda en todos los departamentos (activos e inactivos)
- Resultados en tabla con:
  - Código
  - Descripción
  - Volumen de negocio
  - Fecha creación
  - Estado (Activo/Inactivo según fecha de baja)

#### Alta de Departamento (cAltaDepartamento.php / vAltaDepartamento.php)

**Funcionalidades:**
- Formulario de creación
- Campos:
  - Código departamento (3 letras mayúsculas, único)
  - Descripción (máximo 255 caracteres, obligatorio)
  - Volumen de negocio (decimal positivo, obligatorio)
- Validaciones:
  - Código único (verificación en BD)
  - Formato código: 3 letras mayúsculas
  - Descripción no vacía
  - Volumen de negocio numérico positivo

#### Consultar/Modificar Departamento (cConsultarModificar.php / vConsultarModificar.php)
**Funcionalidades:**
- Vista detalle completo del departamento
- Modo **Consulta**:
  - Todos los campos bloqueados
  - Solo visualización de datos
  - Botón "Volver"
- Modo **Edición**:
  - Código departamento (bloqueado, no modificable)
  - Descripción (editable)
  - Volumen de negocio (editable)
  - Fecha creación (bloqueada, no modificable)
  - Fecha baja (bloqueada, gestionada por baja lógica/rehabilitación)
  - Botón "Guardar cambios"
  - Botón "Cancelar"

#### Eliminar Departamento (cEliminarDepartamento.php / vEliminarDepartamento.php)

**Funcionalidades:**
- Página de confirmación
- Mostrar datos del departamento a eliminar
- Advertencia sobre irreversibilidad

### 3. Consumo de Servicios REST

#### Servicio REST Ajeno (cServicioREST.php / vServicioREST.php)
**Funcionalidades:**
- Consumo de API REST externa pública
- Ejemplo: API de datos públicos, clima, noticias, etc.
- Petición HTTP con `cURL` o `file_get_contents()`
- Procesamiento de respuesta JSON
```

## URLs de Acceso

### Aplicación en Producción
```
https://enriquenielor.ieslossauces.es/ENLDWESAplicacionFinal/
```

### Páginas principales
```
https://enriquenielor.ieslossauces.es/ENLDWESAplicacionFinal/index.php
```

## Características Destacadas

### Arquitectura y Diseño
- **Arquitectura MVC:** Separación completa en 3 capas
- **POO pura:** Clases, herencia, interfaces
- **Control de roles:** Permisos según perfil usuario/administrador
- **Front Controller:** Enrutamiento centralizado
- **Patrón DAO:** Acceso a datos encapsulado

### Seguridad Implementada
- **Prepared Statements:** Todas las consultas parametrizadas
- **Control de acceso:** Verificación de sesión y perfiles
- **Validación en capas:** Cliente, controlador y modelo
- **Sesiones seguras:** Regeneración de ID tras login
- **SQL Injection:** Prevención total con PDO

## Gestión de Base de Datos

### Crear la base de datos
```bash
mysql -u adminsql -p < scriptDB/CreaDBENLDWESAplicacionFinal.sql
```

### Cargar datos iniciales
```bash
mysql -u UserENLDWESAplicacionFinal -p DBENLDWESAplicacionFinal < scriptDB/CargaInicialDBENLDWESAplicacionFinal.sql
```

### Eliminar base de datos
```bash
mysql -u adminsql -p < scriptDB/BorraDBENLDWESAplicacionFinal.sql
```

## Tecnologías Utilizadas

- **Backend:** PHP 8.3 POO con MVC
- **Base de Datos:** MySQL 8.0 / MariaDB con InnoDB
- **Acceso a Datos:** PDO con Prepared Statements
- **Frontend:** HTML5, CSS3, JavaScript
- **Servidor:** Apache 2.4
- **APIs:** REST (consumo con cURL)
- **Sesiones:** PHP Sessions con control de roles
- **Control de versiones:** Git/GitHub
- **Documentación:** PHPDoc, UML

## Documentación Incluida

### Diagramas UML
- **Diagrama de Casos de Uso:** Actores y funcionalidades
- **Diagrama de Clases:** Relaciones entre clases
- **Árbol de Navegación:** Flujo de páginas
- **Modelo Físico de Datos:** Estructura de BD

## Autor

**Enrique Nieto Lorenzo**

Estudiante de DAW2 (Desarrollo de Aplicaciones Web)  
IES Los Sauces - Curso 2025/2026  
Módulo: DWES (Desarrollo Web en Entorno Servidor)

GitHub: EnriqueNieto90  
Repositorio: ENLDWESAplicacionFinal

---

**Proyecto Final del Módulo DWES**  
*Aplicación completa integrando todos los conocimientos adquiridos en el curso*
```
