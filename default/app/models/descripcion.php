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
class Descripcion extends ActiveRecord{
    
    public function initialize() {
////        $this->validates_uniqueness_of("neg_nom", array("message"=>"Nombre del Negocio Ya Ingresado"));
//        $this->validates_presence_of("pro_nom", array("message"=>"Ingrese el Producto"));
//        $this->validates_length_of("unidad", 60,4,array( 
//                                  "too_short"=>"El Producto debe tener al menos 4 caracteres",
//                                  "too_long"=>"El Producto debe tener máximo 60 caracteres"));
////        $this->validates_length_of("abreviatura", 6,0,array( 
////                                  "too_short"=>"La Abreviatura debe tener al menos 0 caracteres",
////                                  "too_long"=>"La Abreviatura debe tener máximo 6 caracteres"));
        
    }
    public function lista() {
        $sql =" 
SELECT promosionlinea.producto_id, 
       promosionlinea.promosion_id,
       promosionlinea.cantidad,
       producto.*,
       promosion.precio_promo,
       promosion.promo_nom,
       promosion.publicado,
       promosion.promosion,
       promosion.negocio_id,
       categoria.categoria,
       marca.marca,
       unidad.unidad,
       unidad.abreviatura
FROM producto INNER JOIN promosionlinea ON promosionlinea.producto_id   = producto.id
              INNER JOIN promosion      ON promosionlinea.promosion_id  = promosion.id
              INNER JOIN categoria      ON producto.categoria_id        = categoria.id
              INNER JOIN marca          ON producto.marca_id            = marca.id
              INNER JOIN unidad         ON producto.unidad_id           = unidad.id

            ";
        return $this->find("negocio_id = ".Auth::get("negocio_id"));
    }
    public function agregar($vector) {
        $vector["pro_nom"]      = trim($vector["pro_nom"]);
        $vector["pro_pre"]      = (float)trim($vector["pro_pre"]);
        $vector["negocio_id"]   = Auth::get("negocio_id");
        $vector["categoria_id"] = (int)trim($vector["categoria_id"]);
        $vector["unidad_id"]    = (int)trim($vector["unidad_id"]);
        $vector["marca_id"]     = (int)trim($vector["unidad_id"]);
        if($vector["marca_id"]<=0 || $vector["unidad_id"]<=0 || $vector["categoria_id"]){
            Flash::error("La Marca, Categoría y Unidad, Son Valores Requeridos");
            return FALSE;
        }
        
//        if($this->yaIngresadoAlta($vector)){
//            Flash::error("YA Se ingresó esta Producto");
//            return FALSE;
//        }
        $this->begin();
        $pro =new Producto();
        if(!$pro->create($vector)){
            $this->rollback();
            return FALSE;
        }
        
        $vector["promosion"]="N";
        $vector["publicado"]="N";
        $promo =new Promosion();
        if(!$promo->create($vector)){
            $this->rollback();
            return FALSE;
        }
        
        $vector["producto_id"]  = $pro->id;
        $vector["promosion_id"] = $promo->id;
        $vector["cantidad"]     = 1;
        $plinea =new Promosionlinea();
        if(!$plinea->create($vector)){
            $this->rollback();
            return FALSE;
        }
        
        $this->commit();
        return TRUE;
    }
    
    public function modificar($vector) {
        
        $vector["pro_nom"]      = trim($vector["pro_nom"]);
        $vector["pro_pre"]      = (float)trim($vector["pro_pre"]);
        $vector["negocio_id"]   = Auth::get("negocio_id");
        $vector["categoria_id"] = (int)trim($vector["categoria_id"]);
        $vector["unidad_id"]    = (int)trim($vector["unidad_id"]);
        $vector["marca_id"]     = (int)trim($vector["unidad_id"]);
//        $vector["id"]          = (int)trim($vector["id"];
        
        if($vector["id"]<=0){
            Flash::error("Unidad No reconocida");
            return FALSE;
        }
        if($vector["marca_id"]<=0 || $vector["unidad_id"]<=0 || $vector["categoria_id"]){
            Flash::error("La Marca, Categoría y Unidad, Son Valores Requeridos");
            return FALSE;
        }
        $h= $this->hallar($vector["id"]);
        if(!$h){
            Flash::error("Producto No Hallado");
            return FALSE;
        }
        
        $this->begin();
        $pro =new Producto();
        if(!$pro->create($vector)){
            $this->rollback();
            return FALSE;
        }
        
        $vector["promosion"]="N";
        $vector["publicado"]="N";
        $promo =new Promosion();
        if(!$promo->create($vector)){
            $this->rollback();
            return FALSE;
        }
        
        $vector["producto_id"]  = $pro->id;
        $vector["promosion_id"] = $promo->id;
        $vector["cantidad"]     = 1;
        $plinea =new Promosionlinea();
        if(!$plinea->create($vector)){
            $this->rollback();
            return FALSE;
        }
        
        $this->commit();
        return TRUE;
    }
    
    public function desactivar($vector) {
        $vector["id"]=(int)trim($vector["id"]);
        
        if($vector["id"]<=0){
            Flash::error("Unidad No reconocida");
            return FALSE;
        }
        $sql =" UPDATE unidad SET activo='N' WHERE id = ".$vector["id"];
        return $this->sql($sql);
    }
    public function activar($vector) {
        $vector["id"]=(int)trim($vector["id"]);
        
        if($vector["id"]<=0){
            Flash::error("Unidad No reconocida");
            return FALSE;
        }
        $sql =" UPDATE unidad SET activo='S' WHERE id = ".$vector["id"];
        return $this->sql($sql);
    }
    
    
    public function yaIngresadoAlta($vector) {
        $vector["pro_nom"]= addslashes($vector["pro_nom"]);
        return $this->exists("pro_nom='".$vector["pro_nom"]."' AND negocio_id=".Auth::get("negocio_id"));
    }
    public function yaIngresadoEdit($vector) {
        $vector["unidad"]= addslashes($vector["unidad"]);
        return $this->exists("unidad='".$vector["unidad"]."' AND negocio_id=".Auth::get("negocio_id")." AND id<>".$vector["id"]);
    }
    
    public function hallar($promo_id) {
        $promo_id = (int)$promo_id;
        if($promo_id<=0){
            Flash::error("Producto No identificado");
            return FALSE;
        }
        $sql =" 
SELECT promosionlinea.producto_id, 
       promosionlinea.promosion_id,
       promosionlinea.cantidad,
       producto.*,
       promosion.precio_promo,
       promosion.promo_nom,
       promosion.publicado,
       promosion.promosion,
       promosion.negocio_id,
       categoria.categoria,
       marca.marca,
       unidad.unidad,
       unidad.abreviatura
FROM producto INNER JOIN promosionlinea ON promosionlinea.producto_id   = producto.id
              INNER JOIN promosion      ON promosionlinea.promosion_id  = promosion.id
              INNER JOIN categoria      ON producto.categoria_id        = categoria.id
              INNER JOIN marca          ON producto.marca_id            = marca.id
              INNER JOIN unidad         ON producto.unidad_id           = unidad.id
WHERE promosion.id = $promo_id 
AND   promosion.negocio_id =".Auth::get("negocio_id")."    
            ";
        return $this->find_by_sql($sql);
    }
    
    public function combo() {
        return $this->find("activo='S' AND negocio_id=".Auth::get("negocio_id"));
    }
}
