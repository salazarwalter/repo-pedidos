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
class Marca extends ActiveRecord{
        public function initialize() {
//        $this->validates_uniqueness_of("neg_nom", array("message"=>"Nombre del Negocio Ya Ingresado"));
        $this->validates_presence_of("marca", array("message"=>"Ingrese la Marca"));
        $this->validates_length_of("marca", 30,4,array( 
                                  "too_short"=>"La Marca debe tener al menos 4 caracteres",
                                  "too_long"=>"La Marca debe tener máximo 30 caracteres"));
        
    }
    public function lista() {
        return $this->find("negocio_id = ".Auth::get("negocio_id"));
    }
    public function agregar($vector) {
        $vector["marca"]=trim($vector["marca"]);
        $vector["negocio_id"]= Auth::get("negocio_id");
        
        
        if($this->yaIngresadoAlta($vector)){
            Flash::error("YA Se ingresó esta Marca");
            return FALSE;
        }
        
        return $this->create($vector);
    }
    
    public function modificar($vector) {
        $vector["marca"]      = trim($vector["marca"]);
        $vector["negocio_id"]  = Auth::get("negocio_id");
        $vector["id"]          = (int)trim($vector["id"]);
        
        if($vector["id"]<=0){
            Flash::error("Marca No reconocida");
            return FALSE;
        }
        
        if($this->yaIngresadoEdit($vector)){
            Flash::error("YA Se ingresó esta Marca");
            return FALSE;
        }
        
        return $this->update($vector);
    }
    
    public function desactivar($vector) {
        $vector["id"]=(int)trim($vector["id"]);
        
        if($vector["id"]<=0){
            Flash::error("Marca No reconocida");
            return FALSE;
        }
        $sql =" UPDATE marca SET activo='N' WHERE id = ".$vector["id"];
        return $this->sql($sql);
    }
    public function activar($vector) {
        $vector["id"]=(int)trim($vector["id"]);
        
        if($vector["id"]<=0){
            Flash::error("Marca No reconocida");
            return FALSE;
        }
        $sql =" UPDATE marca SET activo='S' WHERE id = ".$vector["id"];
        return $this->sql($sql);
    }
    
    
    public function yaIngresadoAlta($vector) {
        $vector["marca"]= addslashes($vector["marca"]);
        return $this->exists("marca='".$vector["marca"]."' AND negocio_id=".Auth::get("negocio_id"));
    }
    public function yaIngresadoEdit($vector) {
        $vector["marca"]= addslashes($vector["marca"]);
        return $this->exists("marca='".$vector["marca"]."' AND negocio_id=".Auth::get("negocio_id")." AND id<>".$vector["id"]);
    }
    
    public function hallar($marca_id) {
        $marca_id = (int)$marca_id;
        if($marca_id<=0){
            Flash::error("Provincia No identificada");
            return FALSE;
        }
        return $this->find_first("id=$marca_id AND negocio_id=".Auth::get("negocio_id"));
    }
    
    public function combo() {
        return $this->find("activo='S' AND negocio_id=".Auth::get("negocio_id"));
    }
    
}
