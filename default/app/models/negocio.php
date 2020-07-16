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
class Negocio extends ActiveRecord{
    
    public function initialize() {
        $this->validates_uniqueness_of("neg_nom", array("message"=>"Nombre del Negocio Ya Ingresado"));
        $this->validates_presence_of("neg_nom", array("message"=>"Ingrese el Nombre del Negocio"));
        $this->validates_length_of("neg_nom", 45,4,array( 
                                  "too_short"=>"La RAZON SOCIAL(nombre) debe tener al menos 4 caracteres",
                                  "too_long"=>"La RAZON SOCIAL(nombre) debe tener máximo 45 caracteres"));
        $this->validates_length_of("neg_dom", 45,0,array( 
                                  "too_short"=>"El Domicilio debe tener al menos 0 caracteres",
                                  "too_long"=>"El Domicilio debe tener máximo 45 caracteres"));
        $this->validates_length_of("neg_tel", 30,0,array( 
                                  "too_short"=>"El Teléfono debe tener al menos 0 caracteres",
                                  "too_long"=>"El Teléfono debe tener máximo 30 caracteres"));
        $this->validates_length_of("neg_mail", 30,0,array( 
                                  "too_short"=>"El Email debe tener al menos 0 caracteres",
                                  "too_long"=>"El Email debe tener máximo 30 caracteres"));
        $this->validates_length_of("neg_cuit", 15,0,array( 
                                  "too_short"=>"El CUIT debe tener al menos 0 caracteres",
                                  "too_long"=>"El CUIT debe tener máximo 15 caracteres"));
        $this->validates_length_of("tags", 200,0,array( 
                                  "too_short"=>"Las Etiquetas(tags) debe tener al menos 0 caracteres",
                                  "too_long"=>"Las Etiquetas(tags) debe tener máximo 200 caracteres"));
        $this->validates_length_of("horario", 80,0,array( 
                                  "too_short"=>"El Horario debe tener al menos 0 caracteres",
                                  "too_long"=>"El Horario debe tener máximo 80 caracteres"));
        
    }
    public function lista() {
        $sql =" 
            SELECT neg.* , 
                   loc.loc,
                   pro.prov,
                   rub.rubro,
                   rub.icono,
                   FROM_BASE64(usu.usu) as usu,
                   usu.cla,
                   usu.foto,
                   usu.confirmado,
                   usu.usuario_at,
                   usu.rol_id,
                   rol.rol,
                   adm.adm_nom,
                   adm.adm_cel,
                   adm.adm_mail

            FROM provincia pro INNER JOIN localidad     loc  ON loc.provincia_id = pro.id
                               INNER JOIN negocio       neg  ON neg.localidad_id = loc.id
                               INNER JOIN rubro         rub  ON neg.rubro_id     = rub.id
                               INNER JOIN usuario       usu  ON usu.negocio_id   = neg.id
                               INNER JOIN rol           rol  ON usu.rol_id       = rol.id
                               INNER JOIN administrador adm  ON adm.usuario_id   = usu.id
            ";
        return $this->find_all_by_sql($sql);
    }
    public function listaNegociosXRubro($rubro_id) {
        $sql =" 
            SELECT neg.* , 
                   loc.loc,
                   pro.prov

            FROM provincia pro INNER JOIN localidad     loc  ON loc.provincia_id = pro.id
                               INNER JOIN negocio       neg  ON neg.localidad_id = loc.id
            AND neg.rubro_id = $rubro_id 
            AND neg.activo='S' 
            ";
        return $this->find_all_by_sql($sql);
    }
    
