-- Datos de ejemplo para poblar el sistema (solo para capturas/demostración)
SET FOREIGN_KEY_CHECKS=0;
TRUNCATE TABLE historial_academico;
TRUNCATE TABLE estudiantes;
TRUNCATE TABLE representantes;
SET FOREIGN_KEY_CHECKS=1;

INSERT INTO representantes (id_representante, parentesco, apellidos, nombres, nacionalidad, cedula, fecha_nacimiento, estado_civil, direccion_habitacion, grado_instruccion, ocupacion, telefono_1, telefono_2, condicion_vivienda, tipo_vivienda) VALUES
(1,'Madre','González Pérez','María Alejandra','V','14785236','1988-03-12','C','Av. Vargas, casa 45, Barquisimeto','Bachiller','Comerciante','0414-5236987',NULL,'Propia','Casa'),
(2,'Padre','Rodríguez Silva','José Gregorio','V','12369874','1985-07-22','C','Urb. La Carucieña, calle 3','Universitario','Docente','0416-7412589',NULL,'Propia','Casa'),
(3,'Madre','Martínez Ramos','Yulimar Coromoto','V','16987456','1990-11-05','S','Barrio Unión, sector 2','Bachiller','Ama de casa','0412-3698741',NULL,'Alquilada','Apartamento'),
(4,'Padre','Pérez Mendoza','Carlos Luis','V','11258963','1982-01-30','C','Av. Los Abogados, edif. Sol','Universitario','Ingeniero','0424-8523697',NULL,'Propia','Quinta'),
(5,'Madre','Suárez Colmenárez','Ana Teresa','V','18456321','1992-05-18','D','El Trompillo, calle principal','Técnico','Enfermera','0414-9638527',NULL,'Prestada','Casa'),
(6,'Madre','Hernández Torres','Rosa Virginia','V','15963258','1989-09-09','C','Urb. Nueva Segovia, casa 12','Bachiller','Costurera','0416-1472583',NULL,'Propia','Casa'),
(7,'Padre','Díaz Ortega','Pedro Antonio','V','10874596','1980-12-25','C','Zona Este, calle 8','Universitario','Abogado','0426-7539514',NULL,'Propia','Apartamento'),
(8,'Madre','Escalona Vargas','Luisa Fernanda','V','17456982','1991-04-14','S','Barrio El Cují, sector 4','Bachiller','Peluquera','0412-8529637',NULL,'Alquilada','Casa');

INSERT INTO estudiantes (id_estudiante, apellidos, nombres, nacionalidad, cedula, fecha_nacimiento, sexo, lugar_nacimiento, estado_nacimiento, municipio_nacimiento, parroquia_nacimiento, direccion_habitacion, tiene_canaima, serial_canaima, goza_beca, id_representante) VALUES
(1,'González Pérez','Santiago José','V','32145698','2016-06-10','M','Hospital Central','Lara','Iribarren','Catedral','Av. Vargas, casa 45','SI','CAN-2023-0451','NO',1),
(2,'Rodríguez Silva','Valentina Isabel','V','33698521','2015-02-20','F','Clínica Razetti','Lara','Iribarren','Concepción','Urb. La Carucieña, calle 3','SI','CAN-2022-1187','SI',2),
(3,'Martínez Ramos','Diego Alejandro','V','34125789','2017-08-15','M','Hospital Central','Lara','Iribarren','Unión','Barrio Unión, sector 2','NO',NULL,'NO',3),
(4,'Pérez Mendoza','Camila Andrea','V','31547896','2014-11-30','F','Clínica IDET','Lara','Iribarren','Santa Rosa','Av. Los Abogados','SI','CAN-2021-0098','NO',4),
(5,'Suárez Colmenárez','Sebastián David','V','34785214','2018-03-25','M','Hospital Central','Lara','Iribarren','El Cují','El Trompillo','NO',NULL,'SI',5),
(6,'Hernández Torres','Sofía Valentina','V','33214569','2016-09-12','F','Hospital Central','Lara','Iribarren','Catedral','Urb. Nueva Segovia','SI','CAN-2023-0778','NO',6),
(7,'Díaz Ortega','Mateo Gabriel','V','32987456','2015-05-08','M','Clínica Razetti','Lara','Iribarren','Juárez','Zona Este, calle 8','NO',NULL,'NO',7),
(8,'Escalona Vargas','Isabella Victoria','V','34569871','2017-12-03','F','Hospital Central','Lara','Iribarren','Tamaca','Barrio El Cují','SI','CAN-2022-0332','SI',8);

INSERT INTO historial_academico (id_estudiante, fecha_inscripcion, grado, repite, turno) VALUES
(1,'2025-09-15','3° Grado','NO','Mañana'),
(2,'2025-09-15','4° Grado','NO','Mañana'),
(3,'2025-09-16','2° Grado','NO','Tarde'),
(4,'2025-09-16','5° Grado','NO','Mañana'),
(5,'2025-09-17','1° Grado','NO','Tarde'),
(6,'2025-09-17','3° Grado','SI','Mañana'),
(7,'2025-09-18','4° Grado','NO','Tarde'),
(8,'2025-09-18','2° Grado','NO','Mañana');
