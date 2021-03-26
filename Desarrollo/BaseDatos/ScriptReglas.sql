#TABLA PACIENTE*****************************
#cada que se actualiza un paciente, se guardan los cambios en la tabla 
#PacienteHistorico
DELIMITER |
CREATE OR REPLACE TRIGGER ActualizaPacienteTg 
BEFORE UPDATE ON Paciente
FOR EACH ROW
BEGIN
  INSERT INTO PacienteHistorico 
  (NSSA,FechaRegistro, Nombre, ApPaterno, ApMaterno, Calle, NumeroExterior, 
    NumeroInterior, Colonia, Delegacion, CorreoElectronico, Estatus_id, 
    CatalogoActivo_id, MedicoEnfermera_id,Paciente_id,Observaciones) 
  VALUES
  (OLD.NSSA,OLD.FechaRegistro,OLD.Nombre,OLD.ApPaterno,OLD.ApMaterno, 
    OLD.Calle,OLD.NumeroExterior,OLD.NumeroInterior,OLD.Colonia, 
    OLD.Delegacion,OLD.CorreoElectronico,OLD.Estatus_id, 
    OLD.CatalogoActivo_id,OLD.MedicoEnfermera_id,OLD.Paciente_id,
    OLD.Observaciones); 
  SET NEW.FechaRegistro=CURRENT_TIMESTAMP;
END;
|
#no se pueden borrar datos
DELIMITER |
CREATE OR REPLACE TRIGGER DeletePacienteTg
BEFORE DELETE ON Paciente 
FOR EACH ROW
BEGIN
  SIGNAL SQLSTATE '45001'
    SET MESSAGE_TEXT = 'NO PUEDES BORRAR DATOS';
END;
|

#TABLA DESACTIVOOTRO********************************************************************************
#Solo se puede agregar a la tabla DesactivoOtro si el estatus del paciente
#respecto a si es activo o no es OTRO
DELIMITER |
CREATE OR REPLACE TRIGGER DesactivoOtroInsercionTg
BEFORE INSERT ON DesactivoOtro
FOR EACH ROW
BEGIN
  DECLARE CantPaciente int;
  DECLARE idOtro int;
  Select CatalogoActivo_id
    INTO idOtro
    from CatalogoActivo 
    where Descripcion='OTRO';
  Select count(*)
    INTO CantPaciente
    from Paciente
    where Paciente_id=NEW.Paciente_id
    and CatalogoActivo_id=idOtro;
  IF CantPaciente <1 THEN
    SIGNAL SQLSTATE '45000'
      SET MESSAGE_TEXT = 'No se puede agregar este campo por el estado del paciente';
  ELSE
    SET NEW.FechaRegistro=CURRENT_TIMESTAMP;
  END IF;
END;
|

#TABLA CONSULTADETECCION****************************************************************************
#No se pueden borrar datos, solo se "actualizaran"
DELIMITER |
CREATE OR REPLACE TRIGGER ConsultaDeteccionDeleteTG
BEFORE DELETE ON ConsultaDeteccion 
FOR EACH ROW
BEGIN
  SIGNAL SQLSTATE '45001'
    SET MESSAGE_TEXT = 'NO PUEDES BORRAR DATOS';
END;
|

DELIMITER |
CREATE OR REPLACE TRIGGER ConsultaDeteccionUpdateTG
BEFORE UPDATE ON ConsultaDeteccion 
FOR EACH ROW
BEGIN
  SIGNAL SQLSTATE '45002'
    SET MESSAGE_TEXT = 'NO PUEDES CAMBIAR DATOS';
END;
|