    public function agregar($vector) {
        $vector["neg_nom"]      = trim($vector["neg_nom"]);
        $vector["neg_dom"]      = trim($vector["neg_dom"]);
//        $vector["neg_tel"]      = trim($vector["neg_tel"]);
//        $vector["neg_mail"]     = trim($vector["neg_mail"]);
//        $vector["neg_cuit"]     = trim($vector["neg_cuit"]);
        $vector["rubro_id"]     = (int)trim($vector["rubro_id"]);
        $vector["localidad_id"] = (int)trim($vector["localidad_id"]);
        
        if($vector["rubro_id"]<=0 || $vector["localidad_id"]<=0 ){
             Flash::error("El Rubro y la Localidad Son Necesarios");
            return FALSE;
        }
        
        $this->begin();
        $neg =new Negocio();
        if(!$neg->create($vector)){
            Flash::error("No se pudo guardar el Negocio");
            $this->rollback();
            return FALSE;
        }
        $vector["usu"]      = trim($vector["usu"]);
        $vector["cla"]      = trim($vector["cla"]);
        $vector["cla1"]      = trim($vector["cla1"]);
        
        if($vector["cla"] !=$vector["cla1"]){
            Flash::error("Claves deben Ser IGUALES");
            $this->rollback();
            return FALSE;
        }
        $vector["negocio_id"]      = $neg->id;
        $vector["rol_id"]          = 2;
        $vector["confirmado"]          = "S";
        
        $usu =new Usuario();
        if(!$usu->create($vector)){
            Flash::error("No se Pudo crear el Usuario");
            $this->rollback();
            return FALSE;
        }
        
        $adm = new Administrador();
        $vector["adm_nom"]      = trim($vector["adm_nom"]);
        $vector["adm_cel"]      = trim($vector["adm_cel"]);
        $vector["usuario_id"]   = $usu->id;
        if(!$adm->create($vector)){
            Flash::error("No se Pudo registrar el Administrador local");
            $this->rollback();
            return FALSE;
        }
      $this->commit();
      return TRUE;
    }
    
    public function modificar($vector) {
        $h = new Negocio();
        $obj = $h->hallar($vector["id"]);
        if(!$obj) return FALSE;
        
        $vector["neg_nom"]      = trim($vector["neg_nom"]);
        $vector["neg_dom"]      = trim($vector["neg_dom"]);
        $vector["rubro_id"]     = (int)trim($vector["rubro_id"]);
        $vector["localidad_id"] = (int)trim($vector["localidad_id"]);
        
        if($vector["rubro_id"]<=0 || $vector["localidad_id"]<=0 ){
             Flash::error("El Rubro y la Localidad Son Necesarios");
            return FALSE;
        }

        $this->begin();
        $neg =new Negocio();
        if(!$neg->update($vector)){
            Flash::error("No se pudo Actualizar el Negocio");
            $this->rollback();
            return FALSE;
        }
        
        
        $vector["id"]          = $obj->usuario_id;
        $vector["usu"]         = trim($vector["usu"]);
        $vector["cla"]         = base64_decode($obj->cla);
        $vector["negocio_id"]  = $obj->id;
        $vector["rol_id"]      = 2;
        $vector["confirmado"]  = "S";
        
        $usu =new Usuario();
        if(!$usu->update($vector)){
            Flash::error("No se Pudo Actualizar el Usuario");
            $this->rollback();
            return FALSE;
        }
        
        $adm = new Administrador();
        $vector["id"]           = $obj->administrador_id;
        $vector["adm_nom"]      = trim($vector["adm_nom"]);
        $vector["adm_cel"]      = trim($vector["adm_cel"]);
        $vector["usuario_id"]   = $usu->id;
        if(!$adm->update($vector)){
            Flash::error("No se Pudo Actualizar el Administrador local");
            $this->rollback();
            return FALSE;
        }
        
        $this->commit();
        return TRUE;
    }
    public function general($vector) {
        $h = new Negocio();
        $obj = $h->hallar(Auth::get("negocio_id"));
        if(!$obj) return FALSE;
        
        $vector["neg_nom"]      = trim($vector["neg_nom"]);
        $vector["neg_cuit"]     = trim($vector["neg_cuit"]);
        $vector["neg_tel"]      = trim($vector["neg_tel"]);
        $vector["neg_mail"]     = trim($vector["neg_mail"]);
        if($vector["neg_mail"]){
            if (!filter_var($vector["neg_mail"], FILTER_VALIDATE_EMAIL)) {
                Flash::error("EMail No Válido");
                return FALSE;
            }
            
        }
        $vector["rubro_id"]     = $obj->rubro_id;
        $vector["localidad_id"] = $obj->localidad_id;
        $vector["tags"]         = $obj->tags;
        $vector["horario"]      = $obj->horario;
        $vector["id"]           = $obj->id;
        
        $this->begin();
        $neg =new Negocio();
        if(!$neg->update($vector)){
            Flash::error("No se pudo Actualizar el Negocio");
            $this->rollback();
            return FALSE;
        }
        $this->commit();
        return TRUE;
    }
    public function domicilio($vector) {
        $h = new Negocio();
        $obj = $h->hallar(Auth::get("negocio_id"));
        if(!$obj) return FALSE;
        
        $vector["neg_dom"]      = trim($vector["neg_dom"]);
        $vector["localidad_id"] = (int)$vector["localidad_id"];
        if($vector["localidad_id"]<=0){
            Flash::error("Localidad No reconocida");
            return FALSE;
        }
        
        $vector["neg_nom"]      = $obj->neg_nom;
        $vector["rubro_id"]     = $obj->rubro_id;
        $vector["tags"]         = $obj->tags;
        $vector["horario"]      = $obj->horario;
        $vector["id"]           = $obj->id;
        
        $this->begin();
        $neg =new Negocio();
        if(!$neg->update($vector)){
            Flash::error("No se pudo Actualizar el Negocio");
            $this->rollback();
            return FALSE;
        }
        $this->commit();
        return TRUE;
    }
    public function busqueda($vector) {
        $h = new Negocio();
        $obj = $h->hallar(Auth::get("negocio_id"));
        if(!$obj) return FALSE;
        
        $vector["tags"]         = trim($vector["tags"]);
        $vector["horario"]      = trim($vector["horario"]);
        $vector["rubro_id"]     = (int)$vector["rubro_id"];
        if($vector["rubro_id"]<=0){
            Flash::error("Rubro Desconocido");
            return FALSE;
        }
        $vector["neg_nom"]      = $obj->neg_nom;
//        $vector["rubro_id"]     = $obj->rubro_id;
        $vector["localidad_id"] = $obj->localidad_id;
        $vector["id"]           = $obj->id;
        
        $this->begin();
        $neg =new Negocio();
        if(!$neg->update($vector)){
            Flash::error("No se pudo Actualizar el Negocio");
            $this->rollback();
            return FALSE;
        }
        $this->commit();
        return TRUE;
    }
    
