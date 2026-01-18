/**
 * Author:  Enrique Nieto Lorenzo
 * Created: 15 dic. 2025
 */

USE DBENLDWESLoginLogoff;

INSERT INTO T02_Departamento (T02_CodDepartamento,T02_DescDepartamento,T02_FechaCreacionDepartamento,T02_VolumenDeNegocio,T02_FechaBajaDepartamento) VALUES
        ('INF','Departamento de Informática.',now(),1245.5,null),
        ('AUT','Departamento de Automoción.',now(),8735.7,null),
        ('ELE','Departamento de Electricidad.',now(),4375.2,null),
        ('MAT','Departamento de Matemáticas.',now(),345.2,null),
        ('ING','Departamento de Inglés.',now(),289.6,now()
);

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

