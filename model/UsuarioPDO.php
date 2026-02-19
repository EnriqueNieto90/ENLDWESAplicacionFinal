<?php

/**
 * Clase que gestiona la persistencia y operaciones de los Usuarios en la base de datos.
 * * Actúa como el modelo DAO (Data Access Object) para la entidad Usuario, 
 * encapsulando todas las consultas SQL relativas a la tabla T01_Usuario 
 * (validación, inserción, modificación y eliminación).
 *
 * @author Enrique Nieto Lorenzo
 * @since 18/01/2026
 * @version 1.0.0
 */
final class UsuarioPDO {

    /**
     * Autentica a un usuario comprobando sus credenciales en la base de datos.
     * * Realiza una consulta filtrando por código de usuario y contraseña (cifrada con SHA256,
     * utilizando el propio código de usuario como SALT concatenado a la contraseña).
     * Si las credenciales son correctas, extrae los datos y devuelve una instancia de Usuario.
     *
     * @param string $codUsuario Código identificador del usuario.
     * @param string $password   Contraseña introducida por el usuario en texto plano.
     * @return Usuario|null Devuelve el objeto Usuario si el login es correcto, o null en caso de credenciales inválidas.
     */
    public static function validarUsuario($codUsuario, $password) {
        $oUsuario = null;

        // Construimos la consulta SQL
        $sql = <<<SQL
            SELECT * FROM T01_Usuario 
            WHERE T01_CodUsuario = :codUsuario 
            AND T01_Password = SHA2(:password, 256)
        SQL;

        // Ejecutamos la consulta
        $consulta = DBPDO::ejecutarConsulta($sql, [
                    ':codUsuario' => $codUsuario,
                    ':password' => $codUsuario . $password
        ]);

        if ($consulta && $consulta->rowCount() > 0) {
            $usuarioBD = $consulta->fetchObject();

            // Procesamos el resultado
            if ($usuarioBD) {
                // Convertimos fecha de string a DateTime
                $fechaBD = $usuarioBD->T01_FechaHoraUltimaConexion;
                $oFechaValida = ($fechaBD) ? new DateTime($fechaBD) : null;

                // Instanciamos el objeto Usuario
                $oUsuario = new Usuario(
                        $usuarioBD->T01_CodUsuario,
                        $usuarioBD->T01_Password,
                        $usuarioBD->T01_DescUsuario,
                        $usuarioBD->T01_NumConexiones,
                        $oFechaValida, // FechaHoraUltimaConexion (La que hay en BD)
                        null, // FechaHoraUltimaConexionAnterior (NULL al validar)
                        $usuarioBD->T01_Perfil,
                        $usuarioBD->T01_ImagenUsuario ?? null
                );
            }
        }

        return $oUsuario;
    }

    /**
     * Actualiza el registro de conexiones de un usuario en la base de datos y en memoria.
     * * Tras un login exitoso, este método incrementa el contador de conexiones (+1)
     * y actualiza la fecha de la última conexión (T01_FechaHoraUltimaConexion) al momento actual (NOW()).
     * Finalmente, sincroniza el objeto Usuario en memoria con estos nuevos datos.
     *
     * @param Usuario $oUsuario Objeto Usuario con los datos de la sesión recién iniciada.
     * @return Usuario|null Objeto Usuario actualizado en sus propiedades de conexión, o null si falló el UPDATE.
     */
    public static function registrarUltimaConexion($oUsuario) {
        //Actualizamos la BD
        $sql = <<<SQL
            UPDATE T01_Usuario SET 
                T01_FechaHoraUltimaConexion = NOW(),
                T01_NumConexiones = T01_NumConexiones + 1
            WHERE T01_CodUsuario = :codUsuario
        SQL;

        $consulta = DBPDO::ejecutarConsulta($sql, [
                    ':codUsuario' => $oUsuario->getCodUsuario()
        ]);

        if ($consulta) {
            // Actualizar Objeto en memoria
            // Lo que era la fecha actual, ahora es fecha anterior
            $oUsuario->setFechaHoraUltimaConexionAnterior($oUsuario->getFechaHoraUltimaConexion());

            // Sumamos 1 conexión
            $oUsuario->setNumConexiones($oUsuario->getNumConexiones() + 1);

            // Ponemos la actual fecha de conexión
            $oUsuario->setFechaHoraUltimaConexion(new DateTime());
        }

        return $oUsuario;
    }

