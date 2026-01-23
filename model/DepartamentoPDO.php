<?php
/**
 * @author: Enrique Nieto Lorenzo
 * @since: 18/01/2026
 * @description: Clase UsuarioPDO que gestiona las operaciones de usuario en la base de datos.
 */

require_once 'DBPDO.php';
require_once 'Departamento.php';

class DepartamentoPDO {

    public static function buscaDepartamentosPorDesc($codUsuario, $password) {
        $oUsuario = null;
        
        // Construimos la consulta SQL
        $sql = <<<SQL
            "SELECT * FROM T02_Departamento 
            WHERE LOWER(T02_DescDepartamento) LIKE ?"
        SQL;

        $parametros = [
            ':codUsuario' => $codUsuario,
            ':password'   => $codUsuario . $password
        ];

        // Ejecutamos la consulta
        $consulta = DBPDO::ejecutarConsulta($sql, $parametros);

        // Procesamos el resultado
        if ($consulta && $consulta->rowCount() > 0) {
            
            $usuarioBD = $consulta->fetchObject();

            // Gestionamos la fecha anterior (puede ser null si es la primera vez)
            $fechaAnterior = $usuarioBD->T01_FechaHoraUltimaConexion 
                ? new DateTime($usuarioBD->T01_FechaHoraUltimaConexion) 
                : null;

            // Instanciamos el objeto Usuario
            $oUsuario = new Usuario(
                $usuarioBD->T01_CodUsuario,
                $usuarioBD->T01_Password,
                $usuarioBD->T01_DescUsuario,
                $usuarioBD->T01_NumConexiones + 1, // Sumamos la conexión actual
                new DateTime(),                    // Fecha actual
                $fechaAnterior,                    // Fecha guardada en BD antes de actualizar
                $usuarioBD->T01_Perfil,
                $usuarioBD->T01_ImagenUsuario ?? null
            );

            // Actualizamos la BBDD llamando al otro método
            self::registrarUltimaConexion($codUsuario);
        }

        return $oUsuario;
    }

    /**
     * Actualiza la fecha de última conexión y el contador de accesos en la base de datos.
     * * @param string $codUsuario Código del usuario a actualizar.
     * @return bool True si la actualización fue correcta.
     */
    public static function registrarUltimaConexion($codUsuario) {
        $sql = <<<SQL
            UPDATE T01_Usuario SET 
                T01_FechaHoraUltimaConexion = NOW(),
                T01_NumConexiones = T01_NumConexiones + 1
            WHERE T01_CodUsuario = :codUsuario
        SQL;

        $consulta = DBPDO::ejecutarConsulta($sql, [':codUsuario' => $codUsuario]);
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

