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
class Usuario extends ActiveRecord{
    
    public function initialize() {
        $this->validates_presence_of("usu", array("message"=>"Ingrese el Nombre de  Usuario"));
        $this->validates_uniqueness_of("usu", array("message"=>"Usuario Ya Ingresado"));
        $this->validates_length_of("usu", 40,6,array( 
                                  "too_short"=>"El Usuario debe tener al menos 6 caracteres",
                                  "too_long"=>"El Usuario debe tener maximo 40 caracteres"));
        $this->validates_presence_of("cla", array("message"=>"Ingrese la Contraseña"));
//        $this->validates_uniqueness_of("usu", array("message"=>"Usuario Ya Ingresado"));
        $this->validates_length_of("usu", 60,6,array( 
                                  "too_short"=>"La Contraseña debe tener al menos 6 caracteres",
                                  "too_long"=>"La Contraseña debe tener maximo 0 caracteres"));
        
    }
    public function tieneAcceso($controller_name, $action_name) {
        $controller_name= addslashes(trim($controller_name));
        $action_name= addslashes(trim($action_name));
        
        $sql =" 
                SELECT modulo.*
                FROM controlador  INNER JOIN accion   ON accion.controlador_id = controlador.id
                                  INNER JOIN modulo   ON controlador.modulo_id = modulo.id
                                  INNER JOIN contrata ON contrata.modulo_id    = modulo.id
                WHERE controlador.rol_id =".Auth::get("rol_id")."  
                AND contrata.negocio_id=".Auth::get("negocio_id")." 
                AND controlador.controlador='$controller_name' 
                AND accion.accion='$action_name' 
                AND controlador.activo='S' 
                AND accion.activo='S' 
            ";
//        die($sql);
        $modulos= $this->find_all_by_sql($sql);
        
        return $modulos;
    }
    
    public function before_save() {
        $this->usu= base64_encode($this->usu);
        $this->cla= base64_encode($this->cla);
    }

    function cambiarFoto(){
        $archivo = Upload::factory('imagen', 'image'); 
        $archivo->setExtensions(array('jpg', 'png', 'gif','jpeg'));//le asignamos las extensiones a permitir
        $archivo->addPath("/perfiles");
            if ($archivo->isUploaded()) {
                if ($name=$archivo->saveRandom()) {
                    $usu=new Usuario();
                    $usu->id             = Auth::get("id");
                    $usu->cla            = base64_decode(Auth::get("cla"));
                    $usu->usu            = base64_decode(Auth::get("usu"));
                    $usu->negocio_id     = Auth::get("negocio_id");
                    $usu->rol_id         = Auth::get("rol_id");
                    $usu->foto           = $name;
                    
                    return $usu->save();
                }
            }else{
                    Flash::warning('No se ha Podido Subir la imagen...!!!');
            }
        return FALSE;
    }
    
    function cambiarClave($vector){
        $vector["clave1"]=trim($vector["clave1"]);
        $vector["clave2"]=trim($vector["clave2"]);
        $vector["clave3"]=trim($vector["clave3"]);
        if(!$vector["clave1"] || !$vector["clave2"] || !$vector["clave3"]){
            Flash::error("Las Claves No pueden Ser Vacias");
            return FALSE;
        }
        if(base64_encode($vector["clave1"])!= Auth::get("cla")){
            Flash::error("Las Claves Actual No corresponde con su Cotraseña de ingreso al Sistema");
            return FALSE;
        }
        if(strlen($vector["clave2"])<8 || strlen($vector["clave3"])<8){
            Flash::error("Las Nuevas Claves Deben Tener al Menos 8 caracteres");
            return FALSE;
        }
        
        if($vector["clave2"]!=$vector["clave3"]){
            Flash::error("Las Nuevas Contraseñas deben ser iguales");
            return FALSE;
        }
        $usu=new Usuario();
        $usu->id             = Auth::get("id");
        $usu->usu            = base64_decode(Auth::get("usu"));
        $usu->negocio_id     = Auth::get("negocio_id");
        $usu->rol_id         = Auth::get("rol_id");
        $usu->cla            = $vector["clave3"];
        
        return $usu->save();
    }
    
}
