<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of promosion_controller
 *
 * @author salazarwalter
 */
class PromosionController extends AppController {
    
    public function index($page=1) {
        $this->titulo = "PROMOCION";
        $this->sub = "Listado";
        $this->linkAdd = PUBLIC_PATH."../../promosion/add/";
        $this->linkEdit = PUBLIC_PATH."../../promosion/edit/";
        $this->linkDel = PUBLIC_PATH."../../promosion/del/";
        $this->linkAct = PUBLIC_PATH."../../promosion/act/";
        $this->linkArticulos = PUBLIC_PATH."../../promosion/componentes/";
        $prov =new Articulo();
        $this->lista = $prov->listaPromosiones();
        $this->art = $prov;
    }
    
    public function componentes($promo_id) {
        
        $this->titulo = "PROMOCION";
        $this->sub = "Componentes";
        $this->linkVolver = PUBLIC_PATH."../../promosion/";
        $p=new Articulo();
        $this->a = $p->hallarPromosion($promo_id);
        $this->lista = $p->componentes($promo_id);
    }
    
    public function add() {
        if(Input::hasPost("a")){
            $vector = Input::post("a");
            $prov =new Articulo();
            if($prov->agregarPromosion($vector)){
                return Redirect::to("../../promosion");
            }
            
        }
        $this->titulo = "PROMOCION";
        $this->sub = "Agregar";
        $this->linkVolver = PUBLIC_PATH."../../promosion/";
    }
    
    public function edit($arti_id=0) {
        if(Input::hasPost("a")){
            $vector = Input::post("a");
            $arti_id = $vector["id"];
            $control =new Articulo();
            if($control->modificarPromosion($vector)){
                return Redirect::to("../../promosion");
            }
            
        }
        $this->titulo = "PROMOCION";
        $this->sub = "Modificar";
        $this->linkVolver = PUBLIC_PATH."../../promosion/";
        $c =new Articulo();
        $this->a = $c->hallarPromosion($arti_id);
    }
    
    public function del($control_id=0) {
        if(Input::hasPost("a")){
            $vector = Input::post("a");
            $control_id = $vector["id"];
            $control =new Articulo();
            if($control->desactivarPromosion($vector)){
                return Redirect::to("../../promosion");
            }
            
        }
        $this->titulo = "PROMOCION";
        $this->sub = "Desactivar";
        $this->linkVolver = PUBLIC_PATH."../../promosion/";
        $c =new Articulo();
        $this->a = $c->hallarPromosion($control_id);
    }
    
    public function act($control_id=0) {
        if(Input::hasPost("a")){
            $vector = Input::post("a");
            $control_id = $vector["id"];
            $control =new Articulo();
            if($control->activarPromosion($vector)){
                return Redirect::to("../../promosion");
            }
            
        }
        $this->titulo = "PROMOCION";
        $this->sub = "Activar";
        $this->linkVolver = PUBLIC_PATH."../../promosion/";
        $c =new Articulo();
        $this->a = $c->hallarPromosion($control_id);
    }
    
    public function agregarcompo() {
        View::template(NULL);
        if(Input::hasPost("idx")){
            $descrpcion_id   = (int)Input::post("idx");
            $cant            = (int)Input::post("cant");
            $articulo_id     = (int)Input::post("id_art");
            if($descrpcion_id<=0 || $cant<=0 || $articulo_id<=0){
                die("La descripcion, el articulo y la cantidad deben ser numericas");
            }
            $linea = new Articulolinea();
            $linea->descripcion_id = $descrpcion_id;
            $linea->articulo_id    = $articulo_id ;
            $linea->cant           = $cant ;
            if(!$linea->create()){
                echo "Error. No se pudo Guardar";
            }
            die($linea->id."");
        }
        die();
    }
    
    public function quitar() {
        View::template(NULL);
        if(Input::hasPost("idx")){
            $linea_id = (int) Input::post("idx");
            $obj =new Articulolinea();
            $obj->borrar($linea_id);
        }
        die();
        
    }
    
    // para cliente Negocio
    public function promosiones() {
        $this->titulo = "PROMOCIONES";
        $this->sub = "Listado";
        $this->linkAdd = PUBLIC_PATH."../../promosion/add/";
        $this->linkEdit = PUBLIC_PATH."../../promosion/edit/";
        $this->linkDel = PUBLIC_PATH."../../promosion/del/";
        $this->linkAct = PUBLIC_PATH."../../promosion/act/";
        $this->linkAlCarrito = PUBLIC_PATH."../../promosion/alcarrito/";
        $prov =new Articulo();
        $this->lista = $prov->listaPromosionesParaCliente();
        $this->art = $prov;        
    }
    
    public function alcarrito($arti_id=0) {
        $arti_id =(int)$arti_id;
        if($arti_id>0){
            $art = new Articulo();
            $h =$art->hallarParaCarrito($arti_id);
            if(count($h)==1){
                Carrito::add($arti_id);
            }
//            print_r(Carrito::$CARRITO);
//            die();
            
        }
        Redirect::to("../../promosion/promosiones");
    }
    
 public function micarrito() 
    {
        $this->titulo       = "MI CARRITO";
        $this->sub          = "Detalle";
        $this->linkMas      = PUBLIC_PATH."../../promosion/mas/";
        $this->linkMenos    = PUBLIC_PATH."../../promosion/menos/";
        $this->linkBorrar   = PUBLIC_PATH."../../promosion/borrar/";
        $this->linkGuardar  = PUBLIC_PATH."../../promosion/registrarcarrito/";    
    }    
    
    public function mas($arti_id) {
        $art = new Articulo();
            $h =$art->hallarParaCarrito($arti_id);
            if(count($h)==1){
                Carrito::add($arti_id);
            }

        Redirect::to("../../promosion/micarrito");
    }
    public function menos($arti_id) {
        $art = new Articulo();
            $h =$art->hallarParaCarrito($arti_id);
            if(count($h)==1){
                Carrito::unoMenos($arti_id);
            }

        Redirect::to("../../promosion/micarrito");
    }

    public function borrar($arti_id) {
        $art = new Articulo();
            $h =$art->hallarParaCarrito($arti_id);
            if(count($h)==1){
                Carrito::quitar($arti_id);
            }

        Redirect::to("../../promosion/micarrito");
    }
    public function registrarcarrito() {
        
        Redirect::to("../../promosion/micarrito");
    }
    
}
