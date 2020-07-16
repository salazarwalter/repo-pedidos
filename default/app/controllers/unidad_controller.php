<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of unidad_controller
 *
 * @author salazarwalter
 */
class UnidadController extends AppController {
    
    public function index($page=1) {
        $this->titulo = "UNIDAD";
        $this->sub = "Listado";
        $this->linkAdd = PUBLIC_PATH."../../unidad/add/";
        $this->linkEdit = PUBLIC_PATH."../../unidad/edit/";
        $this->linkDel = PUBLIC_PATH."../../unidad/del/";
        $this->linkAct = PUBLIC_PATH."../../unidad/act/";
        $prov =new Unidad();
        $this->lista = $prov->lista();
    }
    
    public function add() {
        if(Input::hasPost("a")){
            $vector = Input::post("a");
            $prov =new Unidad();
            if($prov->agregar($vector)){
                return Redirect::to("../../unidad");
            }
            
        }
        $this->titulo = "UNIDAD";
        $this->sub = "Agregar";
        $this->linkVolver = PUBLIC_PATH."../../unidad/";
    }
    public function edit($prov_id=0) {
        if(Input::hasPost("a")){
            $vector = Input::post("a");
            $prov_id = $vector["id"];
            $control =new Unidad();
            if($control->modificar($vector)){
                return Redirect::to("../../unidad");
            }
            
        }
        $this->titulo = "UNIDAD";
        $this->sub = "Modificar";
        $this->linkVolver = PUBLIC_PATH."../../unidad/";
        $c =new Unidad();
        $this->a = $c->hallar($prov_id);
    }
    public function del($control_id=0) {
        if(Input::hasPost("a")){
            $vector = Input::post("a");
            $control_id = $vector["id"];
            $control =new Unidad();
            if($control->desactivar($vector)){
                return Redirect::to("../../unidad");
            }
            
        }
        $this->titulo = "UNIDAD";
        $this->sub = "Desactivar";
        $this->linkVolver = PUBLIC_PATH."../../unidad/";
        $c =new Unidad();
        $this->a = $c->hallar($control_id);
    }
    public function act($control_id=0) {
        if(Input::hasPost("a")){
            $vector = Input::post("a");
            $control_id = $vector["id"];
            $control =new Unidad();
            if($control->activar($vector)){
                return Redirect::to("../../unidad");
            }
            
        }
        $this->titulo = "UNIDAD";
        $this->sub = "Activar";
        $this->linkVolver = PUBLIC_PATH."../../unidad/";
        $c =new Unidad();
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
            $c =new Unidad();
            $this->lista = $c->lista_x_rol($this->rol_id);
        }
//        print_r($this->lista);
//        die();
        
    }
}
