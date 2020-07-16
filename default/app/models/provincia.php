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
class Provincia extends ActiveRecord{
    
    public function initialize() {
        
    }
    
    public function lista() {
        return $this->find();
    }
    public function agregar($vector) {
        $vector["prov"]=trim($vector["prov"]);
        
        if($vector["prov"]==""){
            Flash::error("De ingresar el Nombre de la Provincia");
            return FALSE;
        }
        
        if($this->yaIngresadoAlta($vector)){
            Flash::error("YA Se ingresó esta Provincia");
            return FALSE;
        }
        
        return $this->create($vector);
    }
    
    public function modificar($vector) {
        $vector["prov"]=trim($vector["prov"]);
        $vector["id"]=(int)trim($vector["id"]);
        
        if($vector["prov"]==""){
            Flash::error("De ingresar el Nombre de la Provincia");
            return FALSE;
        }
        if($vector["id"]<=0){
            Flash::error("Provincia No reconocido");
            return FALSE;
        }
        
        if($this->yaIngresadoEdit($vector)){
            Flash::error("YA Se ingresó esta Provincia");
            return FALSE;
        }
        
        return $this->update($vector);
    }
    
    public function desactivar($vector) {
        $vector["id"]=(int)trim($vector["id"]);
        
        if($vector["id"]<=0){
            Flash::error("Provincia No reconocida");
            return FALSE;
        }
        $sql =" UPDATE provincia SET activo='N' WHERE id = ".$vector["id"];
        return $this->sql($sql);
    }
    public function activar($vector) {
        $vector["id"]=(int)trim($vector["id"]);
        
        if($vector["id"]<=0){
            Flash::error("Provincia No reconocido");
            return FALSE;
        }
        $sql =" UPDATE provincia SET activo='S' WHERE id = ".$vector["id"];
        return $this->sql($sql);
    }
    
    
    public function yaIngresadoAlta($vector) {
        $vector["prov"]= addslashes($vector["prov"]);
        return $this->exists("prov='".$vector["prov"]."' ");
    }
    public function yaIngresadoEdit($vector) {
        $vector["prov"]= addslashes($vector["prov"]);
        return $this->exists("prov='".$vector["prov"]."' AND id<>".$vector["id"]);
    }
    
    public function hallar($prov_id) {
        $prov_id = (int)$prov_id;
        if($prov_id<=0){
            Flash::error("Provincia No identificada");
            return FALSE;
        }
        return $this->find_by_id($prov_id);
    }
    
    public function combo() {
        return $this->find("activo='S'");
    }
}
