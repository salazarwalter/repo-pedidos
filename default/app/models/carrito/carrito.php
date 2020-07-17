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
    
    public static function get(){
        if(Session::has(Carrito::$CARRITO_nombre)){
            Carrito::$CARRITO = Session::get(Carrito::$CARRITO_nombre);
        }
      return Carrito::$CARRITO;  
    }
    
    public static function add($id_art){
        if(Session::has(Carrito::$CARRITO_nombre)){
            Carrito::$CARRITO = Session::get(Carrito::$CARRITO_nombre);
        }
        if (array_key_exists($id_art, Carrito::$CARRITO)) {
            Carrito::$CARRITO[$id_art]++;
        }else{
            Carrito::$CARRITO[$id_art] = 1;
        }
        
       Session::set(Carrito::$CARRITO_nombre, Carrito::$CARRITO);
   }
   
   public static function unoMenos($id_art){
        if(Session::has(Carrito::$CARRITO_nombre)){
            Carrito::$CARRITO = Session::get(Carrito::$CARRITO_nombre);
        }
        if (array_key_exists($id_art, Carrito::$CARRITO)) {
            if(Carrito::$CARRITO[$id_art]>0) {
                Carrito::$CARRITO[$id_art]--;
            }
        }
        
       Session::set(Carrito::$CARRITO_nombre, Carrito::$CARRITO);
   }
   public static function unoMas($id_art){
        if(Session::has(Carrito::$CARRITO_nombre)){
            Carrito::$CARRITO = Session::get(Carrito::$CARRITO_nombre);
        }
        if (array_key_exists($id_art, Carrito::$CARRITO)) {
                Carrito::$CARRITO[$id_art]++;
        }
        
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
