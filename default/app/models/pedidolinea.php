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
class Pedidolinea extends ActiveRecord{
    
    public function initialize() {
        
    }

    public function detalle($pedido_d) {
        $sql =" 
            SELECT `pedidolinea`.*,
                   `articulo`.`art_nom`,
                   `articulo`.`art_pre`,
                   `articulo`.`promosion`,
                   `articulo`.`publicado`,
                   `articulo`.`art_cod`,
                   `articulo`.`barra`,
                   `categoria`.`categoria`
            FROM `pedidolinea` INNER JOIN `articulo`  ON `pedidolinea`.`articulo_id` = `articulo`.`id`
                               INNER JOIN `categoria` ON `articulo`.`categoria_id`   = `categoria`.`id` 
            WHERE `pedidolinea`.`pedido_id`=$pedido_d
            ";
        return $this->find_all_by_sql($sql);
    }    
}
