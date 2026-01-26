<?php
/**
 * @author: Enrique Nieto Lorenzo
 * @since: 18/01/2026
 * @description: Clase UsuarioPDO que gestiona las operaciones de usuario en la base de datos.
 */

final class UsuarioPDO {

    /**
     * Valida si un usuario existe y la contraseña es correcta.
     * Si es válido, actualiza la información de conexión y devuelve un objeto Usuario.
     * @param string $codUsuario Código del usuario.
     * @param string $password Contraseña del usuario.
     * @return Usuario|null Devuelve el objeto Usuario si las credenciales son correctas, null en caso contrario.
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
            ':codUsuario'  => $codUsuario,
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
                    $oFechaValida,           // FechaHoraUltimaConexion (La que hay en BD)
                    null,                    // FechaHoraUltimaConexionAnterior (NULL al validar)
                    $usuarioBD->T01_Perfil,
                    $usuarioBD->T01_ImagenUsuario ?? null
                );
            }
        }

        return $oUsuario;
    }

    /**
     * Actualiza la fecha de última conexión y el contador de accesos en la base de datos.
     * @param Usuario $oUsuario Objeto Usuario a actualizar.
     * @return Usuario|null Objeto Usuario con la fecha de última conexión actualizada.
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
     * Registra un nuevo usuario en la base de datos.
     * @param string $codUsuario Código del usuario (PK).
     * @param string $password Contraseña (sin cifrar, se cifra dentro).
     * @param string $descUsuario Nombre completo del usuario.
     * @return Usuario|null Devuelve el objeto Usuario creado y logueado, o null si falla.
     */
    public static function altaUsuario($codUsuario, $password, $descUsuario) {
        $oUsuario = null;

        $sql = <<<SQL
            INSERT INTO T01_Usuario 
            (T01_CodUsuario, T01_Password, T01_DescUsuario, T01_NumConexiones, T01_FechaHoraUltimaConexion, T01_Perfil) 
            VALUES (:codUsuario, SHA2(:password, 256), :descUsuario, 1, NOW(), 'usuario')
        SQL;

        $parametros = [
            ':codUsuario'  => $codUsuario,
            ':password'    => $codUsuario . $password,
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
     * Comprueba si un código de usuario ya existe en la base de datos.
     * @param string $codUsuario Código a comprobar.
     * @return bool True si el código NO existe (está libre), False si YA existe.
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

}
?>

