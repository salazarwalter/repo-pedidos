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
class Cliente extends ActiveRecord{
    
    
    public function initialize() {
        $this->validates_uniqueness_of("cli_dni", array("message"=>"DNI Ya Ingresado"));
//        $this->validates_uniqueness_of("cli_nom", array("message"=>"Nombre del Negocio Ya Ingresado"));
        $this->validates_presence_of("cli_nom", array("message"=>"Ingrese Apellido y Nombre"));
        $this->validates_presence_of("cli_cel", array("message"=>"Ingrese Celular del Cliente"));
        $this->validates_presence_of("cli_dom", array("message"=>"Ingrese Domicilio del Cliente"));
        $this->validates_length_of("cli_nom", 45,4,array( 
                                  "too_short"=>"Apellido y Nombre debe tener al menos 4 caracteres",
                                  "too_long"=>"Apellido y Nombre debe tener máximo 45 caracteres"));
        $this->validates_length_of("cli_dom", 45,5,array( 
                                  "too_short"=>"El Domicilio debe tener al menos 5 caracteres",
                                  "too_long"=>"El Domicilio debe tener máximo 45 caracteres"));
        $this->validates_length_of("cli_cel", 15,0,array( 
                                  "too_short"=>"El Celular debe tener al menos 0 caracteres",
                                  "too_long"=>"El Celular debe tener máximo 15 caracteres"));
        $this->validates_numericality_of("cli_dni", array("message"=>"El Dni debe ser Numérico"));
//        $this->validates_length_of("neg_mail", 30,0,array( 
//                                  "too_short"=>"El Email debe tener al menos 0 caracteres",
//                                  "too_long"=>"El Email debe tener máximo 30 caracteres"));
//        $this->validates_length_of("neg_cuit", 15,0,array( 
//                                  "too_short"=>"El CUIT debe tener al menos 0 caracteres",
//                                  "too_long"=>"El CUIT debe tener máximo 15 caracteres"));
//        $this->validates_length_of("tags", 200,0,array( 
//                                  "too_short"=>"Las Etiquetas(tags) debe tener al menos 0 caracteres",
//                                  "too_long"=>"Las Etiquetas(tags) debe tener máximo 200 caracteres"));
//        $this->validates_length_of("horario", 80,0,array( 
//                                  "too_short"=>"El Horario debe tener al menos 0 caracteres",
//                                  "too_long"=>"El Horario debe tener máximo 80 caracteres"));
        
    }
    public function lista() {
        $sql =" 
            SELECT cliente.* ,
                   usuario.usu,
                   usuario.cla,
                   usuario.foto,
                   usuario.negocio_id,
                   usuario.usuario_at,
                   usuario.activo,
                   localidad.loc,
                   localidad.provincia_id,
                   provincia.prov
            FROM cliente INNER JOIN usuario   ON cliente.usuario_id     = usuario.id
                         INNER JOIN localidad ON cliente.localidad_id   = localidad.id
                         INNER JOIN provincia ON localidad.provincia_id = provincia.id
            WHERE usuario.negocio_id = ".Auth::get("negocio_id")." 
            ";
        return $this->find_all_by_sql($sql);
    }
    
    public function agregar($vector) {
        $vector["usu"]      = trim($vector["usu"]);
        $vector["cla"]      = trim($vector["cla"]);
        $vector["cla1"]      = trim($vector["cla1"]);
        
        if($vector["cla"] !=$vector["cla1"]){
            Flash::error("Claves deben Ser IGUALES");
            return FALSE;
        }
        $vector["negocio_id"]      = Auth::get("negocio_id");
        $vector["rol_id"]          = 3; // Rol Negocio Cliente
        $vector["confirmado"]      = "S";
        
        $this->begin();
        $usu =new Usuario();
        if(!$usu->create($vector)){
            $this->rollback();
            return FALSE;
        }
        
        $vector["cli_nom"]      = trim($vector["cli_nom"]);
        $vector["cli_dom"]      = trim($vector["cli_dom"]);
        $vector["cli_dni"]      = trim($vector["cli_dni"]);
        $vector["cli_cel"]      = trim($vector["cli_cel"]);
        $vector["localidad_id"] = (int)trim($vector["localidad_id"]);
        $vector["usuario_id"]   = $usu->id;
        
        if($vector["localidad_id"]<=0 ){
             Flash::error("La Localidad Es Necesaria");
             $this->rollback();
            return FALSE;
        }
        
        
        $cli = new Cliente();
        if(!$cli->create($vector)){
            $this->rollback();
            return FALSE;
        }
      $this->commit();
      return TRUE;
    }
    
