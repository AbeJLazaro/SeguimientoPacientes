CREATE TABLE Estatus(
  Estatus_id int(11) AUTO_INCREMENT PRIMARY KEY, 
  NombreEstatus varchar(45) NOT NULL,
  Descripcion varchar(200) NOT NULL
);

CREATE TABLE CatalogoActivo(
  CatalogoActivo_id int(11) AUTO_INCREMENT PRIMARY KEY,
  Descripcion varchar(45) NOT NULL
);

CREATE TABLE Categoria(
  Categoria_id int(11) AUTO_INCREMENT PRIMARY KEY,
  Descripcion varchar(45) NOT NULL
);

CREATE TABLE Subcategoria(
  Subcategoria_id int(11) AUTO_INCREMENT PRIMARY KEY,
  Descripcion varchar(45) NOT NULL,
  Categoria_id int(11) NOT NULL,
  CONSTRAINT FOREIGN KEY(Categoria_id) 
  REFERENCES Categoria(Categoria_id)
);

CREATE TABLE MedicoEnfermera(
  MedicoEnfermera_id int(11) AUTO_INCREMENT PRIMARY KEY,
  Matricula Numeric(11,0) NOT NULL UNIQUE,
  Nombre varchar(44) NOT NULL,
  ApPaterno varchar(44) NOT NULL,
  ApMaterno varchar(44),
  Contrasena varchar(200) NOT NULL,
  TipoUsuario char(1) NOT NULL CHECK (TipoUsuario IN ('A','U')),
  Categoria_id int(11) NOT NULL,
  Subcategoria_id int(11),
  CONSTRAINT FOREIGN KEY (Categoria_id) 
  REFERENCES Categoria(Categoria_id),
  CONSTRAINT FOREIGN KEY (Subcategoria_id) 
  REFERENCES Subcategoria(Subcategoria_id)
);

CREATE TABLE Paciente(
  Paciente_id int(11) AUTO_INCREMENT PRIMARY KEY,
  NSSA varchar(20) NOT NULL UNIQUE,
  Nombre varchar(100) NOT NULL,
  ApPaterno varchar(100) NOT NULL,
  ApMaterno varchar(100),
  Calle varchar(44) NOT NULL,
  NumeroExterior Numeric(10,0) NOT NULL,
  NumeroInterior Numeric(10,0),
  Colonia varchar(44) NOT NULL,
  Delegacion varchar(44) NOT NULL,
  CorreoElectronico varchar(230),
  Observaciones varchar(1000),
  Estatus_id int(11) default 1 NOT NULL,
  CatalogoActivo_id int(11) default 1 NOT NULL,
  FechaRegistro datetime default CURRENT_TIMESTAMP NOT NULL,
  MedicoEnfermera_id int(11) NOT NULL,
  CONSTRAINT FOREIGN KEY (Estatus_id)
  REFERENCES Estatus(Estatus_id),
  CONSTRAINT FOREIGN KEY (CatalogoActivo_id)
  REFERENCES CatalogoActivo(CatalogoActivo_id),
  CONSTRAINT FOREIGN KEY (MedicoEnfermera_id)
  REFERENCES MedicoEnfermera(MedicoEnfermera_id)
);

CREATE TABLE Telefono(
  Telefono_id int(11) AUTO_INCREMENT PRIMARY KEY,
  Tipo char(1) NOT NULL CHECK (Tipo IN ('F','C')),
  NumTelefono Numeric(11,0) NOT NULL,
  Paciente_id int(11) NOT NULL,
  CONSTRAINT FOREIGN KEY (Paciente_id)
  REFERENCES Paciente(Paciente_id),
  CONSTRAINT UNIQUE(NumTelefono,Paciente_id)
);

CREATE TABLE DesactivoOtro(
  Paciente_id int(11),
  Descripcion varchar(200) NOT NULL,
  FechaRegistro datetime default CURRENT_TIMESTAMP NOT NULL,
  CONSTRAINT FOREIGN KEY (Paciente_id)
  REFERENCES Paciente(Paciente_id),
  CONSTRAINT PRIMARY KEY (Paciente_id,FechaRegistro)
);

CREATE TABLE PacienteHistorico(
  Paciente_id int(11) NOT NULL,
  NSSA varchar(20) NOT NULL,
  Nombre varchar(100) NOT NULL,
  ApPaterno varchar(100) NOT NULL,
  ApMaterno varchar(100),
  Calle varchar(44) NOT NULL,
  NumeroExterior Numeric(10,0) NOT NULL,
  NumeroInterior Numeric(10,0),
  Colonia varchar(44) NOT NULL,
  Delegacion varchar(44) NOT NULL,
  CorreoElectronico varchar(230),
  Observaciones varchar(1000),
  Estatus_id int(11) NOT NULL,
  CatalogoActivo_id int(11) NOT NULL,
  FechaRegistro datetime default CURRENT_TIMESTAMP NOT NULL,
  MedicoEnfermera_id int(11) NOT NULL,
  CONSTRAINT FOREIGN KEY (Estatus_id)
  REFERENCES Estatus(Estatus_id),
  CONSTRAINT FOREIGN KEY (CatalogoActivo_id)
  REFERENCES CatalogoActivo(CatalogoActivo_id),
  CONSTRAINT FOREIGN KEY (MedicoEnfermera_id)
  REFERENCES MedicoEnfermera(MedicoEnfermera_id),
  CONSTRAINT PRIMARY KEY (Paciente_id,FechaRegistro),
  CONSTRAINT FOREIGN KEY (Paciente_id)
  REFERENCES Paciente(Paciente_id)
);

