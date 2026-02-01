<?php
/**
 * @author: Enrique Nieto Lorenzo
 * @since: 18/01/2026
 * @description: Controlador de Inicio Privado.
 */

// BOTÓN DETALLE
if (isset($_REQUEST['detalle'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    $_SESSION['paginaEnCurso'] = 'detalle';
    header('Location: index.php');
    exit;
}

// BOTÓN MTO DEPARTAMENTOS
if (isset($_REQUEST['mtoDepartamentos'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    $_SESSION['paginaEnCurso'] = 'mtoDepartamentos';    
    header('Location: index.php');
    exit;
}

// BOTÓN MTO USUARIOS (Solo para perfil administrador)
if (isset($_REQUEST['mtoUsuarios'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    $_SESSION['paginaEnCurso'] = 'wip'; 
    header('Location: index.php');
    exit;
}

// BOTÓN REST
if (isset($_REQUEST['rest'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    $_SESSION['paginaEnCurso'] = 'rest';
    header('Location: index.php');
    exit;
}

// BOTÓN ERROR
if (isset($_REQUEST['error'])) {
    $_SESSION['paginaAnterior'] = $_SESSION['paginaEnCurso'];
    $consultaError = "SELECT * FROM T03_Cuestion";
    DBPDO::ejecutarConsulta($consultaError);
    $_SESSION['paginaEnCurso'] = 'error';
    header('Location: index.php');
    exit;
}

// PREPARAR DATOS PARA LA VISTA EN UN ARRAY
$oUsuario = $_SESSION['usuarioENLAplicacionFinal'];
$avInicioPrivado = [
    'descUsuario' => $oUsuario->getDescUsuario(),
    'numConexiones' => $oUsuario->getNumConexiones(),
    'fechaHoraUltimaConexionAnterior' => $oUsuario->getFechaHoraUltimaConexionAnterior(),
    'perfil' => $oUsuario->getPerfil()
];
?>