    /**
     * Registra un nuevo usuario en el sistema.
     * * Inserta un registro en la tabla T01_Usuario, cifrando la contraseña mediante SHA256 
     * (concatenada con el código de usuario). Establece el perfil predeterminado como 'usuario',
     * inicializa el contador de conexiones a 1 y registra la fecha y hora actual de creación.
     *
     * @param string $codUsuario  Código único del usuario (PK).
     * @param string $password    Contraseña en texto plano a cifrar.
     * @param string $descUsuario Descripción o nombre completo del nuevo usuario.
     * @return Usuario|null Devuelve el objeto Usuario creado y listo para la sesión, o null si falló la inserción.
     */
    public static function altaUsuario($codUsuario, $password, $descUsuario) {
        $oUsuario = null;

        $sql = <<<SQL
            INSERT INTO T01_Usuario 
            (T01_CodUsuario, T01_Password, T01_DescUsuario, T01_NumConexiones, T01_FechaHoraUltimaConexion, T01_Perfil) 
            VALUES (:codUsuario, SHA2(:password, 256), :descUsuario, 1, NOW(), 'usuario')
        SQL;

        $parametros = [
            ':codUsuario' => $codUsuario,
            ':password' => $codUsuario . $password,
            ':descUsuario' => $descUsuario
        ];

        if (DBPDO::ejecutarConsulta($sql, $parametros)) {
            // Si se crea, lo validamos para devolver el objeto completo
            $oUsuario = new Usuario(
                    $codUsuario,
                    $password,
                    $descUsuario,
                    1,
                    new DateTime(),
                    null,
                    'usuario',
                    null
            );
        }
        return $oUsuario;
    }

    /**
     * Verifica la disponibilidad de un código de usuario.
     * * Consulta si un código primario ya está en uso en la tabla de usuarios. 
     * Fundamental para la validación de formularios de registro y evitar duplicidades de PK.
     *
     * @param string $codUsuario Código de usuario a verificar.
     * @return bool Devuelve true si el código está DISPONIBLE (no existe), y false si ya está OCUPADO.
     */
    public static function validarCodNoExiste($codUsuario) {
        $bNoExiste = true;

        $sql = "SELECT T01_CodUsuario FROM T01_Usuario WHERE T01_CodUsuario = :codUsuario";
        $consulta = DBPDO::ejecutarConsulta($sql, [':codUsuario' => $codUsuario]);

        if ($consulta && $consulta->rowCount() > 0) {
            $bNoExiste = false; // El usuario ya existe
        }

        return $bNoExiste;
    }

    /**
     * Modifica la descripción (Nombre completo) de un usuario existente.
     * * Actualiza físicamente la columna T01_DescUsuario en la base de datos y, 
     * en caso de éxito, actualiza la propiedad correspondiente en el objeto Usuario en memoria.
     *
     * @param Usuario $oUsuario         Objeto Usuario actual (sacado de la sesión).
     * @param string  $nuevoDescUsuario Nuevo nombre o descripción a establecer.
     * @return Usuario|null Devuelve el objeto Usuario actualizado, o null en caso de error en la BD.
     */
    public static function modificarUsuario($oUsuario, $nuevoDescUsuario) {

        // En la consulta a la DB solo actualizamos la descripción
        $sql = <<<SQL
            UPDATE T01_Usuario SET 
                T01_DescUsuario = :nuevoDescUsuario
            WHERE T01_CodUsuario = :codUsuario
        SQL;

        $consulta = DBPDO::ejecutarConsulta($sql, [
                    ':nuevoDescUsuario' => $nuevoDescUsuario,
                    ':codUsuario' => $oUsuario->getCodUsuario()
        ]);

        // Actualizar en la memoria
        if ($consulta) {
            $oUsuario->setDescUsuario($nuevoDescUsuario);
            return $oUsuario;
        }

        return null;
    }

