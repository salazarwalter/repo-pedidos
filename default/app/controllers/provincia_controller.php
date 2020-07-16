<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of provincia_controller
 *
 * @author salazarwalter
 */
class ProvinciaController extends AppController {
    
    public function index($page=1) {
        $this->titulo = "PROVINCIA";
        $this->sub = "Listado";
        $this->linkAdd = PUBLIC_PATH."../../provincia/add/";
        $this->linkEdit = PUBLIC_PATH."../../provincia/edit/";
        $this->linkDel = PUBLIC_PATH."../../provincia/del/";
        $this->linkAct = PUBLIC_PATH."../../provincia/act/";
        $prov =new Provincia();
        $this->lista = $prov->lista();
    }
    
    public function add() {
        if(Input::hasPost("a")){
            $vector = Input::post("a");
            $prov =new Provincia();
            if($prov->agregar($vector)){
                return Redirect::to("../../provincia");
            }
            
        }
        $this->titulo = "PROVINCIA";
        $this->sub = "Agregar";
        $this->linkVolver = PUBLIC_PATH."../../provincia/";
    }
    public function edit($prov_id=0) {
        if(Input::hasPost("a")){
            $vector = Input::post("a");
            $prov_id = $vector["id"];
            $control =new Provincia();
            if($control->modificar($vector)){
                return Redirect::to("../../provincia");
            }
            
        }
        $this->titulo = "PROVINCIA";
        $this->sub = "Modificar";
        $this->linkVolver = PUBLIC_PATH."../../provincia/";
        $c =new Provincia();
        $this->a = $c->hallar($prov_id);
    }
    public function del($control_id=0) {
        if(Input::hasPost("a")){
            $vector = Input::post("a");
            $control_id = $vector["id"];
            $control =new Provincia();
            if($control->desactivar($vector)){
                return Redirect::to("../../provincia");
            }
            
        }
        $this->titulo = "PROVINCIA";
        $this->sub = "Desactivar";
        $this->linkVolver = PUBLIC_PATH."../../provincia/";
        $c =new Provincia();
        $this->a = $c->hallar($control_id);
    }
    public function act($control_id=0) {
        if(Input::hasPost("a")){
            $vector = Input::post("a");
            $control_id = $vector["id"];
            $control =new Provincia();
            if($control->activar($vector)){
                return Redirect::to("../../provincia");
            }
            
        }
        $this->titulo = "PROVINCIA";
        $this->sub = "Activar";
        $this->linkVolver = PUBLIC_PATH."../../provincia/";
        $c =new Provincia();
        $this->a = $c->hallar($control_id);
    }
    
    /*+++++++++++++++++++++ AJAX ++++++++++++++++++++++++++++++++*/
    /*+++++++++++++++++++++ AJAX ++++++++++++++++++++++++++++++++*/
    /*+++++++++++++++++++++ AJAX ++++++++++++++++++++++++++++++++*/
    public function get_por_rol_id() {
        $this->lista =FALSE;
        View::template(NULL);
        $this->control_id=FALSE;
        if(Input::hasPost("rol_id")){
            $this->rol_id     = Input::post("rol_id");
            $this->control_id = Input::post("control_id");
            $c =new Provincia();
            $this->lista = $c->lista_x_rol($this->rol_id);
        }
//        print_r($this->lista);
//        die();
        
    }
}
