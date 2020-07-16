<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of contrata
 *
 * @author salazarwalter
 */
class Contrata extends ActiveRecord{
    public function lista_x_negocio($neg_id) {
        $sql = " 

            SELECT contrata.*,
                   negocio.neg_nom, 
                   modulo.modulo 
            FROM contrata INNER JOIN modulo  ON contrata.modulo_id  = modulo.id
                          INNER JOIN negocio ON contrata.negocio_id = negocio.id
            WHERE contrata.negocio_id = $neg_id 
            ORDER BY contrata.id DESC
            
        ";
//        die($sql);
        return $this->find_all_by_sql($sql);
    }
    
    public function agregar($vec) {
        $vec["negocio_id"] = (int)  $vec["negocio_id"];
        $vec["modulo_id"]  = (int)  $vec["modulo_id"];
        $vec["precio"]     = (float)$vec["precio"];
        if($vec["precio"]<=0 ||$vec["negocio_id"]<=0 ||$vec["modulo_id"]<=0 ){
            Flash::error("El Negocio, El modulo y el Precio Son Valores Mayores que Cero");
            return FALSE;
        }
        if($this->yaIngresadoAlta($vec["modulo_id"], $vec["negocio_id"])){
            Flash::error("Módulo YA ASIGNADO para este Negocio/Institución");
            return FALSE;
            
        }
        $vec["desde"]     = date("Y-m-d H:i:s");
        return $this->create($vec);
    }
    public function yaIngresadoAlta($modulo_id,$negocio_id) {
        return $this->exists("negocio_id = $negocio_id AND modulo_id=$modulo_id AND activo='S' ");
    }
    public function modificar($vec) {
        $vec["id"]         = (int)  $vec["id"];
        $vec["negocio_id"] = (int)  $vec["negocio_id"];
        $vec["modulo_id"]  = (int)  $vec["modulo_id"];
        $vec["precio"]     = (float)$vec["precio"];
        if($vec["precio"]<=0 ||$vec["negocio_id"]<=0 ||$vec["modulo_id"]<=0 ){
            Flash::error("El Negocio, El modulo y el Precio Son Valores Mayores que Cero");
            return FALSE;
        }
        if($this->yaIngresadoEdit($vec["modulo_id"], $vec["negocio_id"], $vec["id"])){
            Flash::error("Módulo YA ASIGNADO para este Negocio/Institución");
            return FALSE;
            
        }
        $vec["desde"]     = date("Y-m-d H:i:s");
        return $this->update($vec);
    }
    public function yaIngresadoEdit($modulo_id,$negocio_id,$id) {
        return $this->exists("negocio_id = $negocio_id AND modulo_id=$modulo_id AND activo='S' AND id<>$id");
    }
    
    public function lista() {
        $sql =" 
            SELECT contrata.* ,
                   negocio.neg_nom,
                   modulo.modulo
            FROM contrata INNER JOIN negocio ON contrata.negocio_id  = negocio.id
                          INNER JOIN modulo  ON contrata.modulo_id   = modulo.id
            ORDER BY negocio.neg_nom,modulo.modulo
            ";
        return $this->find_all_by_sql($sql);
    }
    
    public function hallar($contrata_id) {
        $contrata_id = (int)$contrata_id;
        if($contrata_id<=0){
            Flash::error("Contrata no hallado");
            return FALSE;
        }
        
        $h = $this->find_by_id($contrata_id);
        if(!$h){
            Flash::error("Contrata Obj no hallado");
            return FALSE;
        }
        return $h;
    }
}
