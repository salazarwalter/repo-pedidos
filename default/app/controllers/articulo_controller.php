<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of articulo_controller
 *
 * @author salazarwalter
 */
class ArticuloController extends AppController {
    
    public function index($page=1) {
        $this->titulo = "ARTÍCULOS";
        $this->sub = "Listado";
        $this->linkAdd = PUBLIC_PATH."../../articulo/add/";
        $this->linkEdit = PUBLIC_PATH."../../articulo/edit/";
        $this->linkDel = PUBLIC_PATH."../../articulo/del/";
        $this->linkAct = PUBLIC_PATH."../../articulo/act/";
        $prov =new Articulo();
        $this->lista = $prov->listaArticulos();
    }
    
    public function add() {
        if(Input::hasPost("a")){
            $vector = Input::post("a");
            $prov =new Articulo();
            if($prov->agregarArticulo($vector)){
                return Redirect::to("../../articulo");
            }
            
        }
        $this->titulo = "ARTÍCULOS";
        $this->sub = "Agregar";
        $this->linkVolver = PUBLIC_PATH."../../articulo/";
    }
    public function edit($arti_id=0) {
        if(Input::hasPost("a")){
            $vector = Input::post("a");
            $arti_id = $vector["id"];
            $control =new Articulo();
            if($control->modificarArticulo($vector)){
                return Redirect::to("../../articulo");
            }
            
        }
        $this->titulo = "ARTÍCULOS";
        $this->sub = "Modificar";
        $this->linkVolver = PUBLIC_PATH."../../articulo/";
        $c =new Articulo();
        $this->a = $c->hallarArticulos($arti_id);
    }
    public function del($control_id=0) {
        if(Input::hasPost("a")){
            $vector = Input::post("a");
            $control_id = $vector["id"];
            $control =new Articulo();
            if($control->desactivarArticulo($vector)){
                return Redirect::to("../../articulo");
            }
            
        }
        $this->titulo = "ARTÍCULOS";
        $this->sub = "Desactivar";
        $this->linkVolver = PUBLIC_PATH."../../articulo/";
        $c =new Articulo();
        $this->a = $c->hallarArticulos($control_id);
    }
    public function act($control_id=0) {
        if(Input::hasPost("a")){
            $vector = Input::post("a");
            $control_id = $vector["id"];
            $control =new Articulo();
            if($control->activarArticulo($vector)){
                return Redirect::to("../../articulo");
            }
            
        }
        $this->titulo = "ARTÍCULOS";
        $this->sub = "Activar";
        $this->linkVolver = PUBLIC_PATH."../../articulo/";
        $c =new Articulo();
        $this->a = $c->hallarArticulos($control_id);
    }
    
    public function filtrado() {
        View::template(NULL);
        $this->lista=NULL;
        if(Input::hasPost("texto")){
            $texto=Input::post("texto");
            $a = new Articulo();
            $this->lista = $a->filtrado($texto);
        }
    }
}
