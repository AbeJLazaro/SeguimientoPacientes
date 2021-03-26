#DATOS NECESARIOS***************************************************************
INSERT INTO CatalogoDiagnostico(Descripcion) VALUES ('DESCARTADO');
INSERT INTO CatalogoDiagnostico(Descripcion) VALUES ('PREDIABETES');
INSERT INTO CatalogoDiagnostico(Descripcion) VALUES ('DIABETES MELLITUS');
INSERT INTO CatalogoDiagnostico(Descripcion) VALUES ('PENDIENTE');
INSERT INTO CatalogoDiagnostico(Descripcion) VALUES ('CANCELADO');

INSERT INTO Categoria(Descripcion) VALUES('DIRECTOR');
INSERT INTO Categoria(Descripcion) VALUES('JEFE DE SERVICIO DE MEDICINA FAMILIAR');
INSERT INTO Categoria(Descripcion) VALUES('JEFE DE ENFERMERIA');
INSERT INTO Categoria(Descripcion) VALUES('JEFE DE LABORATORIO');
INSERT INTO Categoria(Descripcion) VALUES('ENFERMERIA');

INSERT INTO Subcategoria(Descripcion,Categoria_id) 
VALUES('AUXILIAR ENFERMERO GENERAL',4);
INSERT INTO Subcategoria(Descripcion,Categoria_id) 
VALUES('AUXILIAR ENFERMERO SALUD PUBLICA',4);
INSERT INTO Subcategoria(Descripcion,Categoria_id) 
VALUES('ENFERMERO GENERAL',4);
INSERT INTO Subcategoria(Descripcion,Categoria_id) 
VALUES('ENFERMERO ESPECIALISTA MEDICINA FAMILIAR',4);

