<?php
/**
 * @author: Enrique Nieto Lorenzo
 * @since: 11/01/2026
 * @description: Clase UsuarioPDO que gestiona las operaciones de usuario en la base de datos.
 */

require_once 'DBPDO.php';
require_once 'Usuario.php';

class UsuarioPDO {

    /**
     * Valida si un usuario existe y la contraseña es correcta.
     * Si es válido, actualiza la información de conexión y devuelve un objeto Usuario.
     * * @param string $codUsuario Código del usuario.
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
}
?>

