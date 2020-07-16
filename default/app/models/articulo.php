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
class Articulo extends ActiveRecord{
    public static $PUBLICADO = array("N"=>"No Publicado","S"=>"Publicado");
    public function initialize() {
//        $this->validates_uniqueness_of("neg_nom", array("message"=>"Nombre del Negocio Ya Ingresado"));
        $this->validates_presence_of("art_nom", array("message"=>"Ingrese el Nombre del Artículo"));
        $this->validates_length_of("art_nom", 60,2,array( 
                                  "too_short"=>"El Nombre del Artículo debe tener al menos 2 caracteres",
                                  "too_long"=>"El Nombre del Artículo debe tener máximo 60 caracteres"));
//        $this->validates_length_of("abreviatura", 6,0,array( 
//                                  "too_short"=>"La Abreviatura debe tener al menos 0 caracteres",
//                                  "too_long"=>"La Abreviatura debe tener máximo 6 caracteres"));
        
    }
    public function listaArticulos() {
    $sql=" 

            SELECT articulo.* ,
                   articulolinea.id as linea_id,
                   articulolinea.cant,
                   articulolinea.articulo_id,
                   articulolinea.descripcion_id,
                   descripcion.pro_pre,
                   descripcion.marca_id,
                   descripcion.unidad_id,
                   marca.marca,
                   unidad.unidad,
                   unidad.abreviatura,
                   categoria.categoria,
                   categoria.icono

            FROM articulo INNER JOIN articulolinea ON articulolinea.articulo_id    = articulo.id
                          INNER JOIN descripcion   ON articulolinea.descripcion_id = descripcion.id
                          INNER JOIN marca         ON descripcion.marca_id         = marca.id
                          INNER JOIN unidad        ON descripcion.unidad_id        = unidad.id
                          INNER JOIN categoria     ON articulo.categoria_id        = categoria.id
            WHERE articulo.promosion='N'
            AND articulo.negocio_id = ".Auth::get("negocio_id")." 
        ";
//    die($sql);
        return $this->find_all_by_sql($sql);
    }
    
    public function listaPromosiones() {
    $sql=" 
            SELECT articulo.*,
                   `categoria`.`categoria`, 
                   `categoria`.`icono` 
            FROM articulo INNER JOIN categoria ON `articulo`.`categoria_id` = `categoria`.`id` 
            WHERE `articulo`.`promosion`= 'S' 
            AND articulo.negocio_id = ".Auth::get("negocio_id")." 
        ";
//    die($sql);
        
        return $this->find_all_by_sql($sql);
    }
    public function listaPromosionesParaCliente() {
    $sql=" 
            SELECT articulo.*,
                   `categoria`.`categoria`, 
                   `categoria`.`icono` 
            FROM articulo INNER JOIN categoria ON `articulo`.`categoria_id` = `categoria`.`id` 
            WHERE `articulo`.`publicado`= 'S' 
            AND  `articulo`.`activo`= 'S' 
            AND articulo.negocio_id = ".Auth::get("negocio_id")." 
        ";
//    die($sql);
        
        return $this->find_all_by_sql($sql);
    }
    
    public function agregarArticulo($vector) {
        $vector["art_nom"]    = trim($vector["art_nom"]);
        $vector["descripcion"]= trim($vector["art_nom"]);
        $vector["art_pre"]    = (float)trim($vector["art_pre"]);
        $vector["pro_pre"]    = (float)trim($vector["art_pre"]);
        $vector["negocio_id"] = Auth::get("negocio_id");
        $vector["promocion"]  = "N";
        $vector["publicado"]  = "N";
        
        $vector["marca_id"]    = (int)$vector["marca_id"];
        $vector["unidad_id"]   = (int)$vector["unidad_id"];
        $vector["categoria_id"]= (int)$vector["categoria_id"];
        if($vector["categoria_id"]<=0||$vector["marca_id"]<=0||$vector["unidad_id"]<=0){
            Flash::error("Marca, Unidad y Categoria Son REQUERIDOS");
            return FALSE;
        }
        
        if($this->noPertenecenNegocio($vector)){
            Flash::error("Marca, Unidad y Categoria Desconocidas");
            return FALSE;
        }
        
        $this->begin();
        $art =new Articulo();
        if(!$art->create($vector)){
            $this->rollback();
            return FALSE;
        }
        
        $des =new Descripcion();
        if(!$des->create($vector)){
            $this->rollback();
            return FALSE;
        }
        $linea =new Articulolinea();
        $vector["cant"]           = 1;
        $vector["articulo_id"]    = $art->id;
        $vector["descripcion_id"] = $des->id;
        if(!$linea->create($vector)){
            $this->rollback();
            return FALSE;
        }
        $this->commit();
        
        return TRUE;
    }
    
