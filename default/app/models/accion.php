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
class Accion extends ActiveRecord{
    
    public static $AJAX=array("N"=>"No Ajax","S"=>"Ajax");
    public function initialize() {
        
    }
    
    public function hallar($accion_id) {
        $accion_id = (int)$accion_id;
        if($accion_id<=0){
            Flash::error("ID de Controlador Incorrecto");
            return false;
        }
        $sql =" 
            SELECT a.*,c.controlador,c.rol_id,r.rol,m.modulo,
                    c.rol_id,c.modulo_id
            FROM accion a INNER JOIN controlador c ON a.controlador_id = c.id
                          INNER JOIN rol r         ON c.rol_id         = r.id
                          INNER JOIN modulo m      ON c.modulo_id      = m.id
            WHERE a.id = $accion_id 
            ";
        return $this->find_by_sql($sql);
    }
    public function lista() {
        $sql =" 
            SELECT a.*,c.controlador,c.rol_id,r.rol,m.modulo 
            FROM accion a INNER JOIN controlador c ON a.controlador_id = c.id
                          INNER JOIN rol r         ON c.rol_id         = r.id
                          INNER JOIN modulo m      ON c.modulo_id      = m.id
            ORDER BY r.rol, m.modulo, c.controlador , a.accion
            ";
        return $this->find_all_by_sql($sql);
    }
    public function agregar($vector) {
        $vector["accion"]=trim($vector["accion"]);
        $vector["controlador_id"]=(int)trim($vector["controlador_id"]);
        
        if($vector["accion"]==""){
            Flash::error("De ingresar el Nombre de la Acción");
            return FALSE;
        }
        if($vector["controlador_id"]<=0){
            Flash::error("El Controlador es un valor requerido y positivo");
            return FALSE;
        }
        
        if($this->yaIngresadoAlta($vector)){
            Flash::error("YA Se ingresó esta Acción para este Controlador");
            return FALSE;
        }
        
        return $this->create($vector);
    }
    
    public function modificar($vector) {
        $vector["accion"]=trim($vector["accion"]);
        $vector["controlador_id"]=(int)trim($vector["controlador_id"]);
        $vector["id"]=(int)trim($vector["id"]);
        
        if($vector["controlador_id"]==""){
            Flash::error("De ingresar el Nombre de la Acción");
            return FALSE;
        }
        if($vector["controlador_id"]<=0){
            Flash::error("El Controlador es un valor requerido y positivo");
            return FALSE;
        }
        if($vector["id"]<=0){
            Flash::error("Acción No reconocida");
            return FALSE;
        }
        
        if($this->yaIngresadoEdit($vector)){
            Flash::error("YA Se ingresó esta Acción para este Controlador");
            return FALSE;
        }
        
        return $this->update($vector);
    }
    public function desactivar($vector) {
        $vector["id"]=(int)trim($vector["id"]);
        
        if($vector["id"]<=0){
            Flash::error("Acción No reconocida");
            return FALSE;
        }
        $sql =" UPDATE accion SET activo='N' WHERE id = ".$vector["id"];
        return $this->sql($sql);
    }
    public function activar($vector) {
        $vector["id"]=(int)trim($vector["id"]);
        
        if($vector["id"]<=0){
            Flash::error("Acción No reconocida");
            return FALSE;
        }
        $sql =" UPDATE accion SET activo='S' WHERE id = ".$vector["id"];
        return $this->sql($sql);
    }
    
    
    public function yaIngresadoAlta($vector) {
        $vector["accion"]= addslashes($vector["accion"]);
        return $this->exists("accion='".$vector["accion"]."' AND controlador_id=".$vector["controlador_id"]);
    }
    public function yaIngresadoEdit($vector) {
        $vector["accion"]= addslashes($vector["accion"]);
        return $this->exists("accion='".$vector["accion"]."' AND controlador_id=".$vector["controlador_id"]." AND id<>".$vector["id"]);
    }
}