CREATE TABLE ConsultaDeteccion(
  ConsultaDeteccion_id int(11) AUTO_INCREMENT PRIMARY KEY,
  Fecha datetime default CURRENT_TIMESTAMP NOT NULL,
  Resultado Numeric(5,2) NOT NULL,
  Paciente_id int(11) NOT NULL,
  MedicoEnfermera_id int(11) NOT NULL,
  Tipo varchar(10) NOT NULL CHECK (Tipo in ('Ayuno','No ayuno')),
  ConsultaDeteccionAnterior_id int(11),
  CONSTRAINT FOREIGN KEY (Paciente_id)
  REFERENCES Paciente(Paciente_id),
  CONSTRAINT FOREIGN KEY (MedicoEnfermera_id)
  REFERENCES MedicoEnfermera(MedicoEnfermera_id),
  CONSTRAINT FOREIGN KEY (ConsultaDeteccionAnterior_id)
  REFERENCES ConsultaDeteccion(ConsultaDeteccion_id)
);

CREATE TABLE CatalogoDiagnostico(
  CatalogoDiagnostico_id int(11) AUTO_INCREMENT PRIMARY KEY,
  Descripcion varchar(45) NOT NULL
);

CREATE TABLE Diagnostico(
  Diagnostico_id int(11) AUTO_INCREMENT PRIMARY KEY,
  FechaDiagnostico datetime default CURRENT_TIMESTAMP NOT NULL,
  Observaciones varchar(500),
  Paciente_id int(11) NOT NULL,
  CatalogoDiagnostico_id int(11) NOT NULL,
  MedicoEnfermera_id int(11) NOT NULL,
  DiagnosticoAnterior_id int(11),
  CONSTRAINT FOREIGN KEY (Paciente_id)
  REFERENCES Paciente(Paciente_id),
  CONSTRAINT FOREIGN KEY (CatalogoDiagnostico_id)
  REFERENCES CatalogoDiagnostico(CatalogoDiagnostico_id),
  CONSTRAINT FOREIGN KEY (MedicoEnfermera_id)
  REFERENCES MedicoEnfermera(MedicoEnfermera_id),
  CONSTRAINT FOREIGN KEY (DiagnosticoAnterior_id)
  REFERENCES Diagnostico(Diagnostico_id)
);

CREATE TABLE ResultadoLaboratorio(
  ResultadoLaboratorio_id int(11) AUTO_INCREMENT PRIMARY KEY,
  Resultado Numeric(5,2) NOT NULL,
  MedicoEnfermera_id int(11) NOT NULL,
  Paciente_id int(11) NOT NULL,
  ResultadoLaboratorioAnterior_id int(11),
  Fecha datetime default CURRENT_TIMESTAMP NOT NULL,
  CONSTRAINT FOREIGN KEY (MedicoEnfermera_id)
  REFERENCES MedicoEnfermera(MedicoEnfermera_id),
  CONSTRAINT FOREIGN KEY (Paciente_id)
  REFERENCES Paciente(Paciente_id),
  CONSTRAINT FOREIGN KEY (ResultadoLaboratorioAnterior_id)
  REFERENCES ResultadoLaboratorio(ResultadoLaboratorio_id)
);

CREATE TABLE Cita(
  Cita_id int(11) AUTO_INCREMENT PRIMARY KEY,
  Tipo char(1) default 'L' NOT NULL CHECK (Tipo IN ('D','L')),
  Fecha datetime NOT NULL,
  Observaciones varchar(500),
  Paciente_id int(11) NOT NULL,
  MedicoEnfermera_id int(11) NOT NULL,
  CitaAnterior_id int(11),
  FechaRegistro datetime default CURRENT_TIMESTAMP NOT NULL,
  CONSTRAINT FOREIGN KEY (Paciente_id)
  REFERENCES Paciente(Paciente_id),
  CONSTRAINT FOREIGN KEY (MedicoEnfermera_id)
  REFERENCES MedicoEnfermera(MedicoEnfermera_id),
  CONSTRAINT FOREIGN KEY (CitaAnterior_id)
  REFERENCES Cita(Cita_id)
);

CREATE TABLE Color(
  Tipo char(1) NOT NULL,
  Color varchar(10) NOT NULL,
  allDay varchar(10) NOT NULL
);