    public function agregarPromosion($vector) {
        $vector["art_nom"]      = trim($vector["art_nom"]);
        $vector["art_pre"]      = (float)trim($vector["art_pre"]);
        $vector["categoria_id"] = (int)trim($vector["categoria_id"]);
        $vector["negocio_id"]   = Auth::get("negocio_id");
        $vector["promosion"]    = "S";
        
        if($vector["art_pre"]<=0){
            Flash::error("El Precio debe ser Numerico y Mayor que cero");
            return FALSE;
        }
        if($vector["categoria_id"]<=0){
            Flash::error("Categoria Desconocida");
            return FALSE;
        }
        
        
        $this->begin();
        $art =new Articulo();
        if(!$art->create($vector)){
            $this->rollback();
            return FALSE;
        }
       
        $this->commit();
        
        return TRUE;
    }
    
    public function modificarArticulo($vector) {
        $h = $this->hallarArticulos($vector["id"]);
        
        $vector["art_nom"]    = trim($vector["art_nom"]);
        $vector["descripcion"]= trim($vector["art_nom"]);
        $vector["art_pre"]    = (float)trim($vector["art_pre"]);
        $vector["pro_pre"]    = (float)trim($vector["art_pre"]);
        $vector["negocio_id"]= Auth::get("negocio_id");
        
        $vector["marca_id"]    = (int)$vector["marca_id"];
        $vector["unidad_id"]   = (int)$vector["unidad_id"];
        $vector["categoria_id"]= (int)$vector["categoria_id"];
        if($vector["categoria_id"]<=0||$vector["marca_id"]<=0||$vector["unidad_id"]<=0){
            Flash::error("Marca, Unidad y Categoria Son REQUERIDOS");
            return FALSE;
        }
        
        if($this->noPertenecenNegocio($vector)){
            Flash::error("Marca, Unidad y Categoria Resconocidas");
            return FALSE;
        }
        
        
        $this->begin();
        $art =new Articulo();
        if(!$art->update($vector)){
            $this->rollback();
            return FALSE;
        }
        
        $des =new Descripcion();
        $vector["id"]= $h->descripcion_id;
        if(!$des->update($vector)){
            $this->rollback();
            return FALSE;
        }
        $linea =new Articulolinea();
        $vector["id"]= $h->linea_id;
        $vector["cant"]           = 1;
        $vector["articulo_id"]    = $h->articulo_id;
        $vector["descripcion_id"] = $h->descripcion_id;
        if(!$linea->update($vector)){
            $this->rollback();
            return FALSE;
        }
        $this->commit();
//        print_r($h);
//        echo "<br><br>";
//        print_r($vector);
//        die();
        
        return TRUE;
    }
    public function modificarPromosion($vector) {
        $h = $this->hallarPromosion($vector["id"]);
        $vector["categoria_id"] = (int)trim($vector["categoria_id"]);
        $vector["art_nom"]      = trim($vector["art_nom"]);
        $vector["art_pre"]      = (float)trim($vector["art_pre"]);
        $vector["negocio_id"]   = Auth::get("negocio_id");
        $vector["categoria_id"] = (int)trim($vector["categoria_id"]);
//        $vector["publicado"]  = "N";
        
        if($vector["art_pre"]<=0){
            Flash::error("El Precio debe ser Numerico y Mayor que cero");
            return FALSE;
        }
        if($vector["categoria_id"]<=0){
            Flash::error("Categoria Desconocida");
            return FALSE;
        }
        
        
        $this->begin();
        $art =new Articulo();
        if(!$art->update($vector)){
            $this->rollback();
            return FALSE;
        }
        $this->commit();
        
        return TRUE;
    }
    
    public function desactivarArticulo($vector) {
        $vector["id"]=(int)trim($vector["id"]);
        
        if($vector["id"]<=0){
            Flash::error("Artículo No reconocido");
            return FALSE;
        }
        $sql =" UPDATE articulo SET activo='N' WHERE promosion='N' AND id = ".$vector["id"]." AND negocio_id=".Auth::get("negocio_id");
        return $this->sql($sql);
    }
    public function desactivarPromosion($vector) {
        $vector["id"]=(int)trim($vector["id"]);
        
        if($vector["id"]<=0){
            Flash::error("Promoción No reconocido");
            return FALSE;
        }
        $sql =" UPDATE articulo SET activo='N' WHERE promosion='S' AND id = ".$vector["id"]." AND negocio_id=".Auth::get("negocio_id");
        return $this->sql($sql);
    }
    public function activarArticulo($vector) {
        $vector["id"]=(int)trim($vector["id"]);
        
        if($vector["id"]<=0){
            Flash::error("Artículo No reconocido");
            return FALSE;
        }
        $sql =" UPDATE articulo SET activo='S' WHERE  promosion='N' AND id = ".$vector["id"]." AND negocio_id=".Auth::get("negocio_id");
        return $this->sql($sql);
    }
    public function activarPromosion($vector) {
        $vector["id"]=(int)trim($vector["id"]);
        
        if($vector["id"]<=0){
            Flash::error("Promoción No reconocido");
            return FALSE;
        }
        $sql =" UPDATE articulo SET activo='S' WHERE  promosion='S' AND id = ".$vector["id"]." AND negocio_id=".Auth::get("negocio_id");
        return $this->sql($sql);
    }
    
