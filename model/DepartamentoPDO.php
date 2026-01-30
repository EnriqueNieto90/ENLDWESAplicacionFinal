<?php
/**
 * @author: Enrique Nieto Lorenzo
 * @since: 27/01/2026
 * @description: Clase para gestionar el acceso a datos de Departamentos.
 */
final class DepartamentoPDO {

    /**
     * Busca departamentos cuya descripción contenga la cadena proporcionada.
     * @param string $descDepartamento Descripción a buscar (o parte de ella).
     * @return array Array de objetos Departamento encontrados.
     */
    public static function buscaDepartamentosPorDesc($descDepartamento){

        $sql = <<<SQL
            SELECT * FROM T02_Departamento
            WHERE T02_DescDepartamento LIKE :descDepartamento
        SQL;
        
        $parametros = [
            ':descDepartamento' => '%' . $descDepartamento . '%'
        ];

        $consulta = DBPDO::ejecutarConsulta($sql, $parametros);
        $aDepartamentos = [];

        if ($consulta->rowCount() > 0) {
            while ($oDep = $consulta->fetchObject()) {
                $aDepartamentos[] = new Departamento(
                    $oDep->T02_CodDepartamento,
                    $oDep->T02_DescDepartamento,
                    $oDep->T02_FechaCreacionDepartamento,
                    $oDep->T02_VolumenDeNegocio,
                    $oDep->T02_FechaBajaDepartamento
                );
            }
        }

        return $aDepartamentos;
    }
    
    /**
     * Busca un departamento por su código primario.
     * @param string $codDepartamento Código del departamento.
     * @return Departamento|null Objeto Departamento o null si no existe.
     */
    public static function buscaDepartamentoPorCod($codDepartamento) {
        $sql = "SELECT * FROM T02_Departamento WHERE T02_CodDepartamento = :codDepartamento";
        $parametros = [':codDepartamento' => $codDepartamento];
        
        $consulta = DBPDO::ejecutarConsulta($sql, $parametros);
        
        if ($consulta->rowCount() > 0) {
            $oDep = $consulta->fetchObject();
            return new Departamento(
                $oDep->T02_CodDepartamento,
                $oDep->T02_DescDepartamento,
                $oDep->T02_FechaCreacionDepartamento,
                $oDep->T02_VolumenDeNegocio,
                $oDep->T02_FechaBajaDepartamento
            );
        }
        return null;
    }

    /**
     * Modifica la descripción y el volumen de negocio de un departamento.
     * @param string $codDepartamento Código del departamento a modificar.
     * @param string $descDepartamento Nueva descripción.
     * @param float $volumenDeNegocio Nuevo volumen.
     * @return bool True si se modificó correctamente.
     */
    public static function modificaDepartamento($codDepartamento, $descDepartamento, $volumenDeNegocio) {
        $sql = <<<SQL
            UPDATE T02_Departamento 
            SET T02_DescDepartamento = :descDepartamento, 
                T02_VolumenDeNegocio = :volumenDeNegocio
            WHERE T02_CodDepartamento = :codDepartamento
        SQL;
        
        $parametros = [
            ':descDepartamento' => $descDepartamento,
            ':volumenDeNegocio' => $volumenDeNegocio,
            ':codDepartamento' => $codDepartamento
        ];
        
        $consulta = DBPDO::ejecutarConsulta($sql, $parametros);
        
        return $consulta; // Devuelve true si la consulta se ejecutó (aunque no cambie filas)
    }
}
?>