    /**
     * Cambia y cifra la contraseña de un usuario.
     * * Actualiza el campo T01_Password aplicando de nuevo la función SHA256 
     * con el SALT correspondiente al usuario.
     *
     * @param string $codUsuario    Código identificador del usuario.
     * @param string $nuevaPassword La nueva contraseña introducida en texto plano.
     * @return bool Devuelve true si la actualización afectó a alguna fila (éxito), o false si falló.
     */
    public static function cambiarPassword($codUsuario, $nuevaPassword) {
        $sql = "UPDATE T01_Usuario SET T01_Password = SHA2(:password, 256) WHERE T01_CodUsuario = :codUsuario";

        $consulta = DBPDO::ejecutarConsulta($sql, [
                    ':password' => $codUsuario . $nuevaPassword,
                    ':codUsuario' => $codUsuario
        ]);

        return ($consulta && $consulta->rowCount() > 0);
    }

    /**
     * Elimina físicamente un usuario de la base de datos.
     * * Ejecuta un borrado permanente (DELETE) en la tabla T01_Usuario para el código indicado.
     *
     * @param string $codUsuario Código del usuario a eliminar.
     * @return boolean Devuelve true si se borró la fila correctamente, false en caso contrario.
     */
    public static function borrarUsuario($codUsuario) {
        $sql = "DELETE FROM T01_Usuario WHERE T01_CodUsuario = :codUsuario";

        return DBPDO::ejecutarConsulta($sql, [
                    ':codUsuario' => $codUsuario
                ])->rowCount() > 0;
    }

    /**
     * Obtiene una lista de usuarios filtrada parcialmente por descripción.
     * * Empleado generalmente en listados y búsquedas de mantenimiento.
     *
     * @param string $descUsuario Texto o subcadena para filtrar (ej. nombre).
     * @return Usuario[] Array de objetos Usuario coincidentes. Array vacío si no hay resultados.
     */
    public static function buscaUsuariosPorDesc($descUsuario) {

        $sql = <<<SQL
            SELECT * FROM T01_Usuario
            WHERE T01_DescUsuario LIKE :descUsuario
        SQL;

        $parametros = [
            ':descUsuario' => '%' . $descUsuario . '%'
        ];

        $consulta = DBPDO::ejecutarConsulta($sql, $parametros);
        $aUsuarios = [];

        if ($consulta->rowCount() > 0) {
            while ($oUsuario = $consulta->fetchObject()) {
                $aUsuarios[] = new Usuario(
                        $oUsuario->T01_CodUsuario,
                        $oUsuario->T01_Password,
                        $oUsuario->T01_DescUsuario,
                        $oUsuario->T01_NumConexiones,
                        $oUsuario->T01_FechaHoraUltimaConexion,
                        null,
                        $oUsuario->T01_Perfil,
                        $oUsuario->T01_ImagenUsuario,
                );
            }
        }

        return $aUsuarios;
    }

    /**
     * Modifica el nivel de privilegios (Perfil) de un usuario en la base de datos.
     * * Exclusivo para administradores. Cambia el campo T01_Perfil.
     *
     * @param string $codUsuario  Código del usuario a modificar.
     * @param string $nuevoPerfil Nuevo valor ('usuario' o 'administrador').
     * @return bool Devuelve true si la actualización fue exitosa, false en caso contrario.
     */
    public static function cambiarPerfilUsuario($codUsuario, $nuevoPerfil) {
        $sql = "UPDATE T01_Usuario SET T01_Perfil = :nuevoPerfil WHERE T01_CodUsuario = :codUsuario";

        $consulta = DBPDO::ejecutarConsulta($sql, [
                    ':nuevoPerfil' => $nuevoPerfil,
                    ':codUsuario' => $codUsuario
        ]);

        return ($consulta && $consulta->rowCount() > 0);
    }
}
?>