    public function noPertenecenNegocio($vec) {
        $sql=" 
            SELECT COUNT(unidad.id)
            FROM unidad INNER JOIN marca      ON unidad.negocio_id     = marca.negocio_id
                        INNER JOIN categoria  ON categoria.negocio_id  = marca.negocio_id
            WHERE unidad.id    = {$vec["unidad_id"]} 
            AND   marca.id     = {$vec["marca_id"]} 
            AND   categoria.id = {$vec["categoria_id"]} 
            AND   categoria.negocio_id = ".Auth::get("negocio_id")." 
            ";
            return $this->count_by_sql($sql) == 0;
    }
    
    public function hallarArticulos($arti_id) {
        $arti_id = (int)$arti_id;
        if($arti_id<=0){
            Flash::error("Provincia No identificada");
            return FALSE;
        }
        $sql=" 
        SELECT articulo.* ,
               articulolinea.id as linea_id,
               articulolinea.cant,
               articulolinea.articulo_id,
               articulolinea.descripcion_id,
               descripcion.pro_pre,
               descripcion.marca_id,
               descripcion.unidad_id,
               marca.marca,
               unidad.unidad,
               unidad.abreviatura,
               categoria.categoria,
               categoria.icono

        FROM articulo INNER JOIN articulolinea ON articulolinea.articulo_id    = articulo.id
                      INNER JOIN descripcion   ON articulolinea.descripcion_id = descripcion.id
                      INNER JOIN marca         ON descripcion.marca_id         = marca.id
                      INNER JOIN unidad        ON descripcion.unidad_id        = unidad.id
                      INNER JOIN categoria     ON articulo.categoria_id        = categoria.id
        WHERE articulo.promosion='N'
        AND articulo.negocio_id = ".Auth::get("negocio_id")." 
        AND articulo.id = $arti_id    
            ";
        return $this->find_by_sql($sql);
    }

    public function hallarPromosion($arti_id) {
        $arti_id = (int)$arti_id;
        if($arti_id<=0){
            Flash::error("Promoción No identificada");
            return FALSE;
        }
        $sql =" 
                SELECT articulo.*,
                       `categoria`.`categoria`, 
                       `categoria`.`icono` 
                FROM articulo INNER JOIN categoria ON `articulo`.`categoria_id` = `categoria`.`id`
                WHERE `articulo`.`promosion`='S'
                AND `articulo`.`id`=$arti_id            
                AND `articulo`.`negocio_id`=".Auth::get("negocio_id");
        
        return $this->find_by_sql($sql);
    }
    
    public function hallarParaCarrito($arti_id) {
        $arti_id = (int)$arti_id;
        if($arti_id<=0){
            Flash::error("Promoción No identificada");
            return FALSE;
        }
        $sql =" 
                SELECT articulo.*
                FROM articulo 
                WHERE `articulo`.`id`=$arti_id            
                AND `articulo`.`negocio_id`=".Auth::get("negocio_id");
        
        return $this->find_all_by_sql($sql);
    }
    
    public function componentes($promo_id) {
        $sql =" 
                SELECT descripcion.* ,
                       linea.id as linea_id,
                       linea.cant,
                       marca.marca,
                       unidad.abreviatura,
                       categoria.categoria
                FROM descripcion INNER JOIN articulolinea linea ON linea.descripcion_id     = descripcion.id
                                 INNER JOIN articulo            ON linea.articulo_id        = articulo.id
                                 INNER JOIN marca               ON descripcion.marca_id     = marca.id
                                 INNER JOIN unidad              ON descripcion.unidad_id    = unidad.id
                                 INNER JOIN categoria           ON articulo.categoria_id = categoria.id
                WHERE linea.articulo_id  = $promo_id 
                AND  articulo.negocio_id = ".Auth::get("negocio_id")." 
                AND  articulo.promosion  ='S' 
            ";
        return $this->find_all_by_sql($sql);
    }
    
    public function comboArticulo() {
        return $this->find("promosion='N' AND activo='S' AND negocio_id=".Auth::get("negocio_id"));
    }
    public function filtrado($texto){
        $texto = addslashes($texto);
        $texto = strip_tags($texto);
        
        $sql = " 
        SELECT descripcion.id,
               descripcion.descripcion,
               descripcion.pro_pre,
               descripcion.marca_id,
               descripcion.unidad_id,
               marca.marca,
               unidad.unidad,
               unidad.abreviatura,
               categoria.categoria,
               categoria.icono

        FROM articulo INNER JOIN articulolinea ON articulolinea.articulo_id    = articulo.id
                      INNER JOIN descripcion   ON articulolinea.descripcion_id = descripcion.id
                      INNER JOIN marca         ON descripcion.marca_id         = marca.id
                      INNER JOIN unidad        ON descripcion.unidad_id        = unidad.id
                      INNER JOIN categoria     ON articulo.categoria_id        = categoria.id
        WHERE articulo.promosion='N'
        AND articulo.negocio_id = ".Auth::get("negocio_id")." 
        AND descripcion.descripcion LIKE '%$texto%' 
            ";
//       die($sql) ;
     return $this->find_all_by_sql($sql);
    }

}
