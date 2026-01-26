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
}
?>