DELIMITER |
CREATE OR REPLACE TRIGGER ConsultaDeteccionInsertTG
BEFORE INSERT ON ConsultaDeteccion 
FOR EACH ROW
BEGIN
  DECLARE CantPaciente int;
  DECLARE Activo int;
  
  SELECT CatalogoActivo_id
  INTO Activo
  FROM Paciente 
  WHERE Paciente_id=NEW.Paciente_id;

  IF Activo!=1 THEN
    SIGNAL SQLSTATE '45005'
    SET MESSAGE_TEXT = 'PACIENTE INACTIVO';
  END IF;
  #se cuenta cuantas entradas hay para un paciente
  SELECT COUNT(*)
  INTO CantPaciente
  FROM ConsultaDeteccion
  WHERE Paciente_id=NEW.Paciente_id;
  #si es mayor a 0, significa que ya tiene historial el paciente
  IF CantPaciente>0 THEN
    #se encuentra el id de la ultima entrada para dicho paciente
    SELECT ConsultaDeteccion_id
    INTO CantPaciente
    FROM ConsultaDeteccion
    WHERE Paciente_id=NEW.Paciente_id
    AND Fecha=(
      #tomando en cuenta que la fecha debe ser la mayor
      SELECT MAX(Fecha) 
      FROM ConsultaDeteccion 
      WHERE Paciente_id=CantPaciente);
    #se asigna el id de esa entrada a la entrada nueva
    SET NEW.ConsultaDeteccionAnterior_id=CantPaciente;
  END IF;
  #pase lo que pase, se asegura que la fecha sea la fecha en la que se hace
  #el insert
  SET NEW.Fecha=CURRENT_TIMESTAMP;
END;
|

#TABLA DIAGNOSTICO*********************************************************************************
#No se pueden borrar datos, solo se "actualizaran"
DELIMITER |
CREATE OR REPLACE TRIGGER DiagnosticoDeleteTG
BEFORE DELETE ON Diagnostico 
FOR EACH ROW
BEGIN
  SIGNAL SQLSTATE '45001'
    SET MESSAGE_TEXT = 'NO PUEDES BORRAR DATOS';
END;
|

DELIMITER |
CREATE OR REPLACE TRIGGER DiagnosticoUpdateTG
BEFORE UPDATE ON Diagnostico 
FOR EACH ROW
BEGIN
  SIGNAL SQLSTATE '45002'
    SET MESSAGE_TEXT = 'NO PUEDES CAMBIAR DATOS';
END;
|

DELIMITER |
CREATE OR REPLACE TRIGGER DiagnosticoInsertTG
BEFORE INSERT ON Diagnostico 
FOR EACH ROW
BEGIN
  DECLARE CantPaciente int;
  DECLARE EstadoPaciente int;
  DECLARE Activo int;
  
  SELECT CatalogoActivo_id
  INTO Activo
  FROM Paciente 
  WHERE Paciente_id=NEW.Paciente_id;

  IF Activo!=1 THEN
    SIGNAL SQLSTATE '45005'
    SET MESSAGE_TEXT = 'PACIENTE INACTIVO';
  END IF;
  #se cuenta cuantas entradas hay para un paciente
  SELECT COUNT(*)
  INTO CantPaciente
  FROM Diagnostico
  WHERE Paciente_id=NEW.Paciente_id;
  #si es mayor a 0, significa que ya tiene historial el paciente
  IF CantPaciente>0 THEN
    #se encuentra el id de la ultima entrada para dicho paciente
    SELECT Diagnostico_id
    INTO CantPaciente
    FROM Diagnostico
    WHERE Paciente_id=NEW.Paciente_id
    AND FechaDiagnostico=(
      #tomando en cuenta que la fecha debe ser la mayor
      SELECT MAX(FechaDiagnostico) 
      FROM Diagnostico 
      WHERE Paciente_id=CantPaciente);
    #se asigna el id de esa entrada a la entrada nueva
    SET NEW.DiagnosticoAnterior_id=CantPaciente;
  END IF;

  #Para cambiar el estatus del paciente
  SELECT Estatus_id
  INTO EstadoPaciente
  FROM Paciente
  WHERE Paciente_id= NEW.Paciente_id;

  IF EstadoPaciente != 3 THEN
    UPDATE Paciente SET Estatus_id=3 WHERE Paciente_id=NEW.Paciente_id;
  END IF;
  #pase lo que pase, se asegura que la fecha sea la fecha en la que se hace
  #el insert
  SET NEW.FechaDiagnostico=CURRENT_TIMESTAMP;
END;
|

