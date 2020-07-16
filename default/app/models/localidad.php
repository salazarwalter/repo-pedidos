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
class Localidad extends ActiveRecord{
    
    public function initialize() {
        
    }
    
    public function hallar($loc_id) {
        $loc_id = (int)$loc_id;
        if($loc_id<=0){
            Flash::error("ID de Controlador Incorrecto");
            return false;
        }
        $sql =" 
            SELECT l.*,p.prov 
            FROM localidad l INNER JOIN provincia p ON l.provincia_id = p.id
            WHERE l.id = $loc_id 
            ";
        return $this->find_by_sql($sql);
    }
    
    public function lista() {
        $sql =" 
            SELECT l.*,p.prov 
            FROM localidad l INNER JOIN provincia p ON l.provincia_id = p.id
            ORDER BY p.prov, l.loc 
            ";
        return $this->find_all_by_sql($sql);
    }
    
    public function agregar($vector) {
        $vector["loc"]=trim($vector["loc"]);
        $vector["provincia_id"]=(int)trim($vector["provincia_id"]);
        
        if($vector["loc"]==""){
            Flash::error("De ingresar el Nombre de la Localidad");
            return FALSE;
        }
        if($vector["provincia_id"]<=0){
            Flash::error("La Provincia es un valor requerido y positivo");
            return FALSE;
        }
        
        if($this->yaIngresadoAlta($vector)){
            Flash::error("YA Se ingresó este Localidad para este Provincia");
            return FALSE;
        }
        
        return $this->create($vector);
    }
    
    public function modificar($vector) {
        $vector["loc"]=trim($vector["loc"]);
        $vector["provincia_id"]=(int)trim($vector["provincia_id"]);
        $vector["id"]=(int)trim($vector["id"]);
        
        if($vector["loc"]==""){
            Flash::error("De ingresar el Nombre de la Localidad");
            return FALSE;
        }
        if($vector["provincia_id"]<=0){
            Flash::error("La Provincia es un valor requerido y positivo");
            return FALSE;
        }
        if($vector["id"]<=0){
            Flash::error("Localidad No reconocida");
            return FALSE;
        }
        
        if($this->yaIngresadoEdit($vector)){
            Flash::error("YA Se ingresó esta Localidad para est Provincia");
            return FALSE;
        }
        
        return $this->update($vector);
    }
    
    public function desactivar($vector) {
        $vector["id"]=(int)trim($vector["id"]);
        
        if($vector["id"]<=0){
            Flash::error("Localidad No reconocida");
            return FALSE;
        }
        $sql =" UPDATE localidad SET activo='N' WHERE id = ".$vector["id"];
        return $this->sql($sql);
    }
    
    public function activar($vector) {
        $vector["id"]=(int)trim($vector["id"]);
        
        if($vector["id"]<=0){
            Flash::error("Localidad No reconocida");
            return FALSE;
        }
        $sql =" UPDATE localidad SET activo='S' WHERE id = ".$vector["id"];
        return $this->sql($sql);
    }
    
    
    public function yaIngresadoAlta($vector) {
        $vector["loc"]= addslashes($vector["loc"]);
        return $this->exists("loc='".$vector["loc"]."' AND provincia_id=".$vector["provincia_id"]);
    }
    public function yaIngresadoEdit($vector) {
        $vector["loc"]= addslashes($vector["loc"]);
        return $this->exists("loc='".$vector["loc"]."' AND provincia_id=".$vector["provincia_id"]." AND id<>".$vector["id"]);
    }
    /* +++++++++++++++++++++++++ AJAX    ++++++++++++++++++++++++++*/
    /* +++++++++++++++++++++++++ AJAX    ++++++++++++++++++++++++++*/
    /* +++++++++++++++++++++++++ AJAX    ++++++++++++++++++++++++++*/
    public function lista_x_provincia($prov_id) {
        return $this->find("provincia_id = $prov_id AND activo='S' ");
    }
    
}
