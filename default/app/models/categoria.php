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
class Categoria extends ActiveRecord{
        public function initialize() {
//        $this->validates_uniqueness_of("neg_nom", array("message"=>"Nombre del Negocio Ya Ingresado"));
        $this->validates_presence_of("categoria", array("message"=>"Ingrese la Categoria"));
        $this->validates_length_of("categoria", 30,4,array( 
                                  "too_short"=>"La Categoria debe tener al menos 4 caracteres",
                                  "too_long"=>"La Categoria debe tener máximo 30 caracteres"));
        
    }
    public function lista() {
        return $this->find("negocio_id = ".Auth::get("negocio_id"));
    }
    public function agregar($vector) {
        $vector["categoria"]=trim($vector["categoria"]);
        $vector["negocio_id"]= Auth::get("negocio_id");
        
        
        if($this->yaIngresadoAlta($vector)){
            Flash::error("YA Se ingresó esta Categoria");
            return FALSE;
        }
        
        return $this->create($vector);
    }
    
    public function modificar($vector) {
        $vector["categoria"]      = trim($vector["categoria"]);
        $vector["negocio_id"]  = Auth::get("negocio_id");
        $vector["id"]          = (int)trim($vector["id"]);
        
        if($vector["id"]<=0){
            Flash::error("Categoria No reconocida");
            return FALSE;
        }
        
        if($this->yaIngresadoEdit($vector)){
            Flash::error("YA Se ingresó esta Categoria");
            return FALSE;
        }
        
        return $this->update($vector);
    }
    
    public function desactivar($vector) {
        $vector["id"]=(int)trim($vector["id"]);
        
        if($vector["id"]<=0){
            Flash::error("Categoria No reconocida");
            return FALSE;
        }
        $sql =" UPDATE categoria SET activo='N' WHERE id = ".$vector["id"];
        return $this->sql($sql);
    }
    public function activar($vector) {
        $vector["id"]=(int)trim($vector["id"]);
        
        if($vector["id"]<=0){
            Flash::error("Categoria No reconocida");
            return FALSE;
        }
        $sql =" UPDATE categoria SET activo='S' WHERE id = ".$vector["id"];
        return $this->sql($sql);
    }
    
    
    public function yaIngresadoAlta($vector) {
        $vector["categoria"]= addslashes($vector["categoria"]);
        return $this->exists("categoria='".$vector["categoria"]."' AND negocio_id=".Auth::get("negocio_id"));
    }
    public function yaIngresadoEdit($vector) {
        $vector["categoria"]= addslashes($vector["categoria"]);
        return $this->exists("categoria='".$vector["categoria"]."' AND negocio_id=".Auth::get("negocio_id")." AND id<>".$vector["id"]);
    }
    
    public function hallar($categoria_id) {
        $categoria_id = (int)$categoria_id;
        if($categoria_id<=0){
            Flash::error("Provincia No identificada");
            return FALSE;
        }
        return $this->find_first("id=$categoria_id AND negocio_id=".Auth::get("negocio_id"));
    }
    
    public function combo() {
        return $this->find("activo='S' AND negocio_id=".Auth::get("negocio_id"));
    }
    
}
