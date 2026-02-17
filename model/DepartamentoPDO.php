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
    public static function buscaDepartamentosPorDesc($descDepartamento) {

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
     * Comprueba si existe un departamento con ese código en la BBDD.
     * @param string $codDepartamento Código del departamento a buscar.
     * @return boolean True si encontró el código (ya existe), false si no.
     */
    public static function validaCodNoExiste($codDepartamento) {
        
        $sql = "SELECT T02_CodDepartamento FROM T02_Departamento WHERE T02_CodDepartamento = :codDepartamento";
        $parametros = [':codDepartamento' => $codDepartamento];

        $consulta = DBPDO::ejecutarConsulta($sql, $parametros);

        // Si rowCount es mayor a 0, significa que el código ya está en la base de datos
        return $consulta->rowCount() > 0;
    }

    /**
     * Da de alta un nuevo departamento en la base de datos.
     * * Inserta un registro en la tabla T02_Departamento con la fecha de creación actual (NOW()) y la fecha de baja a null.
     * @param string $codDepartamento Código del departamento (PK, 3 letras mayúsculas).
     * @param string $descDepartamento Descripción o nombre del departamento.
     * @param float $volumenDeNegocio Volumen de negocio anual (permitiendo decimales).
     * @return Departamento|null Devuelve el objeto Departamento si se crea con éxito, o null si falla la inserción.
     */
    public static function altaDepartamento($codDepartamento, $descDepartamento, $volumenDeNegocio) {

        $sql = <<<SQL
            INSERT INTO T02_Departamento 
                (T02_CodDepartamento, T02_DescDepartamento, T02_FechaCreacionDepartamento, T02_VolumenDeNegocio, T02_FechaBajaDepartamento) 
            VALUES 
                (:cod, :desc, NOW(), :vol, NULL);
        SQL;

        $consulta = DBPDO::ejecutarConsulta($sql, [
                    ':cod' => $codDepartamento,
                    ':desc' => $descDepartamento,
                    ':vol' => $volumenDeNegocio
        ]);

        if ($consulta) {
            // Devolvemos el objeto creado para confirmar
            return self::buscaDepartamentoPorCod($codDepartamento);
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

        return $consulta; // Devuelve true si la consulta se ejecutó
    }

    /**
     * Elimina un departamento de la base de datos (Baja Física).
     * @param string $codDepartamento Código del departamento a eliminar.
     * @return boolean True si se borró correctamente, false si no.
     */
    public static function bajaFisicaDepartamento($codDepartamento) {
        $sql = "DELETE FROM T02_Departamento WHERE T02_CodDepartamento = :codDepartamento";

        return DBPDO::ejecutarConsulta($sql, [
                    ':codDepartamento' => $codDepartamento
                ])->rowCount() > 0;
    }

    /**
     * Realiza la baja lógica de un departamento.
     * Actualiza la fecha de baja al momento actual (NOW).
     * @param string $codDepartamento Código del departamento a desactivar.
     * @return boolean True si se realizó la actualización, false en caso contrario.
     */
    public static function bajaLogicaDepartamento($codDepartamento) {
        $sql = <<<SQL
            UPDATE T02_Departamento 
            SET T02_FechaBajaDepartamento = NOW() 
            WHERE T02_CodDepartamento = :codDepartamento
        SQL;

        $consulta = DBPDO::ejecutarConsulta($sql, [
                    ':codDepartamento' => $codDepartamento
        ]);

        // Devolvemos true si se ha afectado alguna fila
        return $consulta->rowCount() > 0;
    }

    /**
     * Realiza el alta lógica de un departamento.
     * Pone la fecha de baja a NULL para reactivarlo.
     * @param string $codDepartamento Código del departamento a reactivar.
     * @return boolean True si se realizó la actualización, false en caso contrario.
     */
    public static function altaLogicaDepartamento($codDepartamento) {
        $sql = <<<SQL
            UPDATE T02_Departamento 
            SET T02_FechaBajaDepartamento = NULL 
            WHERE T02_CodDepartamento = :codDepartamento
        SQL;

        $consulta = DBPDO::ejecutarConsulta($sql, [
                    ':codDepartamento' => $codDepartamento
        ]);

        return $consulta->rowCount() > 0;
    }
    
    /**
     * Cuenta departamentos filtrados por descripción y estado.
     */
    public static function contarDepartamentosPorDescEstado($descDepartamento, $estadoDepartamento) {
        $condicionEstado = "";
        
        switch ($estadoDepartamento) {
            case 'alta':
                $condicionEstado = "AND T02_FechaBajaDepartamento IS NULL";
                break;
            case 'baja':
                $condicionEstado = "AND T02_FechaBajaDepartamento IS NOT NULL";
                break;
            // 'todos' no añade condición
        }

        $sql = <<<SQL
            SELECT COUNT(*) as total 
            FROM T02_Departamento
            WHERE T02_DescDepartamento LIKE :descDepartamento
            $condicionEstado
        SQL;

        $consulta = DBPDO::ejecutarConsulta($sql, [
            ':descDepartamento' => '%' . $descDepartamento . '%'
        ]);

        if ($oDatos = $consulta->fetchObject()) {
            return $oDatos->total;
        }
        return 0;
    }

    /**
     * Busca departamentos con filtro y paginación (LIMIT y OFFSET).
     */
    public static function buscaDepartamentosPorDescEstadoPaginado($descDepartamento, $estadoDepartamento, $paginaActual) {
        // Calcular el offset (desplazamiento)
        $paginacion = (int) RESULTADOS_POR_PAGINA;
        $offset = ($paginaActual - 1) * $paginacion;

        $condicionEstado = "";
        switch ($estadoDepartamento) {
            case 'alta':
                $condicionEstado = "AND T02_FechaBajaDepartamento IS NULL";
                break;
            case 'baja':
                $condicionEstado = "AND T02_FechaBajaDepartamento IS NOT NULL";
                break;
        }

        // Consulta con LIMIT y OFFSET
        $sql = <<<SQL
            SELECT * FROM T02_Departamento
            WHERE T02_DescDepartamento LIKE :descDepartamento
            $condicionEstado
            LIMIT $paginacion OFFSET $offset
        SQL;

        $consulta = DBPDO::ejecutarConsulta($sql, [
            ':descDepartamento' => '%' . $descDepartamento . '%'
        ]);

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
     * Extrae los departamentos de la BBDD y los formatea en un array asociativo preparado para exportar a JSON.
     * @param string $descDepartamento Descripción por la que filtrar.
     * @return array Array asociativo con los datos puros de los departamentos.
     */
    public static function exportarDepartamentos($descDepartamento = "") {
        // Reutilizamos el método para obtener los objetos de la BBDD
        $aObjetosDepartamento = self::buscaDepartamentosPorDesc($descDepartamento); 
        
        $aExportacion = [];
        
        // Rellenamos un array asociativo con los objetos
        if ($aObjetosDepartamento) {
            foreach ($aObjetosDepartamento as $oDepto) {
                $aExportacion[] = [
                    'codDepartamento'           => $oDepto->getCodDepartamento(),
                    'descDepartamento'          => $oDepto->getDescDepartamento(),
                    'fechaCreacionDepartamento' => $oDepto->getFechaCreacionDepartamento(),
                    'volumenDeNegocio'          => $oDepto->getVolumenDeNegocio(),
                    'fechaBajaDepartamento'     => $oDepto->getFechaBajaDepartamento()
                ];
            }
        }
        
        // Devolvemos el array estructurado
        return $aExportacion;
    }
    
    /**
     * Importa un array de departamentos a la base de datos mediante una Transacción.
     * Si un solo departamento falla, se cancela toda la importación (Rollback).
     * * @param array $aDepartamentos Array asociativo extraído del JSON.
     * @return boolean True si se han insertado todos correctamente, False si ha habido algún error.
     */
    public static function importarDepartamentos($aDepartamentos) {
        
        // Preparamos la consulta SQL
        $sql = <<<SQL
            INSERT INTO T02_Departamento (
                T02_CodDepartamento, 
                T02_DescDepartamento, 
                T02_FechaCreacionDepartamento, 
                T02_VolumenDeNegocio, 
                T02_FechaBajaDepartamento
            ) VALUES (
                :codDepartamento, 
                :descDepartamento, 
                :fechaCreacion, 
                :volumenNegocio, 
                :fechaBaja
            )
        SQL;
        
        // Recorremos tu array $aDepartamentos para preparar la colección de parámetros
        $aParametrosTransaccion = [];
        
        foreach ($aDepartamentos as $aDepto) {
            $aParametrosTransaccion[] = [
                ':codDepartamento'  => $aDepto['codDepartamento'],
                ':descDepartamento' => $aDepto['descDepartamento'],
                // Si el JSON no trae fecha de creación, le ponemos la actual por defecto
                ':fechaCreacion'    => $aDepto['fechaCreacionDepartamento'] ?? date('Y-m-d H:i:s'),
                ':volumenNegocio'   => $aDepto['volumenDeNegocio'],
                // Si viene vacío o no existe, insertamos un NULL en la BD
                ':fechaBaja'        => empty($aDepto['fechaBajaDepartamento']) ? null : $aDepto['fechaBajaDepartamento']
            ];
        }

        // Ejecutamos la transacción delegando en DBPDO
        try {
            // Llamamos a nuestro nuevo método, pasándole la SQL y los parámetros empaquetados
            return DBPDO::ejecutarTransaccion($sql, $aParametrosTransaccion);
            
        } catch (PDOException $e) {
            // Registramos el error para el administrador.
            error_log("Error en importación de departamentos (Transacción cancelada): " . $e->getMessage());
            return false;
        }
    }
}

?>