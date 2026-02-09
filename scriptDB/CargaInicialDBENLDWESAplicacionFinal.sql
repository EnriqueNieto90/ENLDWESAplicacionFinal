/**
 * Author:  Enrique Nieto Lorenzo
 * Created: 18 ene. 2026
 */

USE DBENLDWESAplicacionFinal;

INSERT INTO T02_Departamento (T02_CodDepartamento, T02_DescDepartamento, T02_FechaCreacionDepartamento, T02_VolumenDeNegocio, T02_FechaBajaDepartamento) VALUES
    -- Los originales (5)
    ('INF', 'Departamento de Informática.', now(), 1245.5, null),
    ('AUT', 'Departamento de Automoción.', now(), 8735.7, null),
    ('ELE', 'Departamento de Electricidad.', now(), 4375.2, null),
    ('MAT', 'Departamento de Matemáticas.', now(), 345.2, null),
    ('ING', 'Departamento de Inglés.', now(), 289.6, '2024-06-15 14:00:00'),
    ('BIO', 'Departamento de Biología.', now(), 1500.0, null),
    ('FIS', 'Departamento de Física.', now(), 2100.5, null),
    ('QUI', 'Departamento de Química.', now(), 1850.3, null),
    ('HIS', 'Departamento de Historia.', now(), 500.0, null),
    ('LEN', 'Departamento de Lengua Castellana.', now(), 900.2, null),
    ('FIL', 'Departamento de Filosofía.', now(), 300.1, null),
    ('FRA', 'Departamento de Francés.', now(), 670.8, null),
    ('ECO', 'Departamento de Economía.', now(), 3200.5, null),
    ('FOL', 'Departamento de Formación y Orientación.', now(), 1100.0, null),
    ('EFV', 'Departamento de Educación Física.', now(), 200.0, null),
    ('MUS', 'Departamento de Música.', now(), 450.6, null),
    ('REL', 'Departamento de Religión.', now(), 100.0, null),
    ('PLA', 'Departamento de Plástica.', now(), 560.3, null),
    ('TEC', 'Departamento de Tecnología.', now(), 2300.8, null),
    ('ADM', 'Departamento de Administración.', now(), 5600.9, null),
    ('COM', 'Departamento de Comercio.', now(), 4800.2, null),
    ('SAN', 'Departamento de Sanidad.', now(), 6700.1, null),
    ('HOT', 'Departamento de Hostelería.', now(), 7200.5, null),
    ('AGR', 'Departamento de Agraria.', now(), 3100.0, null),
    ('TIC', 'Tecnologías de la Información.', now(), 9500.5, null),
    ('GEO', 'Departamento de Geografía.', now(), 450.0, '2025-01-01 10:00:00'),
    ('ALE', 'Departamento de Alemán.', now(), 890.4, '2024-12-15 09:30:00'),
    ('LAT', 'Departamento de Latín.', now(), 150.2, '2023-06-20 14:00:00'),
    ('GRI', 'Departamento de Griego.', now(), 120.5, '2023-06-20 14:00:00'),
    ('SEC', 'Secretaría del Centro.', now(), 0.0, '2022-09-01 08:00:00');

INSERT INTO T01_Usuario (T01_CodUsuario,T01_Password,T01_DescUsuario) values
        ('gonzalo',SHA2('gonzalopaso',256),'Gonzalo Junquera Lorenzo'),
        ('enrique',SHA2('enriquepaso',256),'Enrique Nieto Lorenzo'),
        ('alvaroG',SHA2('alvarogpaso',256),'Alvaro Gonzalez'),
        ('jimmy',SHA2('jimmypaso',256),'Jimmy Nuñez Cuzcano'),
        ('oscar',SHA2('oscarpaso',256),'Oscar'),
        ('alejandro',SHA2('alejandropaso',256),'Alejandro'),
        ('alvaroA',SHA2('alvaroapaso',256),'Alvaro Allén Perlines'),
        ('vero',SHA2('veropaso',256),'Veronique Grue'),
        ('alberto',SHA2('albertopaso',256),'Alberto Mendez Nuñez'),
        ('jesus',SHA2('jesuspaso',256),'Jesus Temprano Gallego'),
        ('cristian',SHA2('cristianpaso',256),'Cristian Mateos Vega'),
        ('heraclio',SHA2('heracliopaso',256),'Heraclio Borbujo Moran'),
        ('amor',SHA2('amorpaso',256),'Amor Rodriguez Navarro'),
        ('albertoB',SHA2('albertobpaso',256),'Alberto Bahillo Fernandez'),
        ('antonio',SHA2('antoniopaso',256),'Antonio');

INSERT INTO T01_Usuario (T01_CodUsuario,T01_Password,T01_DescUsuario,T01_Perfil) values
        ('admin',SHA2('adminpaso',256),'Administrador','administrador');

