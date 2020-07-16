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
class Rubro extends ActiveRecord{
    
    public static $NO_IMAGE_NAME="no-image.svg";
    public static $NO_IMAGE_FOLDER=PUBLIC_PATH."img/";
    
    
    public function initialize() {
        
    }
    
    public function lista() {
        return $this->find();
    }
    public function listaRubros() {
        $sql = " 
                    SELECT rubro.*, count(rubro.id)as cant 
                    FROM rubro INNER JOIN negocio ON negocio.rubro_id  = rubro.id
                    WHERE rubro.activo='S'
                    GROUP BY rubro.id
                ";
        return $this->find_all_by_sql($sql);
    }
    public function agregar($vector) {
        $vector["rubro"]=trim($vector["rubro"]);
        
        if($vector["rubro"]==""){
            Flash::error("De ingresar el Nombre del Rubro");
            return FALSE;
        }
        
        if($this->yaIngresadoAlta($vector)){
            Flash::error("YA Se ingresó esta Rubro");
            return FALSE;
        }
        
        return $this->create($vector);
    }
    
    public function modificar($vector) {
        $vector["rubro"]=trim($vector["rubro"]);
        $vector["id"]=(int)trim($vector["id"]);
        
        if($vector["rubro"]==""){
            Flash::error("De ingresar el Nombre de la Rubro");
            return FALSE;
        }
        if($vector["id"]<=0){
            Flash::error("Rubro No reconocido");
            return FALSE;
        }
        
        if($this->yaIngresadoEdit($vector)){
            Flash::error("YA Se ingresó esta Rubro");
            return FALSE;
        }
        
        return $this->update($vector);
    }
    
    public function desactivar($vector) {
        $vector["id"]=(int)trim($vector["id"]);
        
        if($vector["id"]<=0){
            Flash::error("Rubro No reconocido");
            return FALSE;
        }
        $sql =" UPDATE rubro SET activo='N' WHERE id = ".$vector["id"];
        return $this->sql($sql);
    }
    public function activar($vector) {
        $vector["id"]=(int)trim($vector["id"]);
        
        if($vector["id"]<=0){
            Flash::error("Rubro No reconocido");
            return FALSE;
        }
        $sql =" UPDATE rubro SET activo='S' WHERE id = ".$vector["id"];
        return $this->sql($sql);
    }
    
    
    public function yaIngresadoAlta($vector) {
        $vector["rubro"]= addslashes($vector["rubro"]);
        return $this->exists("rubro='".$vector["rubro"]."' ");
    }
    public function yaIngresadoEdit($vector) {
        $vector["rubro"]= addslashes($vector["rubro"]);
        return $this->exists("rubro='".$vector["rubro"]."' AND id<>".$vector["id"]);
    }
    
    public function hallar($rubro_id) {
        $rubro_id = (int)$rubro_id;
        if($rubro_id<=0){
            Flash::error("Rubro No identificado");
            return FALSE;
        }
        $obj= $this->find_by_id($rubro_id);
        if($obj){
             if(!$obj->icono)
                $obj->iconox = Rubro::$NO_IMAGE_FOLDER.Rubro::$NO_IMAGE_NAME;
             else
                $obj->iconox = PUBLIC_PATH."files/upload/rubros/".$obj->icono;
        }
        return $obj;
    }
    
    public function combo() {
        return $this->find("activo='S'");
    }

    public function icono($vector) {
        if(!isset($vector["id"])){
            Flash::error("Rubro no identificado");
            return FALSE;
        }
        $mod= $this->hallar($vector["id"]);
        if(!$mod){
            Flash::error("Obj Rubro No Hallado");
            return FALSE;
        }
        $this->begin();
        if($_FILES["imagen"]["name"]==$mod->icono){
            $this->rollback();
            Flash::warning('Subir la misma imagen...!!!');
            return FALSE;
        }
        $archivo = Upload::factory('imagen');//llamamos a la libreria y le pasamos el nombre del campo file del formulario        
        $archivo->setExtensions(array('jpg','jpeg', 'png', 'gif','svg'));//le asignamos las extensiones a permitir
        $archivo->addPath("/rubros");
//        die($archivo->getPath());
        if (!$archivo->isUploaded()) {
            $this->rollback();
            Flash::warning('Precarga, No se ha Podido Subir la imagen...!!!');
            return FALSE;
        }
                
        $name=$archivo->saveRandom();
        if (!$name) {
            $this->rollback();
            Flash::warning('Obtension Nombre. No se ha Podido Subir la imagen...!!!');
            return FALSE;
        }
        $this->icono    = $name;
        $this->id       = $vector["id"];
        $this->rubro    = $mod->rubro;
        if(!$this->save()){
            $this->rollback();
            Flash::warning('No se ha Podido Subir la imagen...!!!');
            return FALSE;
        }
//        $vector["rubro"]=$mod->rubro;
//        if(!$this->save($vector)){
//            $this->rollback();
//            return FALSE;
//        }
        
        $this->commit();
        return TRUE;
        
    }
    
}
