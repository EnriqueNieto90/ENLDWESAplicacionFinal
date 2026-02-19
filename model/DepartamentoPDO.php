<?php
/**
 * Clase que gestiona la persistencia y operaciones de los Departamentos en la base de datos.
 * * Actúa como el modelo DAO (Data Access Object) para la entidad Departamento, encapsulando
 * todas las consultas SQL necesarias para el mantenimiento de la tabla T02_Departamento.
 *
 * @author Enrique Nieto Lorenzo
 * @since 27/01/2026
 * @version 1.1.0
 */
final class DepartamentoPDO {

    /**
     * Busca departamentos cuya descripción contenga la cadena proporcionada.
     * * Realiza una consulta SQL utilizando el operador LIKE para coincidencias parciales.
     * Si no se especifica cadena o está vacía, devuelve todos los departamentos.
     *
     * @param string $descDepartamento Descripción a buscar (o parte de ella).
     * @return Departamento[] Array de objetos Departamento encontrados, o array vacío si no hay coincidencias.
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
     * Busca un departamento específico utilizando su código identificador.
     *
     * @param string $codDepartamento Código único del departamento (PK).
     * @return Departamento|null Devuelve un objeto Departamento si lo encuentra, o null en caso contrario.
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
     * Comprueba la existencia de un departamento a través de su código.
     * * ATENCIÓN: A pesar del nombre del método, devuelve true si el departamento YA EXISTE 
     * en la base de datos (rowCount > 0). Útil para validaciones de claves duplicadas.
     *
     * @param string $codDepartamento Código del departamento a buscar.
     * @return boolean True si el departamento existe en la BBDD, false si no existe.
     */
    public static function validaCodNoExiste($codDepartamento) {
        
        $sql = "SELECT T02_CodDepartamento FROM T02_Departamento WHERE T02_CodDepartamento = :codDepartamento";
        $parametros = [':codDepartamento' => $codDepartamento];

        $consulta = DBPDO::ejecutarConsulta($sql, $parametros);

        // Si rowCount es mayor a 0, significa que el código ya está en la base de datos
        return $consulta->rowCount() > 0;
    }

    /**
     * Registra un nuevo departamento en la base de datos (Alta Física).
     * * Inserta un registro en la tabla T02_Departamento estableciendo automáticamente 
     * la fecha de creación actual (NOW()) y dejando la fecha de baja en NULL (activo).
     *
     * @param string $codDepartamento  Código único del departamento (PK, 3 letras mayúsculas).
     * @param string $descDepartamento Nombre o descripción del departamento.
     * @param float  $volumenDeNegocio Volumen de negocio económico.
     * @return Departamento|null Devuelve el objeto Departamento instanciado si la inserción fue exitosa, o null si falló.
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
     * Actualiza los datos modificables de un departamento existente.
     * * Permite modificar la descripción y el volumen de negocio referenciando el registro por su código.
     *
     * @param string $codDepartamento  Código del departamento a actualizar.
     * @param string $descDepartamento Nueva descripción del departamento.
     * @param float  $volumenDeNegocio Nuevo volumen de negocio.
     * @return PDOStatement|bool Devuelve el objeto PDOStatement evaluable como booleano para confirmar el éxito de la consulta.
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
     * Elimina un departamento permanentemente de la base de datos (Baja Física).
     *
     * @param string $codDepartamento Código del departamento a borrar.
     * @return boolean True si se eliminó alguna fila correctamente, false en caso contrario.
     */
    public static function bajaFisicaDepartamento($codDepartamento) {
        $sql = "DELETE FROM T02_Departamento WHERE T02_CodDepartamento = :codDepartamento";

        return DBPDO::ejecutarConsulta($sql, [
                    ':codDepartamento' => $codDepartamento
                ])->rowCount() > 0;
    }

    /**
     * Desactiva temporalmente un departamento en el sistema (Baja Lógica).
     * * En lugar de borrar el registro, actualiza el campo T02_FechaBajaDepartamento 
     * con la fecha y hora exacta de la solicitud (NOW()), ocultándolo de las consultas generales.
     *
     * @param string $codDepartamento Código del departamento a dar de baja.
     * @return boolean True si se actualizó la fila correctamente, false en caso contrario.
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
     * Reactiva un departamento previamente dado de baja (Alta Lógica).
     * * Elimina la fecha de baja (la establece a NULL), restaurando el departamento
     * al estado activo en el sistema.
     *
     * @param string $codDepartamento Código del departamento a rehabilitar.
     * @return boolean True si se actualizó la fila correctamente, false en caso contrario.
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
     * Calcula el número total de departamentos que coinciden con unos filtros dados.
     * * Esencial para construir sistemas de paginación precisos. Cuenta los registros 
     * filtrando tanto por coincidencia de texto como por su estado lógico.
     *
     * @param string $descDepartamento Cadena de texto a buscar en la descripción.
     * @param string $estadoDepartamento Estado para filtrar ('alta', 'baja', o 'todos').
     * @return int Número total de registros coincidentes. Devuelve 0 en caso de error o ausencia.
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
     * Obtiene un subconjunto de departamentos basado en filtros y parámetros de paginación.
     * * Combina la búsqueda por descripción y estado con cláusulas LIMIT y OFFSET
     * para devolver únicamente los registros correspondientes a la página solicitada.
     *
     * @param string $descDepartamento   Cadena de texto para filtrar la descripción.
     * @param string $estadoDepartamento Estado a filtrar ('alta', 'baja', o 'todos').
     * @param int    $paginaActual       Número de la página solicitada por el usuario.
     * @return Departamento[] Array de objetos Departamento para la página actual.
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
     * Prepara y estructura la información de los departamentos para su exportación a JSON.
     * * Solicita los datos a la BBDD a través de los métodos de búsqueda existentes, 
     * iterando sobre los objetos recuperados para extraer sus valores puros a un array asociativo.
     *
     * @param string $descDepartamento (Opcional) Cadena de texto para filtrar por descripción. Por defecto vacío.
     * @return array Array multidimensional con la estructura de datos lista para codificar en formato JSON.
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
     * Importa masivamente un conjunto de departamentos hacia la base de datos usando una Transacción.
     * * Toma los datos decodificados de un JSON, genera una colección estructurada de parámetros
     * y delega su inserción transaccional a la clase DBPDO. Si la base de datos rechaza 
     * un solo registro (ej: clave primaria duplicada), se ejecuta un Rollback automático 
     * revirtiendo cualquier cambio previo.
     *
     * @param array $aDepartamentos Array asociativo extraído del fichero JSON con la información a importar.
     * @return boolean Devuelve true si la totalidad de los departamentos se han insertado correctamente. False en caso de error.
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