    public function desactivar($vector) {
        $vector["id"]=(int)trim($vector["id"]);
        
        if($vector["id"]<=0){
            Flash::error("Negocio No reconocida");
            return FALSE;
        }
        $sql =" UPDATE negocio SET activo='N' WHERE id = ".$vector["id"];
        return $this->sql($sql);
    }
    public function activar($vector) {
        $vector["id"]=(int)trim($vector["id"]);
        
        if($vector["id"]<=0){
            Flash::error("Negocio No reconocido");
            return FALSE;
        }
        $sql =" UPDATE negocio SET activo='S' WHERE id = ".$vector["id"];
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
    
    public function hallar($nego_id) {
        $nego_id = (int)$nego_id;
        if($nego_id<=0){
            Flash::error("Negocio No identificada");
            return FALSE;
        }
        $sql =" 
            SELECT neg.* , 
                   loc.loc,
                   loc.provincia_id,
                   pro.prov,
                   rub.rubro,
                   rub.icono,
                   FROM_BASE64(usu.usu) as usu,
                   usu.cla,
                   usu.foto,
                   usu.confirmado,
                   usu.usuario_at,
                   usu.rol_id,
                   rol.rol,
                   adm.adm_nom,
                   adm.adm_cel,
                   adm.usuario_id,
                   adm.id as administrador_id,
                   adm.adm_mail

            FROM provincia pro INNER JOIN localidad     loc  ON loc.provincia_id = pro.id
                               INNER JOIN negocio       neg  ON neg.localidad_id = loc.id
                               INNER JOIN rubro         rub  ON neg.rubro_id     = rub.id
                               INNER JOIN usuario       usu  ON usu.negocio_id   = neg.id
                               INNER JOIN rol           rol  ON usu.rol_id       = rol.id
                               INNER JOIN administrador adm  ON adm.usuario_id   = usu.id
            WHERE neg.id=$nego_id 
            ";
        return $this->find_by_sql($sql);
    }
    
    public function combo() {
        return $this->find("activo='S'");
    }
    
}
