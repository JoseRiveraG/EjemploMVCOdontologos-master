<?php
session_start();
require_once (__DIR__.'/../Modelo/Cita.php');

if(!empty($_GET['action'])){
    CitaController::main($_GET['action']);
}else{
    echo "No se encontro ninguna accion...";
}

class citaController
{

    static function main($action)
    {
        if ($action == "crear") {
            citaController::crear();
        } else if ($action == "editar") {
            citaController::editar();
        } else if ($action == "selectCita") {
            citaController::selectCita();
        } else if ($action == "adminTableCita") {
            citaController::adminTableCita();
        }
        /*else if ($action == "InactivarPaciente"){
            pacienteController::CambiarEstado("Inactivo");
        }else if ($action == "ActivarPaciente"){
            pacienteController::CambiarEstado("Activo");
        }
        /*
        else if ($action == "buscarID"){
            EspecialistaController::buscarID(1);
        }*/
    }

    static public function crear()
    {
        try {
            $arrayCita = array();
            $arrayCita['Fecha'] = $_POST['Fecha'];
            $arrayCita['Codigo'] = $_POST['Codigo'];
            $arrayCita['Estado'] = $_POST['Estado'];
            $arrayCita['Valor'] = $_POST['Valor'];
            $arrayCita['NConsultorio'] = $_POST['NConsultorio'];
            $arrayCita['Observaciones'] = $_POST['Observaciones'];
            $arrayCita['Motivo'] = $_POST['Motivo'];


            $Cita = new Cita ($arrayCita);
            $Cita->insertar();
            //header("Location: ../Vista/pages/registroCita.php?respuesta=correcto");
        } catch (Exception $e) {
            //header("Location: ../Vista/pages/registroCita.php?respuesta=error");
            var_dump($e);

        }

        static public function selectCita($isRequired = true, $id = "idCita", $nombre = "idCita", $class = "")
    {
        $arrCita = Cita::getAll(); /*  */
        $htmlSelect = "<select " . (($isRequired) ? "required" : "") . " id= '" . $id . "' name='" . $nombre . "' class='" . $class . "'>";
        $htmlSelect .= "<option >Seleccione la Cita </option>";
        if (count($arrCita) > 0) {
            foreach ($arrCita as $cita)
                $htmlSelect .= "<option value='" . $cita->getidCita() . "'>" . $cita->getFecha() . " " . $cita->getCodigo() . "</option>";
        }
        $htmlSelect .= "</select>";
        return $htmlSelect;
    }
     public function adminTableCita()
    {
        $arrCita = Cita::getAll(); /*  */
        $tmpPaciente = new Cita();
        $arrColumnas = [/*"idCita",*/
            "Fecha", "Codigo", "Estado", "Valor", "NConsultorio", "Observaciones", "Motivo", "idPaciente", "idEspecialista"];
        $htmlTable = "<thead>";
        $htmlTable .= "<tr>";
        foreach ($arrColumnas as $NameColumna) {
            $htmlTable .= "<th>" . $NameColumna . "</th>";
        }
        $htmlTable .= "<th>Acciones</th>";
        $htmlTable .= "</tr>";
        $htmlTable .= "</thead>";

        $htmlTable .= "<tbody>";
        foreach ($arrCita as $ObjCita) {
            $htmlTable .= "<tr>";
            //$htmlTable .= "<td>".$ObjCita->getIdCita()."</td>";
            $htmlTable .= "<td>" . $ObjCita->getFecha() . "</td>";
            $htmlTable .= "<td>" . $ObjCita->getCodigo() . "</td>";
            $htmlTable .= "<td>" . $ObjCita->getEstado() . "</td>";
            $htmlTable .= "<td>" . $ObjCita->getValor() . "</td>";
            $htmlTable .= "<td>" . $ObjCita->getNConsultorio() . "</td>";
            $htmlTable .= "<td>" . $ObjCita->getObservaciones() . "</td>";
            $htmlTable .= "<td>" . $ObjCita->getMotivo() . "</td>";
            //$htmlTable .= "<td>".$ObjCita->getIdPaciente()."</td>";
            //$htmlTable .= "<td>".$ObjCita->getIdEspecialista()."</td>";


            $htmlTable .= "</tr>";
        }
        $htmlTable .= "</tbody>";


        return $htmlTable;
    }

    static public function editar()
    {
        try {
            $arrayCita = array();
            $arrayCita['Fecha'] = $_POST['Fecha'];
            $arrayCita['Codigo'] = $_POST['Codigo'];
            $arrayCita['Estado'] = $_POST['Estado'];
            $arrayCita['Valor'] = $_POST['Valor'];
            $arrayCita['NConsultorio'] = $_POST['NConsultorio'];
            $arrayCita['Observaciones'] = $_POST['Observaciones'];
            $arrayCita['Motivo'] = $_POST['Motivo'];
            $Cita = new Cita ($arrayCita);
            $Cita->editar();
            unset($_SESSION["IdCita"]);
            header("Location: ../Vista/pages/actualizarCita.php?respuesta=correcto&Cita=" . $arrayCita['idCita']);

        } catch (Exception $e) {

            $txtMensaje = $e->getMessage();
            header("Location: ../Vista/pages/actualizarCita.php?respuesta=error&Mensaje=" . $txtMensaje);
        }
    }
?>
    /*
    static public function buscarID ($id){
        try {
            return Odontologos::buscarForId($id);
        } catch (Exception $e) {
            header("Location: ../buscarOdontologos.php?respuesta=error");
        }
    }

    public function buscarAll (){
        try {
            return Odontologos::getAll();
        } catch (Exception $e) {
            header("Location: ../buscarOdontologos.php?respuesta=error");
        }
    }

    public function buscar ($campo, $parametro){
        try {
            return Odontologos::getAll();
        } catch (Exception $e) {
            header("Location: ../buscarOdontologos.php?respuesta=error");
        }
    }*/