#TABLA RESULTADOLABORATORIO*************************************************************************
#No se pueden borrar datos, solo se "actualizaran"
DELIMITER |
CREATE OR REPLACE TRIGGER ResultadoLaboratorioDeleteTG
BEFORE DELETE ON ResultadoLaboratorio 
FOR EACH ROW
BEGIN
  SIGNAL SQLSTATE '45001'
    SET MESSAGE_TEXT = 'NO PUEDES BORRAR DATOS';
END;
|

DELIMITER |
CREATE OR REPLACE TRIGGER ResultadoLaboratorioUpdateTG
BEFORE UPDATE ON ResultadoLaboratorio 
FOR EACH ROW
BEGIN
  SIGNAL SQLSTATE '45002'
    SET MESSAGE_TEXT = 'NO PUEDES CAMBIAR DATOS';
END;
|

DELIMITER |
CREATE OR REPLACE TRIGGER ResultadoLaboratorioInsertTG
BEFORE INSERT ON ResultadoLaboratorio 
FOR EACH ROW
BEGIN
  DECLARE CantPaciente int;
  DECLARE EstadoPaciente int;
  DECLARE Activo int;

  SELECT CatalogoActivo_id
  INTO Activo
  FROM Paciente 
  WHERE Paciente_id=NEW.Paciente_id;

  IF Activo!=1 THEN
    SIGNAL SQLSTATE '45005'
    SET MESSAGE_TEXT = 'PACIENTE INACTIVO';
  END IF;
  #se cuenta cuantas entradas hay para un paciente
  SELECT COUNT(*)
  INTO CantPaciente
  FROM ResultadoLaboratorio
  WHERE Paciente_id=NEW.Paciente_id;
  #si es mayor a 0, significa que ya tiene historial el paciente
  IF CantPaciente>0 THEN
    #se encuentra el id de la ultima entrada para dicho paciente
    SELECT ResultadoLaboratorio_id
    INTO CantPaciente
    FROM ResultadoLaboratorio
    WHERE Paciente_id=NEW.Paciente_id
    AND Fecha=(
      #tomando en cuenta que la fecha debe ser la mayor
      SELECT MAX(Fecha) 
      FROM ResultadoLaboratorio 
      WHERE Paciente_id=CantPaciente);
    #se asigna el id de esa entrada a la entrada nueva
    SET NEW.ResultadoLaboratorioAnterior_id=CantPaciente;
  END IF;

  #Para cambiar el estatus del paciente
  SELECT Estatus_id
  INTO EstadoPaciente
  FROM Paciente
  WHERE Paciente_id= NEW.Paciente_id;

  IF EstadoPaciente = 1 THEN
    UPDATE Paciente SET Estatus_id=2 WHERE Paciente_id=NEW.Paciente_id;
  END IF;

  #pase lo que pase, se asegura que la fecha sea la fecha en la que se hace
  #el insert
  SET NEW.Fecha=CURRENT_TIMESTAMP;
END;
|
#TABLA PACIENTEHISTORICO**********************
#No se pueden borrar datos, solo se "actualizaran"
DELIMITER |
CREATE OR REPLACE TRIGGER PacienteHistoricoDeleteTG
BEFORE DELETE ON PacienteHistorico 
FOR EACH ROW
BEGIN
  SIGNAL SQLSTATE '45001'
    SET MESSAGE_TEXT = 'NO PUEDES BORRAR DATOS';
END;
|

DELIMITER |
CREATE OR REPLACE TRIGGER PacienteHistoricoUpdateTG
BEFORE UPDATE ON PacienteHistorico 
FOR EACH ROW
BEGIN
  SIGNAL SQLSTATE '45002'
    SET MESSAGE_TEXT = 'NO PUEDES CAMBIAR DATOS';
END;
|

#TABLA CITA****************************************************************************************
DELIMITER |
CREATE OR REPLACE TRIGGER CitaDeleteTG
BEFORE DELETE ON Cita 
FOR EACH ROW
BEGIN
  SIGNAL SQLSTATE '45001'
    SET MESSAGE_TEXT = 'NO PUEDES BORRAR DATOS';
END;
|

