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
class Articulolinea extends ActiveRecord{
    
    public function initialize() {
        
    }
    
    public function borrar($linea_id) {
        $cant=$this->hallar($linea_id);
        
        
        if(count($cant)==1){
            $this->delete($linea_id);
        }
    }
    public function hallar($linea_id) {
        $sql = " 
                SELECT linea.* 
                FROM articulo INNER JOIN articulolinea linea ON linea.articulo_id  = articulo.id
                WHERE articulo.negocio_id = ".Auth::get("negocio_id")." 
                AND linea.id= $linea_id
               ";
        
        return $this->find_all_by_sql($sql);
    }
}
