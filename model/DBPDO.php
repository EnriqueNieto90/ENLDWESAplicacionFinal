<?php
/**
 * @author: Enrique Nieto Lorenzo
 * @since: 18/01/2026
 * @description: Clase DBPDO para la gestión de la conexión a la base de datos.
 */

class DBPDO {
    
    public static function ejecutarConsulta($sentenciaSQL, $parametros = null) {
        try {
            $miDB = new PDO(DSN, USERNAME, PASSWORD);
            $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $consulta = $miDB->prepare($sentenciaSQL);
            $consulta->execute($parametros);
            
            return $consulta;

        } catch (PDOException $exception) {
            session_start();
            
            $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'] ?? 'inicioPublico';
            
            $_SESSION['error'] = new ErrorApp(
                $exception->getCode(),      // Código SQL
                $exception->getMessage(),   // Mensaje técnico
                $exception->getFile(),      // Archivo donde ocurrió
                $exception->getLine(),      // Línea
            );
            
            $_SESSION['paginaEnCurso'] = 'error';
            
            // Redirigimos directamente a index
            header('Location: index.php');
            exit;
        } finally {
            unset($miDB);
        }
    }
}
?>