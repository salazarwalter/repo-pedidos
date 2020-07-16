<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Carrito
 *
 * @author salazarwalter
 */
class Carrito {
    public static $CARRITO=[];
    public static $CARRITO_nombre="carrito-413";
    
    public static function add($h){
        if(Session::has(Carrito::$CARRITO_nombre)){
            Carrito::$CARRITO = Session::get(Carrito::$CARRITO_nombre);
//            print_r(Carrito::$CARRITO);
//            die();
        }

        
        array_push(Carrito::$CARRITO, $h);
        Session::set(Carrito::$CARRITO_nombre, Carrito::$CARRITO);
        
   }
   public static function size(){
        if(Session::has(Carrito::$CARRITO_nombre)){
            Carrito::$CARRITO = Session::get(Carrito::$CARRITO_nombre);
            return count(Carrito::$CARRITO);
        }
        return 0;
   }
   public static function clearAll() {
        if(Session::has(Carrito::$CARRITO_nombre)){
            Session::delete(Carrito::$CARRITO_nombre);
        }
       Carrito::$CARRITO=[];
   }
}
