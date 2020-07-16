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
class Unidad extends ActiveRecord{
    
    public function initialize() {
//        $this->validates_uniqueness_of("neg_nom", array("message"=>"Nombre del Negocio Ya Ingresado"));
        $this->validates_presence_of("unidad", array("message"=>"Ingrese la Unidad"));
        $this->validates_length_of("unidad", 25,4,array( 
                                  "too_short"=>"La Unidad debe tener al menos 4 caracteres",
                                  "too_long"=>"La Unidad debe tener máximo 25 caracteres"));
        $this->validates_length_of("abreviatura", 6,0,array( 
                                  "too_short"=>"La Abreviatura debe tener al menos 0 caracteres",
                                  "too_long"=>"La Abreviatura debe tener máximo 6 caracteres"));
        
    }
    public function lista() {
        return $this->find("negocio_id = ".Auth::get("negocio_id"));
    }
    public function agregar($vector) {
        $vector["unidad"]=trim($vector["unidad"]);
        $vector["abreviatura"]=trim($vector["abreviatura"]);
        $vector["negocio_id"]= Auth::get("negocio_id");
        
        
        if($this->yaIngresadoAlta($vector)){
            Flash::error("YA Se ingresó esta Unidad");
            return FALSE;
        }
        
        return $this->create($vector);
    }
    
    public function modificar($vector) {
        $vector["unidad"]      = trim($vector["unidad"]);
        $vector["abreviatura"] = trim($vector["abreviatura"]);
        $vector["negocio_id"]  = Auth::get("negocio_id");
        $vector["id"]          = (int)trim($vector["id"]);
        
        if($vector["id"]<=0){
            Flash::error("Unidad No reconocida");
            return FALSE;
        }
        
        if($this->yaIngresadoEdit($vector)){
            Flash::error("YA Se ingresó esta Unidad");
            return FALSE;
        }
        
        return $this->update($vector);
    }
    
    public function desactivar($vector) {
        $vector["id"]=(int)trim($vector["id"]);
        
        if($vector["id"]<=0){
            Flash::error("Unidad No reconocida");
            return FALSE;
        }
        $sql =" UPDATE unidad SET activo='N' WHERE id = ".$vector["id"];
        return $this->sql($sql);
    }
    public function activar($vector) {
        $vector["id"]=(int)trim($vector["id"]);
        
        if($vector["id"]<=0){
            Flash::error("Unidad No reconocida");
            return FALSE;
        }
        $sql =" UPDATE unidad SET activo='S' WHERE id = ".$vector["id"];
        return $this->sql($sql);
    }
    
    
    public function yaIngresadoAlta($vector) {
        $vector["unidad"]= addslashes($vector["unidad"]);
        return $this->exists("unidad='".$vector["unidad"]."' AND negocio_id=".Auth::get("negocio_id"));
    }
    public function yaIngresadoEdit($vector) {
        $vector["unidad"]= addslashes($vector["unidad"]);
        return $this->exists("unidad='".$vector["unidad"]."' AND negocio_id=".Auth::get("negocio_id")." AND id<>".$vector["id"]);
    }
    
    public function hallar($unidad_id) {
        $unidad_id = (int)$unidad_id;
        if($unidad_id<=0){
            Flash::error("Provincia No identificada");
            return FALSE;
        }
        return $this->find_first("id=$unidad_id AND negocio_id=".Auth::get("negocio_id"));
    }
    
    public function combo() {
        return $this->find("activo='S' AND negocio_id=".Auth::get("negocio_id"));
    }
    
}
