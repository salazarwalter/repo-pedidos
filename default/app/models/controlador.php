<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of rubro
 *
 * @author salazarwalter
 */
class Controlador extends ActiveRecord{
    
    public function initialize() {
        
    }
    
    public function hallar($control_id) {
        $control_id = (int)$control_id;
        if($control_id<=0){
            Flash::error("ID de Controlador Incorrecto");
            return false;
        }
        $sql =" 
            SELECT c.*, r.rol,m.modulo
            FROM controlador c INNER JOIN rol    r ON c.rol_id = r.id 
                               inner join modulo m ON c.modulo_id = m.id
            WHERE c.id = $control_id  
            
            ";
        return $this->find_by_sql($sql);
    }
    public function lista() {
        $sql =" 
            SELECT c.id, c.controlador, c.activo, r.rol,m.modulo
            FROM controlador c INNER JOIN rol    r ON c.rol_id = r.id 
                               inner join modulo m ON c.modulo_id = m.id
            ORDER BY r.rol, m.modulo, c.controlador 
            ";
        return $this->find_all_by_sql($sql);
    }
    public function agregar($vector) {
        $vector["controlador"]=trim($vector["controlador"]);
        $vector["rol_id"]=(int)trim($vector["rol_id"]);
        $vector["modulo_id"]=(int)trim($vector["modulo_id"]);
        
        if($vector["controlador"]==""){
            Flash::error("De ingresar el Nombre del Controlador");
            return FALSE;
        }
        if($vector["rol_id"]<=0 || $vector["modulo_id"]<=0){
            Flash::error("El Rol y el modulo son valores requeridos y positivo");
            return FALSE;
        }
        
        if($this->yaIngresadoAlta($vector)){
            Flash::error("YA Se ingresó este controlador para este Rol");
            return FALSE;
        }
        
        return $this->create($vector);
    }
    
    public function modificar($vector) {
        $vector["controlador"]=trim($vector["controlador"]);
        $vector["rol_id"]=(int)trim($vector["rol_id"]);
        $vector["modulo_id"]=(int)trim($vector["modulo_id"]);
        $vector["id"]=(int)trim($vector["id"]);
        
        if($vector["controlador"]==""){
            Flash::error("De ingresar el Nombre del Controlador");
            return FALSE;
        }
        if($vector["rol_id"]<=0){
            Flash::error("El Rol es un valor requerido y positivo");
            return FALSE;
        }
        if($vector["modulo_id"]<=0){
            Flash::error("El Módulo es un valor requerido y positivo");
            return FALSE;
        }
        if($vector["id"]<=0){
            Flash::error("El Controlador No reconocido");
            return FALSE;
        }
        
        if($this->yaIngresadoEdit($vector)){
            Flash::error("YA Se ingresó este controlador para este Rol");
            return FALSE;
        }
        
        return $this->update($vector);
    }
    public function desactivar($vector) {
        $vector["id"]=(int)trim($vector["id"]);
        
        if($vector["id"]<=0){
            Flash::error("El Controlador No reconocido");
            return FALSE;
        }
        $sql =" UPDATE controlador SET activo='N' WHERE id = ".$vector["id"];
        return $this->sql($sql);
    }
    public function activar($vector) {
        $vector["id"]=(int)trim($vector["id"]);
        
        if($vector["id"]<=0){
            Flash::error("El Controlador No reconocido");
            return FALSE;
        }
        $sql =" UPDATE controlador SET activo='S' WHERE id = ".$vector["id"];
        return $this->sql($sql);
    }
    
    
    public function yaIngresadoAlta($vector) {
        $vector["controlador"]= addslashes($vector["controlador"]);
        return $this->exists("controlador='".$vector["controlador"]."' AND rol_id=".$vector["rol_id"]." AND modulo_id=".$vector["modulo_id"]);
    }
    public function yaIngresadoEdit($vector) {
        $vector["controlador"]= addslashes($vector["controlador"]);
        return $this->exists("controlador='".$vector["controlador"]."' AND rol_id=".$vector["rol_id"]." AND modulo_id=".$vector["modulo_id"]." AND id<>".$vector["id"]);
    }
    /* +++++++++++++++++++++++++ AJAX    ++++++++++++++++++++++++++*/
    /* +++++++++++++++++++++++++ AJAX    ++++++++++++++++++++++++++*/
    /* +++++++++++++++++++++++++ AJAX    ++++++++++++++++++++++++++*/
    public function lista_x_rol($rol_id,$modulo_id) {
        return $this->find("modulo_id=$modulo_id AND rol_id = $rol_id AND activo='S' ");
    }
    
}
