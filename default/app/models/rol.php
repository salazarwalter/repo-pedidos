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
class Rol extends ActiveRecord{
    
    public function initialize() {
        
    }
    public function combo() {
        return $this->find("activo='S' ");
    }
    public function lista() {
        return $this->find();
    }
}
