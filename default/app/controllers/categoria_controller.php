<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of categoria_controller
 *
 * @author salazarwalter
 */
class CategoriaController extends AppController {
    
    public function index($page=1) {
        $this->titulo = "CATEGORÍA";
        $this->sub = "Listado";
        $this->linkAdd = PUBLIC_PATH."../../categoria/add/";
        $this->linkEdit = PUBLIC_PATH."../../categoria/edit/";
        $this->linkDel = PUBLIC_PATH."../../categoria/del/";
        $this->linkAct = PUBLIC_PATH."../../categoria/act/";
        $prov =new Categoria();
        $this->lista = $prov->lista();
    }
    
    public function add() {
        if(Input::hasPost("a")){
            $vector = Input::post("a");
            $prov =new Categoria();
            if($prov->agregar($vector)){
                return Redirect::to("../../categoria");
            }
            
        }
        $this->titulo = "CATEGORÍA";
        $this->sub = "Agregar";
        $this->linkVolver = PUBLIC_PATH."../../categoria/";
    }
    public function edit($prov_id=0) {
        if(Input::hasPost("a")){
            $vector = Input::post("a");
            $prov_id = $vector["id"];
            $control =new Categoria();
            if($control->modificar($vector)){
                return Redirect::to("../../categoria");
            }
            
        }
        $this->titulo = "CATEGORÍA";
        $this->sub = "Modificar";
        $this->linkVolver = PUBLIC_PATH."../../categoria/";
        $c =new Categoria();
        $this->a = $c->hallar($prov_id);
    }
    public function del($control_id=0) {
        if(Input::hasPost("a")){
            $vector = Input::post("a");
            $control_id = $vector["id"];
            $control =new Categoria();
            if($control->desactivar($vector)){
                return Redirect::to("../../categoria");
            }
            
        }
        $this->titulo = "CATEGORÍA";
        $this->sub = "Desactivar";
        $this->linkVolver = PUBLIC_PATH."../../categoria/";
        $c =new Categoria();
        $this->a = $c->hallar($control_id);
    }
    public function act($control_id=0) {
        if(Input::hasPost("a")){
            $vector = Input::post("a");
            $control_id = $vector["id"];
            $control =new Categoria();
            if($control->activar($vector)){
                return Redirect::to("../../categoria");
            }
            
        }
        $this->titulo = "CATEGORÍA";
        $this->sub = "Activar";
        $this->linkVolver = PUBLIC_PATH."../../categoria/";
        $c =new Categoria();
        $this->a = $c->hallar($control_id);
    }
    
}
