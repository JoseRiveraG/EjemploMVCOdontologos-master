<?php
session_start();
require_once (__DIR__.'/../Modelo/Especialista.php');

if(!empty($_GET['action'])){
    EspecialistaController::main($_GET['action']);
}else{
    echo "No se encontro ninguna accion...";
}

class EspecialistaController{

    static function main($action){
        if ($action == "crear"){
            EspecialistaController::crear();
        }else if ($action == "editar"){
            EspecialistaController::editar();
        }else if ($action == "selectEspecialista"){
            EspecialistaController::selectEspecialista();
        }else if ($action == "adminTableEspecialista"){
            EspecialistaController::adminTableEspecialista();
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

    static public function crear (){
        try {
            $arrayEspecialista = array();
            $arrayEspecialista['Tipo'] = $_POST['Tipo'];
            $arrayEspecialista['Nombres'] = $_POST['Nombres'];
            $arrayEspecialista['Apellidos'] = $_POST['Apellidos'];
            $arrayEspecialista['Direccion'] = $_POST['Direccion'];
            $arrayEspecialista['TipoDocumento'] = $_POST['TipoDocumento'];
            $arrayEspecialista['Documento'] = $_POST['Documento'];
            $arrayEspecialista['Email'] = $_POST['Email'];
            $arrayEspecialista['Genero'] = $_POST['Genero'];
            $arrayEspecialista['Telefono'] = $_POST['Telefono'];
            $arrayEspecialista['Estado'] = "Activo";

            $Especialista = new Especialista ($arrayEspecialista);
            $Especialista->insertar();
           header("Location: ../Vista/pages/registroEspecialista.php?respuesta=correcto");
        } catch (Exception $e) {
           header("Location: ../Vista/pages/registroEspecialista.php?respuesta=error");
           var_dump($e);
        }
    }

    static public function selectEspecialista ($isRequired=true, $id="idEspecialista", $nombre="idEspecialista", $class=""){
        $arrEspecialista = Especialista::getAll(); /*  */
        $htmlSelect = "<select ".(($isRequired) ? "required" : "")." id= '".$id."' name='".$nombre."' class='".$class."'>";
        $htmlSelect .= "<option >Seleccione el Especialista </option>";
        if(count($arrEspecialista) > 0){
            foreach ($arrEspecialista as $especialista)
                $htmlSelect .= "<option value='".$especialista->getidEspecialista()."'>".$especialista->getNombres()." ".$especialista->getApellidos()."</option>";
        }
        $htmlSelect .= "</select>";
        return $htmlSelect;
    }
    static public function adminTableEspecilista (){
        $arrEspecialista =Especialista ::getAll(); /*  */
        $tmpPaciente = new Especialista();
        $arrColumnas = [/*"idEspecialista",*/"Tipo","Nombre","Apellido","Documento"/*"TipoDocumento",*/,"Email","Direccion","Genero","Telefono","Estado"];
        $htmlTable = "<thead>";
        $htmlTable .= "<tr>";
        foreach ($arrColumnas as $NameColumna){
            $htmlTable .= "<th>".$NameColumna."</th>";
        }
        $htmlTable .= "<th>Acciones</th>";
        $htmlTable .= "</tr>";
        $htmlTable .= "</thead>";

        $htmlTable .= "<tbody>";
        foreach ($arrEspecialista as $ObjEspecialista){
            $htmlTable .= "<tr>";
            //$htmlTable .= "<td>".$ObjEspecialista->getIdEspecialista()."</td>";
            $htmlTable .= "<td>".$ObjEspecialista->getTipo()."</td>";
            $htmlTable .= "<td>".$ObjEspecialista->getNombres()."</td>";
            $htmlTable .= "<td>".$ObjEspecialista->getApellidos()."</td>";
            //$htmlTable .= "<td>".$ObjEspecialista->getTipoDocumento()."</td>";
            $htmlTable .= "<td>".$ObjEspecialista->getDocumento()."</td>";
            $htmlTable .= "<td>".$ObjEspecialista->getDireccion()."</td>";
            $htmlTable .= "<td>".$ObjEspecialista->getEmail()."</td>";
            $htmlTable .= "<td>".$ObjEspecialista->getGenero()."</td>";
            $htmlTable .= "<td>".$ObjEspecialista->getTelefono()."</td>";
            $htmlTable .= "<td>".$ObjEspecialista->getEstado()."</td>";



            $htmlTable .= "</tr>";
        }
        $htmlTable .= "</tbody>";




        return $htmlTable;
    }

    static public function editar (){
        try {
            $arrayEspecialista = array();
            $arrayEspecialista['Tipo'] = $_POST['Tipo'];
            $arrayEspecialista['Nombres'] = $_POST['Nombres'];
            $arrayEspecialista['Apellidos'] = $_POST['Apellidos'];
            $arrayEspecialista['Direccion'] = $_POST['Direccion'];
            $arrayEspecialista['TipoDocumento'] = $_POST['TipoDocumento'];
            $arrayEspecialista['Documento'] = $_POST['Documento'];
            $arrayEspecialista['Email'] = $_POST['Email'];
            $arrayEspecialista['Genero'] = $_POST['Genero'];
            $arrayEspecialista['Telefono'] = $_POST['Telefono'];
            $Especialista = new Especialista ($arrayEspecialista);
            $Especialista->editar();
            unset($_SESSION["IdEspecialista"]);
            header("Location: ../Vista/pages/actualizarEspecilista.php?respuesta=correcto&Especialista=".$arrayEspecialista['idEspecilista']);

        } catch (Exception $e) {

            $txtMensaje = $e->getMessage();
            header("Location: ../Vista/pages/actualizarEspecialista.php?respuesta=error&Mensaje=".$txtMensaje);
        }
    }

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

}
?>