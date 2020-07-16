<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of accion_controller
 *
 * @author salazarwalter
 */
class AccionController extends AppController {
    
    public function index($page=1) {
        $this->titulo = "ACCESO";
        $this->sub = "Listado";
        $this->linkAdd = PUBLIC_PATH."../../accion/add/";
        $this->linkEdit = PUBLIC_PATH."../../accion/edit/";
        $this->linkDel = PUBLIC_PATH."../../accion/del/";
        $this->linkAct = PUBLIC_PATH."../../accion/act/";
        $con =new Accion();
        $this->lista = $con->lista();
    }
    public function add() {
        if(Input::hasPost("a")){
            $vector = Input::post("a");
            $control =new Accion();
            if($control->agregar($vector)){
                return Redirect::to("../../accion");
            }
            
        }
        $this->titulo = "ACCESO";
        $this->sub = "Agregar";
        $this->linkVolver = PUBLIC_PATH."../../accion/";
    }
    public function edit($control_id=0) {
        if(Input::hasPost("a")){
            $vector = Input::post("a");
            $control_id = $vector["id"];
            $control =new Accion();
            if($control->modificar($vector)){
                return Redirect::to("../../accion");
            }
            
        }
        $this->titulo = "ACCESO";
        $this->sub = "Modificar";
        $this->linkVolver = PUBLIC_PATH."../../accion/";
        $c =new Accion();
        $this->a = $c->hallar($control_id);
        
//        print_r($this->a);
//        die();
    }
    public function del($control_id=0) {
        if(Input::hasPost("a")){
            $vector = Input::post("a");
            $control_id = $vector["id"];
            $control =new Accion();
            if($control->desactivar($vector)){
                return Redirect::to("../../accion");
            }
            
        }
        $this->titulo = "ACCESO";
        $this->sub = "Desactivar";
        $this->linkVolver = PUBLIC_PATH."../../accion/";
        $c =new Accion();
        $this->a = $c->hallar($control_id);
    }
    public function act($control_id=0) {
        if(Input::hasPost("a")){
            $vector = Input::post("a");
            $control_id = $vector["id"];
            $control =new Accion();
            if($control->activar($vector)){
                return Redirect::to("../../accion");
            }
            
        }
        $this->titulo = "ACCESO";
        $this->sub = "Activar";
        $this->linkVolver = PUBLIC_PATH."../../accion/";
        $c =new Accion();
        $this->a = $c->hallar($control_id);
    }
}