INSERT INTO Estatus(NombreEstatus,Descripcion)
VALUES('FALTA ESTUDIOS DE LABORATORIO','EL PACIENTE AUN NO ASISTE A SU CITA 
  LOS ESTUDIOS DE LABORATORIO');
INSERT INTO Estatus(NombreEstatus,Descripcion)
VALUES('FALTA DE DIAGNOSTICO','EL PACIENTE AUN NO TIENE SU DIAGNOSTICO');
INSERT INTO Estatus(NombreEstatus,Descripcion)
VALUES('CON DIAGNOSTICO','EL PACIENTE YA FUE DIAGNOSTICADO CON SUS RESULTADOS DE
  LABORATORIO');

INSERT INTO CatalogoActivo(Descripcion) VALUES('ACTIVO');
INSERT INTO CatalogoActivo(Descripcion) VALUES('YA CON DIABETES MELLITUS');
INSERT INTO CatalogoActivo(Descripcion) VALUES('SIN VIGENCIA');
INSERT INTO CatalogoActivo(Descripcion) VALUES('ADSCRIPCION');
INSERT INTO CatalogoActivo(Descripcion) VALUES('OTRO');

INSERT INTO Color(Tipo,Color,allDay) VALUES('L','#3FBF7F','true');
INSERT INTO Color(Tipo,Color,allDay) VALUES('D','#7F3FBF','true');

#DATOS DE PRUEBA

insert into MedicoEnfermera (Matricula, Nombre, ApPaterno, ApMaterno, Contrasena, TipoUsuario,Categoria_id,Subcategoria_id) values ('1225024319', 'Fonsie', 'Tutchings', 'Heustice', MD5('XgUfzm7WJfu'), 'A',1,null);
insert into MedicoEnfermera (Matricula, Nombre, ApPaterno, ApMaterno, Contrasena, TipoUsuario,Categoria_id,Subcategoria_id) values ('2756851269', 'Syman', 'Caunter', 'Horsfield', MD5('8FmSIaMmad0'), 'A',2,null);
insert into MedicoEnfermera (Matricula, Nombre, ApPaterno, ApMaterno, Contrasena, TipoUsuario,Categoria_id,Subcategoria_id) values ('7373410114', 'Fonzie', 'Coie', 'Harsnipe', MD5('LiRKVU0'), 'A',3,null);
insert into MedicoEnfermera (Matricula, Nombre, ApPaterno, ApMaterno, Contrasena, TipoUsuario,Categoria_id,Subcategoria_id) values ('7752024642', 'Sabina', 'Bellwood', 'Simeone', MD5('Iul4B7RlpYe'), 'U',4,1);
insert into MedicoEnfermera (Matricula, Nombre, ApPaterno, ApMaterno, Contrasena, TipoUsuario,Categoria_id,Subcategoria_id) values ('5689813055', 'Torrance', 'Marfield', 'Ferryn', MD5('tqqmo7lFeMo'), 'U',4,1);
insert into MedicoEnfermera (Matricula, Nombre, ApPaterno, ApMaterno, Contrasena, TipoUsuario,Categoria_id,Subcategoria_id) values ('0818492748', 'Theresita', 'De la Perrelle', 'Alesio', MD5('icBGmxs2ZveE'), 'U',4,1);
insert into MedicoEnfermera (Matricula, Nombre, ApPaterno, ApMaterno, Contrasena, TipoUsuario,Categoria_id,Subcategoria_id) values ('2336868784', 'Nicolai', 'Gritton', 'Aspinell', MD5('dB5OqCGMV'), 'U',4,1);
insert into MedicoEnfermera (Matricula, Nombre, ApPaterno, ApMaterno, Contrasena, TipoUsuario,Categoria_id,Subcategoria_id) values ('3516394379', 'Deidre', 'Ianniello', 'Morit', MD5('mW35D5Uoap'), 'U',4,1);
insert into MedicoEnfermera (Matricula, Nombre, ApPaterno, ApMaterno, Contrasena, TipoUsuario,Categoria_id,Subcategoria_id) values ('3829378631', 'Morty', 'Wasbrough', 'Quilleash', MD5('5PbNB8iepC'), 'U',4,1);
insert into MedicoEnfermera (Matricula, Nombre, ApPaterno, ApMaterno, Contrasena, TipoUsuario,Categoria_id,Subcategoria_id) values ('0409691744', 'Tracy', 'Finders', 'Broggio', MD5('nGZ0eVXA0Vgi'), 'U',4,1);


insert into Paciente (NSSA, Nombre, ApPaterno, ApMaterno, Calle, NumeroExterior, NumeroInterior, Colonia, Delegacion, CorreoElectronico, Estatus_id, CatalogoActivo_id, MedicoEnfermera_id) values ('127-19-1661', 'Bev', 'Kinig', 'Highway', 'Northport', '83', null, 'Shoshone', 'Valley Edge', 'bhighway0@ycombinator.com', '1', '1', FLOOR(RAND(10)*10));
insert into Paciente (NSSA, Nombre, ApPaterno, ApMaterno, Calle, NumeroExterior, NumeroInterior, Colonia, Delegacion, CorreoElectronico, Estatus_id, CatalogoActivo_id, MedicoEnfermera_id) values ('784-24-1112', 'Kristal', 'Orrocks', 'Wheelhouse', 'Novick', '82', null, 'Eagle Crest', 'Anzinger', 'kwheelhouse1@example.com', '1', '1', FLOOR(RAND(10)*10));
insert into Paciente (NSSA, Nombre, ApPaterno, ApMaterno, Calle, NumeroExterior, NumeroInterior, Colonia, Delegacion, CorreoElectronico, Estatus_id, CatalogoActivo_id, MedicoEnfermera_id) values ('547-32-4301', 'Randell', 'Frawley', 'Pounder', 'Muir', '23319', null, 'Burrows', 'Forest Dale', 'rpounder2@usda.gov', '1', '1', FLOOR(RAND(10)*10));
insert into Paciente (NSSA, Nombre, ApPaterno, ApMaterno, Calle, NumeroExterior, NumeroInterior, Colonia, Delegacion, CorreoElectronico, Estatus_id, CatalogoActivo_id, MedicoEnfermera_id) values ('715-84-5024', 'Marietta', 'Kilner', 'Leaf', 'Lerdahl', '93', null, 'Cordelia', 'Old Gate', 'mleaf3@gizmodo.com', '1', '1', FLOOR(RAND(10)*10));
insert into Paciente (NSSA, Nombre, ApPaterno, ApMaterno, Calle, NumeroExterior, NumeroInterior, Colonia, Delegacion, CorreoElectronico, Estatus_id, CatalogoActivo_id, MedicoEnfermera_id) values ('421-90-4340', 'Margaretha', 'Bridden', 'Girogetti', 'Fallview', '06341', null, 'Shopko', 'Oakridge', 'mgirogetti4@nps.gov', '1', '1', FLOOR(RAND(10)*10));
insert into Paciente (NSSA, Nombre, ApPaterno, ApMaterno, Calle, NumeroExterior, NumeroInterior, Colonia, Delegacion, CorreoElectronico, Estatus_id, CatalogoActivo_id, MedicoEnfermera_id) values ('249-72-5591', 'Nanette', 'Crapper', 'Schule', 'Thierer', '4608', null, 'Schurz', 'Morningstar', 'nschule5@studiopress.com', '1', '1', FLOOR(RAND(10)*10));
insert into Paciente (NSSA, Nombre, ApPaterno, ApMaterno, Calle, NumeroExterior, NumeroInterior, Colonia, Delegacion, CorreoElectronico, Estatus_id, CatalogoActivo_id, MedicoEnfermera_id) values ('556-68-4849', 'Caria', 'Egleton', 'Meus', 'Emmet', '6483', null, 'Knutson', 'Katie', 'cmeus6@cmu.edu', '1', '1', FLOOR(RAND(10)*10));
insert into Paciente (NSSA, Nombre, ApPaterno, ApMaterno, Calle, NumeroExterior, NumeroInterior, Colonia, Delegacion, CorreoElectronico, Estatus_id, CatalogoActivo_id, MedicoEnfermera_id) values ('662-84-0822', 'Zora', 'Boag', 'Newcombe', 'Leroy', '2', null, 'Miller', '7th', 'znewcombe7@umich.edu', '1', '1', FLOOR(RAND(10)*10));
insert into Paciente (NSSA, Nombre, ApPaterno, ApMaterno, Calle, NumeroExterior, NumeroInterior, Colonia, Delegacion, CorreoElectronico, Estatus_id, CatalogoActivo_id, MedicoEnfermera_id) values ('664-99-0947', 'Ev', 'Doherty', 'Erasmus', 'Clarendon', '92', null, 'Shoshone', 'Dottie', 'eerasmus8@yelp.com', '1', '1', FLOOR(RAND(10)*10));
insert into Paciente (NSSA, Nombre, ApPaterno, ApMaterno, Calle, NumeroExterior, NumeroInterior, Colonia, Delegacion, CorreoElectronico, Estatus_id, CatalogoActivo_id, MedicoEnfermera_id) values ('406-47-4777', 'Ellerey', 'Herreran', 'Roast', 'Gale', '5', null, 'Holmberg', 'Fair Oaks', 'eroast9@washington.edu', '1', '1', FLOOR(RAND(10)*10));
insert into Paciente (NSSA, Nombre, ApPaterno, ApMaterno, Calle, NumeroExterior, NumeroInterior, Colonia, Delegacion, CorreoElectronico, Estatus_id, CatalogoActivo_id, MedicoEnfermera_id) values ('284-88-4113', 'Leonore', 'Selkirk', 'McMorran', 'Leroy', '70', null, 'Roth', 'Trailsway', 'lmcmorrana@oracle.com', '1', '1', FLOOR(RAND(10)*10));
insert into Paciente (NSSA, Nombre, ApPaterno, ApMaterno, Calle, NumeroExterior, NumeroInterior, Colonia, Delegacion, CorreoElectronico, Estatus_id, CatalogoActivo_id, MedicoEnfermera_id) values ('639-47-0008', 'Lavinia', 'Mailey', 'Wimpey', 'Loomis', '0', null, 'Manley', 'Talisman', 'lwimpeyb@spotify.com', '1', '1', FLOOR(RAND(10)*10));
insert into Paciente (NSSA, Nombre, ApPaterno, ApMaterno, Calle, NumeroExterior, NumeroInterior, Colonia, Delegacion, CorreoElectronico, Estatus_id, CatalogoActivo_id, MedicoEnfermera_id) values ('847-78-4340', 'Simonne', 'Ducastel', 'Davydzenko', 'Nobel', '26627', null, 'Lunder', 'Sugar', 'sdavydzenkoc@techcrunch.com', '1', '1', FLOOR(RAND(10)*10));
insert into Paciente (NSSA, Nombre, ApPaterno, ApMaterno, Calle, NumeroExterior, NumeroInterior, Colonia, Delegacion, CorreoElectronico, Estatus_id, CatalogoActivo_id, MedicoEnfermera_id) values ('570-02-6428', 'Phyllida', 'Bingle', 'Venn', 'Charing Cross', '7', null, 'Morning', 'Main', 'pvennd@bandcamp.com', '1', '1', FLOOR(RAND(10)*10));
insert into Paciente (NSSA, Nombre, ApPaterno, ApMaterno, Calle, NumeroExterior, NumeroInterior, Colonia, Delegacion, CorreoElectronico, Estatus_id, CatalogoActivo_id, MedicoEnfermera_id) values ('763-47-5079', 'Umberto', 'Sarsfield', 'McDermid', 'Corry', '221', null, 'Ilene', 'Utah', 'umcdermide@wsj.com', '1', '1', FLOOR(RAND(10)*10));
insert into Paciente (NSSA, Nombre, ApPaterno, ApMaterno, Calle, NumeroExterior, NumeroInterior, Colonia, Delegacion, CorreoElectronico, Estatus_id, CatalogoActivo_id, MedicoEnfermera_id) values ('660-87-9223', 'Ethelbert', 'Covill', 'Nurny', 'Swallow', '27531', null, 'Northport', 'Fieldstone', 'enurnyf@chicagotribune.com', '1', '1', FLOOR(RAND(10)*10));
insert into Paciente (NSSA, Nombre, ApPaterno, ApMaterno, Calle, NumeroExterior, NumeroInterior, Colonia, Delegacion, CorreoElectronico, Estatus_id, CatalogoActivo_id, MedicoEnfermera_id) values ('498-27-1196', 'Marylynne', 'Victoria', 'Goodsell', 'Westerfield', '79396', null, 'Homewood', 'Red Cloud', 'mgoodsellg@mapy.cz', '1', '1', FLOOR(RAND(10)*10));
insert into Paciente (NSSA, Nombre, ApPaterno, ApMaterno, Calle, NumeroExterior, NumeroInterior, Colonia, Delegacion, CorreoElectronico, Estatus_id, CatalogoActivo_id, MedicoEnfermera_id) values ('300-81-9810', 'Rab', 'Pinchback', 'Dale', 'Graedel', '72791', null, 'Bellgrove', 'Hoffman', 'rdaleh@prlog.org', '1', '1', FLOOR(RAND(10)*10));
insert into Paciente (NSSA, Nombre, ApPaterno, ApMaterno, Calle, NumeroExterior, NumeroInterior, Colonia, Delegacion, CorreoElectronico, Estatus_id, CatalogoActivo_id, MedicoEnfermera_id) values ('272-17-9483', 'Lynea', 'Vowels', 'Ogger', 'Twin Pines', '4', null, 'Saint Paul', 'Mesta', 'loggeri@ft.com', '1', '1', FLOOR(RAND(10)*10));
insert into Paciente (NSSA, Nombre, ApPaterno, ApMaterno, Calle, NumeroExterior, NumeroInterior, Colonia, Delegacion, CorreoElectronico, Estatus_id, CatalogoActivo_id, MedicoEnfermera_id) values ('679-95-6201', 'Andres', 'Vye', 'Tutchings', 'Harbort', '32', null, 'Dapin', 'Waubesa', 'atutchingsj@independent.co.uk', '1', '1', FLOOR(RAND(10)*10));
insert into Paciente (NSSA, Nombre, ApPaterno, ApMaterno, Calle, NumeroExterior, NumeroInterior, Colonia, Delegacion, CorreoElectronico, Estatus_id, CatalogoActivo_id, MedicoEnfermera_id) values ('849-88-9731', 'Nixie', 'Garrals', 'Elles', 'Spenser', '7', null, 'Sachtjen', 'Hoard', 'nellesk@homestead.com', '1', '1', FLOOR(RAND(10)*10));
insert into Paciente (NSSA, Nombre, ApPaterno, ApMaterno, Calle, NumeroExterior, NumeroInterior, Colonia, Delegacion, CorreoElectronico, Estatus_id, CatalogoActivo_id, MedicoEnfermera_id) values ('895-85-7034', 'Cherise', 'Ogilvy', 'Pulteneye', 'Bartelt', '23998', null, 'Forster', 'Redwing', 'cpulteneyel@github.com', '1', '1', FLOOR(RAND(10)*10));
insert into Paciente (NSSA, Nombre, ApPaterno, ApMaterno, Calle, NumeroExterior, NumeroInterior, Colonia, Delegacion, CorreoElectronico, Estatus_id, CatalogoActivo_id, MedicoEnfermera_id) values ('453-25-2380', 'Zelig', 'Scoon', 'Instrell', 'Alpine', '06', null, 'Redwing', 'Carioca', 'zinstrellm@sciencedaily.com', '1', '1', FLOOR(RAND(10)*10));
insert into Paciente (NSSA, Nombre, ApPaterno, ApMaterno, Calle, NumeroExterior, NumeroInterior, Colonia, Delegacion, CorreoElectronico, Estatus_id, CatalogoActivo_id, MedicoEnfermera_id) values ('392-51-7716', 'Kenneth', 'Wareing', 'Swayton', 'Westridge', '48', null, 'Utah', 'Grasskamp', 'kswaytonn@jalbum.net', '1', '1', FLOOR(RAND(10)*10));
insert into Paciente (NSSA, Nombre, ApPaterno, ApMaterno, Calle, NumeroExterior, NumeroInterior, Colonia, Delegacion, CorreoElectronico, Estatus_id, CatalogoActivo_id, MedicoEnfermera_id) values ('326-21-6390', 'Reagan', 'Elia', 'Fittall', 'Mccormick', '56', null, 'Spaight', 'Gateway', 'rfittallo@unblog.fr', '1', '1', FLOOR(RAND(10)*10));
insert into Paciente (NSSA, Nombre, ApPaterno, ApMaterno, Calle, NumeroExterior, NumeroInterior, Colonia, Delegacion, CorreoElectronico, Estatus_id, CatalogoActivo_id, MedicoEnfermera_id) values ('635-50-1004', 'Giana', 'Nemchinov', 'Huygen', 'Kim', '368', null, 'Milwaukee', 'Waubesa', 'ghuygenp@toplist.cz', '1', '1', FLOOR(RAND(10)*10));
insert into Paciente (NSSA, Nombre, ApPaterno, ApMaterno, Calle, NumeroExterior, NumeroInterior, Colonia, Delegacion, CorreoElectronico, Estatus_id, CatalogoActivo_id, MedicoEnfermera_id) values ('474-71-4229', 'Delly', 'McCaster', 'Chaudhry', 'Hazelcrest', '92', null, 'Magdeline', 'Carioca', 'dchaudhryq@jalbum.net', '1', '1', FLOOR(RAND(10)*10));
insert into Paciente (NSSA, Nombre, ApPaterno, ApMaterno, Calle, NumeroExterior, NumeroInterior, Colonia, Delegacion, CorreoElectronico, Estatus_id, CatalogoActivo_id, MedicoEnfermera_id) values ('196-45-0042', 'Nelia', 'Seiffert', 'Ashbey', 'Oriole', '652', null, 'Prentice', 'Garrison', 'nashbeyr@hostgator.com', '1', '1', FLOOR(RAND(10)*10));
insert into Paciente (NSSA, Nombre, ApPaterno, ApMaterno, Calle, NumeroExterior, NumeroInterior, Colonia, Delegacion, CorreoElectronico, Estatus_id, CatalogoActivo_id, MedicoEnfermera_id) values ('218-34-3693', 'Jannel', 'Lackie', 'Clissett', 'Summerview', '1290', null, 'Hallows', 'Hallows', 'jclissetts@redcross.org', '1', '1', FLOOR(RAND(10)*10));
insert into Paciente (NSSA, Nombre, ApPaterno, ApMaterno, Calle, NumeroExterior, NumeroInterior, Colonia, Delegacion, CorreoElectronico, Estatus_id, CatalogoActivo_id, MedicoEnfermera_id) values ('442-31-1454', 'Aluino', 'Hagard', 'Rickarsey', 'Nobel', '4', null, 'Paget', 'Summer Ridge', 'arickarseyt@pbs.org', '1', '1', FLOOR(RAND(10)*10));
insert into Paciente (NSSA, Nombre, ApPaterno, ApMaterno, Calle, NumeroExterior, NumeroInterior, Colonia, Delegacion, CorreoElectronico, Estatus_id, CatalogoActivo_id, MedicoEnfermera_id) values ('676-30-5137', 'Issy', 'Dell Casa', 'Hearfield', 'Mockingbird', '917', null, 'Cherokee', 'Warrior', 'ihearfieldu@dailymotion.com', '1', '1', FLOOR(RAND(10)*10));
insert into Paciente (NSSA, Nombre, ApPaterno, ApMaterno, Calle, NumeroExterior, NumeroInterior, Colonia, Delegacion, CorreoElectronico, Estatus_id, CatalogoActivo_id, MedicoEnfermera_id) values ('507-63-5273', 'Elset', 'Bealton', 'Lafflina', 'Bartillon', '44', null, 'Victoria', 'Shelley', 'elafflinav@angelfire.com', '1', '1', FLOOR(RAND(10)*10));
insert into Paciente (NSSA, Nombre, ApPaterno, ApMaterno, Calle, NumeroExterior, NumeroInterior, Colonia, Delegacion, CorreoElectronico, Estatus_id, CatalogoActivo_id, MedicoEnfermera_id) values ('573-88-0117', 'Drucie', 'Yuranovev', 'O'' Meara', 'Hovde', '8614', null, 'Coolidge', 'Columbus', 'domearaw@nyu.edu', '1', '1', FLOOR(RAND(10)*10));
insert into Paciente (NSSA, Nombre, ApPaterno, ApMaterno, Calle, NumeroExterior, NumeroInterior, Colonia, Delegacion, CorreoElectronico, Estatus_id, CatalogoActivo_id, MedicoEnfermera_id) values ('419-45-8155', 'Laraine', 'Poll', 'Hallagan', 'Superior', '03', null, 'Susan', 'Talisman', 'lhallaganx@fastcompany.com', '1', '1', FLOOR(RAND(10)*10));
insert into Paciente (NSSA, Nombre, ApPaterno, ApMaterno, Calle, NumeroExterior, NumeroInterior, Colonia, Delegacion, CorreoElectronico, Estatus_id, CatalogoActivo_id, MedicoEnfermera_id) values ('289-35-0087', 'Tamar', 'Shotboulte', 'Hendricks', 'Forest Dale', '8', null, 'Bultman', 'Daystar', 'thendricksy@mail.ru', '1', '1', FLOOR(RAND(10)*10));
insert into Paciente (NSSA, Nombre, ApPaterno, ApMaterno, Calle, NumeroExterior, NumeroInterior, Colonia, Delegacion, CorreoElectronico, Estatus_id, CatalogoActivo_id, MedicoEnfermera_id) values ('585-85-9346', 'Estell', 'McGirr', 'Bubbins', 'Thierer', '8', null, 'East', 'Debs', 'ebubbinsz@google.fr', '1', '1', FLOOR(RAND(10)*10));
insert into Paciente (NSSA, Nombre, ApPaterno, ApMaterno, Calle, NumeroExterior, NumeroInterior, Colonia, Delegacion, CorreoElectronico, Estatus_id, CatalogoActivo_id, MedicoEnfermera_id) values ('299-68-0423', 'Marleah', 'Dubois', 'Pattle', 'Sutteridge', '39', null, 'Melody', 'Harper', 'mpattle10@people.com.cn', '1', '1', FLOOR(RAND(10)*10));
insert into Paciente (NSSA, Nombre, ApPaterno, ApMaterno, Calle, NumeroExterior, NumeroInterior, Colonia, Delegacion, CorreoElectronico, Estatus_id, CatalogoActivo_id, MedicoEnfermera_id) values ('122-02-5011', 'Palm', 'Pauluzzi', 'Borth', 'West', '26', null, 'Sycamore', 'Messerschmidt', 'pborth11@mlb.com', '1', '1', FLOOR(RAND(10)*10));
insert into Paciente (NSSA, Nombre, ApPaterno, ApMaterno, Calle, NumeroExterior, NumeroInterior, Colonia, Delegacion, CorreoElectronico, Estatus_id, CatalogoActivo_id, MedicoEnfermera_id) values ('221-79-7147', 'Kris', 'Maycock', 'Vaud', 'Valley Edge', '14747', null, 'Autumn Leaf', 'Westport', 'kvaud12@cdc.gov', '1', '1', FLOOR(RAND(10)*10));
insert into Paciente (NSSA, Nombre, ApPaterno, ApMaterno, Calle, NumeroExterior, NumeroInterior, Colonia, Delegacion, CorreoElectronico, Estatus_id, CatalogoActivo_id, MedicoEnfermera_id) values ('400-35-3516', 'Bailey', 'Morrid', 'Seamark', 'Logan', '4', null, 'Carioca', 'Garrison', 'bseamark13@amazonaws.com', '1', '1', FLOOR(RAND(10)*10));
insert into Paciente (NSSA, Nombre, ApPaterno, ApMaterno, Calle, NumeroExterior, NumeroInterior, Colonia, Delegacion, CorreoElectronico, Estatus_id, CatalogoActivo_id, MedicoEnfermera_id) values ('304-30-5027', 'Mara', 'Cobbe', 'Newlove', 'Redwing', '11558', null, 'Buena Vista', 'Lakewood', 'mnewlove14@miitbeian.gov.cn', '1', '1', FLOOR(RAND(10)*10));
insert into Paciente (NSSA, Nombre, ApPaterno, ApMaterno, Calle, NumeroExterior, NumeroInterior, Colonia, Delegacion, CorreoElectronico, Estatus_id, CatalogoActivo_id, MedicoEnfermera_id) values ('466-29-9827', 'Mari', 'Slimon', 'Ronald', 'Clemons', '8', null, 'Springview', 'Sauthoff', 'mronald15@moonfruit.com', '1', '1', FLOOR(RAND(10)*10));
insert into Paciente (NSSA, Nombre, ApPaterno, ApMaterno, Calle, NumeroExterior, NumeroInterior, Colonia, Delegacion, CorreoElectronico, Estatus_id, CatalogoActivo_id, MedicoEnfermera_id) values ('561-35-1012', 'Elene', 'Maharry', 'Bracknell', 'Hermina', '75168', null, 'Darwin', 'Cody', 'ebracknell16@purevolume.com', '1', '1', FLOOR(RAND(10)*10));
insert into Paciente (NSSA, Nombre, ApPaterno, ApMaterno, Calle, NumeroExterior, NumeroInterior, Colonia, Delegacion, CorreoElectronico, Estatus_id, CatalogoActivo_id, MedicoEnfermera_id) values ('827-76-2379', 'Erwin', 'Kenson', 'Howsin', 'Duke', '04', null, 'Barnett', 'Hudson', 'ehowsin17@webmd.com', '1', '1', FLOOR(RAND(10)*10));
insert into Paciente (NSSA, Nombre, ApPaterno, ApMaterno, Calle, NumeroExterior, NumeroInterior, Colonia, Delegacion, CorreoElectronico, Estatus_id, CatalogoActivo_id, MedicoEnfermera_id) values ('445-82-4893', 'Wit', 'Jaeggi', 'Davitti', 'Fisk', '4', null, 'Carey', 'Thierer', 'wdavitti18@un.org', '1', '1', FLOOR(RAND(10)*10));
insert into Paciente (NSSA, Nombre, ApPaterno, ApMaterno, Calle, NumeroExterior, NumeroInterior, Colonia, Delegacion, CorreoElectronico, Estatus_id, CatalogoActivo_id, MedicoEnfermera_id) values ('110-12-8627', 'Helsa', 'Carty', 'Keam', 'Shoshone', '130', null, 'Fremont', 'Reindahl', 'hkeam19@chronoengine.com', '1', '1', FLOOR(RAND(10)*10));
insert into Paciente (NSSA, Nombre, ApPaterno, ApMaterno, Calle, NumeroExterior, NumeroInterior, Colonia, Delegacion, CorreoElectronico, Estatus_id, CatalogoActivo_id, MedicoEnfermera_id) values ('408-60-6079', 'Aksel', 'Ramsdell', 'Segges', 'Nelson', '355', null, 'Northland', 'Florence', 'asegges1a@google.co.uk', '1', '1', FLOOR(RAND(10)*10));
insert into Paciente (NSSA, Nombre, ApPaterno, ApMaterno, Calle, NumeroExterior, NumeroInterior, Colonia, Delegacion, CorreoElectronico, Estatus_id, CatalogoActivo_id, MedicoEnfermera_id) values ('883-02-5540', 'Caldwell', 'Moth', 'Medway', 'Butternut', '9729', null, 'Schmedeman', 'Brickson Park', 'cmedway1b@google.nl', '1', '1', FLOOR(RAND(10)*10));
insert into Paciente (NSSA, Nombre, ApPaterno, ApMaterno, Calle, NumeroExterior, NumeroInterior, Colonia, Delegacion, CorreoElectronico, Estatus_id, CatalogoActivo_id, MedicoEnfermera_id) values ('547-23-4380', 'Stefano', 'Darker', 'Hambrick', 'Kim', '648', null, 'Almo', 'Ramsey', 'shambrick1c@hatena.ne.jp', '1', '1', FLOOR(RAND(10)*10));
insert into Paciente (NSSA, Nombre, ApPaterno, ApMaterno, Calle, NumeroExterior, NumeroInterior, Colonia, Delegacion, CorreoElectronico, Estatus_id, CatalogoActivo_id, MedicoEnfermera_id) values ('779-09-6699', 'Templeton', 'Mabone', 'Lunbech', 'Dexter', '05', null, 'Gerald', 'Eastlawn', 'tlunbech1d@ucla.edu', '1', '1', FLOOR(RAND(10)*10));

insert into Telefono (Tipo, NumTelefono, Paciente_id) values ('C', '3173486187', 1);
insert into Telefono (Tipo, NumTelefono, Paciente_id) values ('C', '2044337712', 2);
insert into Telefono (Tipo, NumTelefono, Paciente_id) values ('C', '4350022949', 3);
insert into Telefono (Tipo, NumTelefono, Paciente_id) values ('C', '6224118817', 4);
insert into Telefono (Tipo, NumTelefono, Paciente_id) values ('C', '4981740075', 5);
insert into Telefono (Tipo, NumTelefono, Paciente_id) values ('C', '9370686255', 6);
insert into Telefono (Tipo, NumTelefono, Paciente_id) values ('C', '3500867188', 7);
insert into Telefono (Tipo, NumTelefono, Paciente_id) values ('C', '8086658643', 8);
insert into Telefono (Tipo, NumTelefono, Paciente_id) values ('C', '1941723157', 9);
insert into Telefono (Tipo, NumTelefono, Paciente_id) values ('C', '2241498674', 10);
insert into Telefono (Tipo, NumTelefono, Paciente_id) values ('C', '0473688723', 11);
insert into Telefono (Tipo, NumTelefono, Paciente_id) values ('C', '5939884081', 12);
insert into Telefono (Tipo, NumTelefono, Paciente_id) values ('C', '1576708729', 13);
insert into Telefono (Tipo, NumTelefono, Paciente_id) values ('C', '8552822965', 14);
insert into Telefono (Tipo, NumTelefono, Paciente_id) values ('C', '2403453576', 15);
insert into Telefono (Tipo, NumTelefono, Paciente_id) values ('C', '9878316619', 16);
insert into Telefono (Tipo, NumTelefono, Paciente_id) values ('C', '5316438532', 17);
insert into Telefono (Tipo, NumTelefono, Paciente_id) values ('C', '0552401060', 18);
insert into Telefono (Tipo, NumTelefono, Paciente_id) values ('C', '3804939678', 19);
insert into Telefono (Tipo, NumTelefono, Paciente_id) values ('C', '1478017444', 20);
insert into Telefono (Tipo, NumTelefono, Paciente_id) values ('C', '2960586342', 21);
insert into Telefono (Tipo, NumTelefono, Paciente_id) values ('C', '6888168065', 22);
insert into Telefono (Tipo, NumTelefono, Paciente_id) values ('C', '1380647263', 23);
insert into Telefono (Tipo, NumTelefono, Paciente_id) values ('C', '5016571697', 24);
insert into Telefono (Tipo, NumTelefono, Paciente_id) values ('C', '5007457979', 25);
insert into Telefono (Tipo, NumTelefono, Paciente_id) values ('C', '1923267281', 26);
insert into Telefono (Tipo, NumTelefono, Paciente_id) values ('C', '9124890455', 27);
insert into Telefono (Tipo, NumTelefono, Paciente_id) values ('C', '1619469172', 28);
insert into Telefono (Tipo, NumTelefono, Paciente_id) values ('C', '5390237223', 29);
insert into Telefono (Tipo, NumTelefono, Paciente_id) values ('C', '6788405340', 30);
insert into Telefono (Tipo, NumTelefono, Paciente_id) values ('C', '3257621481', 31);
insert into Telefono (Tipo, NumTelefono, Paciente_id) values ('C', '9295716701', 32);
insert into Telefono (Tipo, NumTelefono, Paciente_id) values ('C', '2211641961', 33);
insert into Telefono (Tipo, NumTelefono, Paciente_id) values ('C', '2578083407', 34);
insert into Telefono (Tipo, NumTelefono, Paciente_id) values ('C', '8862923808', 35);
insert into Telefono (Tipo, NumTelefono, Paciente_id) values ('C', '5155634335', 36);
insert into Telefono (Tipo, NumTelefono, Paciente_id) values ('C', '4478072959', 37);
insert into Telefono (Tipo, NumTelefono, Paciente_id) values ('C', '7448648028', 38);
insert into Telefono (Tipo, NumTelefono, Paciente_id) values ('C', '6084460980', 39);
insert into Telefono (Tipo, NumTelefono, Paciente_id) values ('C', '4243451037', 40);
insert into Telefono (Tipo, NumTelefono, Paciente_id) values ('C', '2879604818', 41);
insert into Telefono (Tipo, NumTelefono, Paciente_id) values ('C', '7602006815', 42);
insert into Telefono (Tipo, NumTelefono, Paciente_id) values ('C', '4887130974', 43);
insert into Telefono (Tipo, NumTelefono, Paciente_id) values ('C', '8083067209', 44);
insert into Telefono (Tipo, NumTelefono, Paciente_id) values ('C', '3015271166', 45);
insert into Telefono (Tipo, NumTelefono, Paciente_id) values ('C', '6885263913', 46);
insert into Telefono (Tipo, NumTelefono, Paciente_id) values ('C', '0158216906', 47);
insert into Telefono (Tipo, NumTelefono, Paciente_id) values ('C', '6893046706', 48);
insert into Telefono (Tipo, NumTelefono, Paciente_id) values ('C', '0605834897', 49);
insert into Telefono (Tipo, NumTelefono, Paciente_id) values ('C', '9660188275', 50);

