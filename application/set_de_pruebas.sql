INSERT INTO `total`(`anio`, `clave`, `dni`, `apellido`, `nombre`, `carrera`, `fecha_naci`, `sexo`, 
	`sede1`, `turno1`, `sede2`, `turno2`, `trabaja`, `rtrabaja`, `condicion`, `rcondicion`, 
	`debe`, `presenta`, `optapor`, `nacionalid`, `id_usuario`, `f_modif`) VALUES 
(0,0,22200615,'DEBE','ELENA',1,null,'G',33,2,34,2,1,null,2,null,1,null,51,1,1,'1/1/1'), 
(0,0,22200616,'DEBIA Y TRAJO','ELENA',1,null,'G',33,2,34,2,1,null,2,1,1,null,51,1,1,'1/1/1'), 
(0,0,22200617,'NO TRABAJA','ELENA',1,null,'G',33,2,34,2,1,null,1,null,1,null,51,1,1,'1/1/1'), 
(0,0,22200619,'TRABAJA','ELENA',1,null,'G',33,2,34,2,1,null,1,null,1,null,51,1,1,'1/1/1'), 
(0,0,22200620,'NO ELIGIO SEDE null','ELENA',1,null,'G',null,2,34,2,1,null,1,null,1,null,51,1,1,'1/1/1'), 
(0,0,22200621,'NO ELIGIO SEDE 0','ELENA',1,null,'G',0,2,34,2,1,null,1,null,1,null,51,1,1,'1/1/1')


INSERT INTO `usuarios`(`login`, `password`, `sede`, `d_usuario`, `email`) 
VALUES 
('sede1','gondola',1,'Montes de Oca','sede1@cbc.uba.ar'),
('sede2','paisaje',2,'Montes de Oca','sede1@cbc.uba.ar'),
('sede4','gondola',4,'Montes de Oca','sede1@cbc.uba.ar'),
('sede5','gondola',5,'Montes de Oca','sede1@cbc.uba.ar'),
('sede6','gondola',6,'Montes de Oca','sede1@cbc.uba.ar'),
('sede7','gondola',7,'Montes de Oca','sede1@cbc.uba.ar')


// Crear carpetas de descargas y descargas para las sedes a la altura de comun y application
// dentro de cargas y descargas, una carpeta por cada sede