DELIMITER |
CREATE OR REPLACE TRIGGER CitaUpdateTG
BEFORE UPDATE ON Cita 
FOR EACH ROW
BEGIN
  DECLARE EstadoPaciente int;
  DECLARE Activo int;
  
  SELECT CatalogoActivo_id
  INTO Activo
  FROM Paciente 
  WHERE Paciente_id=NEW.Paciente_id;

  IF Activo!=1 THEN
    SIGNAL SQLSTATE '45005'
    SET MESSAGE_TEXT = 'PACIENTE INACTIVO';
  END IF;
  IF FLOOR(OLD.Fecha/1000000) >= FLOOR(CURRENT_TIMESTAMP/1000000) THEN
    IF FLOOR(NEW.Fecha/1000000) > FLOOR(CURRENT_TIMESTAMP/1000000) THEN

      SELECT Estatus_id 
      INTO EstadoPaciente
      FROM Paciente
      WHERE Paciente_id=OLD.Paciente_id;

      IF EstadoPaciente = 1 THEN
        SET NEW.Tipo = 'L';
      ELSE
        SET NEW.Tipo = 'D';
      END IF;
      SET NEW.FechaRegistro=CURRENT_TIMESTAMP;
    ELSE
      SIGNAL SQLSTATE '45004'
      SET MESSAGE_TEXT = 'FECHA INVALIDA';
    END IF;
  ELSE
    SIGNAL SQLSTATE '45002'
    SET MESSAGE_TEXT = 'CITA INACTIVA, NO LA PUEDES CAMBIAR';
  END IF;
END;
|

DELIMITER |
CREATE OR REPLACE TRIGGER CitaInsertTG
BEFORE INSERT ON Cita 
FOR EACH ROW
BEGIN
  DECLARE Activo int;
  DECLARE EstadoPaciente int;
  DECLARE CitasActivas int;
  DECLARE Cita_ant_id int;
  DECLARE tipov char;

  SELECT CatalogoActivo_id
  INTO Activo
  FROM Paciente
  WHERE Paciente_id=NEW.Paciente_id;
  #validando que el paciente no este inactivo
  IF Activo!=1 THEN
    SIGNAL SQLSTATE '45005'
    SET MESSAGE_TEXT = 'PACIENTE INACTIVO';
  END IF;
  #se revisa cuantas citas activas tiene el paciente
  #si tiene al menos una cita aun activa, no se puede
  #agendar otra cita
  SELECt COUNT(*)
  INTO CitasActivas
  FROM Cita
  WHERE Paciente_id=NEW.Paciente_id
  AND FLOOR(Fecha/1000000) >= FLOOR(CURRENT_TIMESTAMP/1000000);

  IF CitasActivas>0 THEN
    SIGNAL SQLSTATE '45003'
    SET MESSAGE_TEXT = 'PACIENTE CON CITA ACTIVA';
  ELSE
    IF FLOOR(NEW.Fecha/1000000) > FLOOR(CURRENT_TIMESTAMP/1000000) THEN

      SELECT Estatus_id 
      INTO EstadoPaciente
      FROM Paciente
      WHERE Paciente_id=NEW.Paciente_id;

      IF EstadoPaciente = 1 THEN
        SET NEW.Tipo = 'L';
        SET tipov='L';
      ELSE
        SET NEW.Tipo = 'D';
        SET tipov:='D';
      END IF;
    ELSE
      SIGNAL SQLSTATE '45004'
      SET MESSAGE_TEXT = 'FECHA INVALIDA';
    END IF;
  END IF;
#se checa si hay citas anteriores a las cuales darles el seguimiento a la cita
  SELECt COUNT(*)
  INTO CitasActivas
  FROM Cita
  WHERE Paciente_id=NEW.Paciente_id
  AND Tipo= tipov;

  IF CitasActivas>0 THEN
    SELECT MAX(Cita_id)
    INTO Cita_ant_id
    FROM Cita
    WHERE Paciente_id=NEW.Paciente_id
    AND Fecha=(
      SELECT MAX(Fecha)
      FROM Cita
      WHERE Paciente_id=NEW.Paciente_id
      );
    SET NEW.CitaAnterior_id = Cita_ant_id;
  END IF;

  SET NEW.FechaRegistro=CURRENT_TIMESTAMP;
END
|