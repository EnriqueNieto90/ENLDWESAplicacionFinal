/**
 * Author:  Enrique Nieto Lorenzo
 * Created: 15 dic. 2025
 */

CREATE DATABASE IF NOT EXISTS DBENLDWESLoginLogoff;

USE DBENLDWESLoginLogoff;

CREATE TABLE IF NOT EXISTS T02_Departamento(
    T02_CodDepartamento VARCHAR(3) PRIMARY KEY,
    T02_DescDepartamento VARCHAR(255),
    T02_FechaCreacionDepartamento DATETIME NOT NULL,
    T02_VolumenDeNegocio FLOAT NULL,
    T02_FechaBajaDepartamento DATETIME NULL
);

CREATE TABLE IF NOT EXISTS T01_Usuario (
    T01_CodUsuario VARCHAR(10) NOT NULL,
        CHECK (LENGTH(T01_CodUsuario) >= 4),
        PRIMARY KEY (T01_CodUsuario),
    T01_Password VARCHAR(255) NOT NULL,
        CHECK (LENGTH(T01_Password) >= 4),
    T01_DescUsuario VARCHAR(255) NOT NULL,
    T01_NumConexiones INT NOT NULL default 0,
    T01_FechaHoraUltimaConexion DATETIME NOT NULL default now(),
    T01_Perfil VARCHAR(20) NOT NULL default 'usuario',
    T01_ImagenUsuario VARCHAR(255) default null
);

CREATE USER IF NOT EXISTS "userENLDWESLoginLogoff"@"%" IDENTIFIED BY "paso";
GRANT ALL PRIVILEGES ON *.* TO "userENLDWESLoginLogoff"@"%" WITH GRANT OPTION;

FLUSH PRIVILEGES;