    public function modificar($vector) {
        $h = new Cliente();
        $obj = $h->hallar($vector["id"]);
        if(!$obj) return FALSE;
        
        $vector["usu"]      = trim($vector["usu"]);
        $vector["cla"]      = base64_decode($obj->cla);
        
        
        $vector["negocio_id"]      = Auth::get("negocio_id");
        $vector["rol_id"]          = 3; // Rol Negocio Cliente
        $vector["confirmado"]      = "S";
        $vector["id"]              = $obj->usuario_id;
        
        $this->begin();
        $usu =new Usuario();
        if(!$usu->update($vector)){
            $this->rollback();
            return FALSE;
        }
        $vector["cli_nom"]      = trim($vector["cli_nom"]);
        $vector["cli_dom"]      = trim($vector["cli_dom"]);
        $vector["cli_dni"]      = trim($vector["cli_dni"]);
        $vector["cli_cel"]      = trim($vector["cli_cel"]);
        $vector["localidad_id"] = (int)trim($vector["localidad_id"]);
        $vector["id"]           = $obj->id;
        $vector["usuario_id"]   = $obj->usuario_id;
        
        if($vector["localidad_id"]<=0 ){
             Flash::error("La Localidad Es Necesaria");
             $this->rollback();
            return FALSE;
        }
        
        
        $cli = new Cliente();
        if(!$cli->update($vector)){
            $this->rollback();
            return FALSE;
        }
      $this->commit();
      return TRUE;
    }
    
    public function perfil($vector) {
        $h = new Cliente();
        $obj = $h->find_first("usuario_id=".Auth::get("id"));
        
//        $obj = $h->hallar($vector["id"]);
//        if(!$obj) return FALSE;
        
        $vector["id"]              = $obj->usuario_id;
        
        $vector["cli_nom"]      = trim($vector["cli_nom"]);
        $vector["cli_dom"]      = trim($vector["cli_dom"]);
        $vector["cli_dni"]      = trim($vector["cli_dni"]);
        $vector["cli_cel"]      = trim($vector["cli_cel"]);
        $vector["cli_mail"]      = trim($vector["cli_mail"]);
        $vector["localidad_id"] = (int)trim($vector["localidad_id"]);
        $vector["id"]           = $obj->id;
        $vector["usuario_id"]   = $obj->usuario_id;
        
        if($vector["localidad_id"]<=0 ){
             Flash::error("La Localidad Es Necesaria");
             $this->rollback();
            return FALSE;
        }
        
        
        $this->begin();
        $cli = new Cliente();
        if(!$cli->update($vector)){
            $this->rollback();
            return FALSE;
        }
      $this->commit();
      return TRUE;
    }
    
    public function desactivar($vector) {
        $vector["id"]=(int)trim($vector["id"]);
        
        if($vector["id"]<=0){
            Flash::error("Cliente No reconocida");
            return FALSE;
        }
        $sql =" UPDATE usuario SET activo='N' WHERE id = ".$vector["id"]." AND negocio_id=".Auth::get("negocio_id");
        
        return $this->sql($sql);
    }
    
    public function activar($vector) {
        $vector["id"]=(int)trim($vector["id"]);
        
        if($vector["id"]<=0){
            Flash::error("Cliente No reconocido");
            return FALSE;
        }
        $sql =" UPDATE usuario SET activo='S' WHERE id = ".$vector["id"]." AND negocio_id=".Auth::get("negocio_id");
        return $this->sql($sql);
    }
    
    
   
    public function hallar($cli_id) {
        $cli_id = (int)$cli_id;
        if($cli_id<=0){
            Flash::error("Negocio No identificada");
            return FALSE;
        }
        $sql =" 
            SELECT cliente.* ,
                   usuario.usu,
                   usuario.cla,
                   usuario.foto,
                   usuario.negocio_id,
                   usuario.usuario_at,
                   usuario.activo,
                   localidad.loc,
                   localidad.provincia_id,
                   provincia.prov
            FROM cliente INNER JOIN usuario   ON cliente.usuario_id     = usuario.id
                         INNER JOIN localidad ON cliente.localidad_id   = localidad.id
                         INNER JOIN provincia ON localidad.provincia_id = provincia.id
            WHERE usuario.negocio_id = ".Auth::get("negocio_id")." 
            AND   cliente.id=$cli_id  
            ";
        return $this->find_by_sql($sql);
    }
    
    public function combo() {
        return $this->find("activo='S'");
    }
}
