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
class Modulo extends ActiveRecord{
    
    public function initialize() {
        
    }
    
    public function lista() {
        return $this->find();
    }
    public function agregar($vector) {
        $vector["modulo"]=trim($vector["modulo"]);
        
        if($vector["modulo"]==""){
            Flash::error("De ingresar el Nombre del Módulo");
            return FALSE;
        }
        
        if($this->yaIngresadoAlta($vector)){
            Flash::error("YA Se ingresó esta Módulo");
            return FALSE;
        }
        
        return $this->create($vector);
    }
    
    public function modificar($vector) {
        $vector["modulo"]=trim($vector["modulo"]);
        $vector["id"]=(int)trim($vector["id"]);
        
        if($vector["modulo"]==""){
            Flash::error("De ingresar el Nombre del Módulo");
            return FALSE;
        }
        if($vector["id"]<=0){
            Flash::error("Módulo No reconocido");
            return FALSE;
        }
        
        if($this->yaIngresadoEdit($vector)){
            Flash::error("YA Se ingresó este Módulo");
            return FALSE;
        }
        
        return $this->update($vector);
    }
    
    public function desactivar($vector) {
        $vector["id"]=(int)trim($vector["id"]);
        
        if($vector["id"]<=0){
            Flash::error("Módulo No reconocido");
            return FALSE;
        }
        $sql =" UPDATE modulo SET activo='N' WHERE id = ".$vector["id"];
        return $this->sql($sql);
    }
    
    public function activar($vector) {
        $vector["id"]=(int)trim($vector["id"]);
        
        if($vector["id"]<=0){
            Flash::error("Módulo No reconocido");
            return FALSE;
        }
        $sql =" UPDATE modulo SET activo='S' WHERE id = ".$vector["id"];
        return $this->sql($sql);
    }
    
    
    public function yaIngresadoAlta($vector) {
        $vector["modulo"]= addslashes($vector["modulo"]);
        return $this->exists("modulo='".$vector["modulo"]."' ");
    }
    public function yaIngresadoEdit($vector) {
        $vector["modulo"]= addslashes($vector["modulo"]);
        return $this->exists("modulo='".$vector["modulo"]."' AND id<>".$vector["id"]);
    }
    
    public function hallar($modulo_id) {
        $modulo_id = (int)$modulo_id;
        if($modulo_id<=0){
            Flash::error("Modulo No identificada");
            return FALSE;
        }
        return $this->find_by_id($modulo_id);
    }
    
    public function combo() {
        return $this->find("activo='S'");
    }
}
