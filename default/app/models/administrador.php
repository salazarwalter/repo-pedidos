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
 * 
 */
class Administrador extends ActiveRecord{
    
    public function initialize() {
        $this->validates_presence_of("adm_nom", array("message"=>"Ingrese el Nombre del  Administrador"));
        $this->validates_length_of("adm_nom", 45,6,array( 
                                  "too_short"=>"El Nombre del Administrador debe tener al menos 6 caracteres",
                                  "too_long"=>"El Nombre del Administrador  debe tener maximo 45 caracteres"));
        $this->validates_presence_of("adm_cel", array("message"=>"Ingrese el Celular del  Administrador"));
        $this->validates_length_of("adm_cel", 15,7,array( 
                                  "too_short"=>"El Celular del Administrador debe tener al menos 6 caracteres",
                                  "too_long"=>"El Celular del Administrador  debe tener maximo 15 caracteres"));
        
    }
    public function perfil($vec) {
        $a = $this->find_first("usuario_id=".Auth::get("id"));
        $vec["adm_nom"]  = trim($vec["adm_nom"]);
        $vec["adm_cel"]  = trim($vec["adm_cel"]);
        $vec["id"]       = $a->id;
        return $this->update($vec);
    }
}
