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
class Pedido extends ActiveRecord{
    public static $ESTADO=array("P"=>"Pedido","L"=>"Preparado","C"=>"Cargado","E"=>"Entregado","X"=>"Cancelado");
    
    public function pedidosPendientes() {
        $sql =" 
                SELECT pedido.*,
                       `cliente`.`cli_nom`, 
                       `cliente`.`cli_cel`, 
                       `cliente`.`cli_dom`,
                       `cliente`.`cli_mail`,
                       `cliente`.`usuario_id`,
                       `cliente`.`localidad_id`,
                       `cliente`.`negocio`,
                       `cliente`.`cli_dni`,
                       `cliente`.`cli_neg`,
                       `cliente`.`usuario_id`,
                       `localidad`.`loc`,
                       `provincia`.`prov`,
                       `negocio`.`neg_nom`,
                       `negocio`.`neg_dom`,
                       `negocio`.`neg_tel`,
                       `negocio`.`neg_mail`,
                       `negocio`.`horario`


                FROM `pedido` INNER JOIN `cliente`   ON pedido.`cliente_id`        = `cliente`.`id`
                              INNER JOIN `localidad` ON `cliente`.`localidad_id`   = `localidad`.`id`
                              INNER JOIN `provincia` ON `localidad`.`provincia_id` = `provincia`.`id`
                              INNER JOIN `negocio`   ON `pedido`.`negocio_id`      = `negocio`.`id`
                WHERE `pedido`.`estado` IN ('P','L','C')
                AND `cliente`.usuario_id=".Auth::get("id");
        return $this->find_all_by_sql($sql);
    }
    
    public function initialize() {
        
    }
}
