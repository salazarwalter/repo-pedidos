<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of controlador_controller
 *
 * @author salazarwalter
 */
class ControladorController extends AppController {
    
    public function index($page=1) {
        $this->titulo = "CONTROLADOR";
        $this->sub = "Listado";
        $this->linkAdd = PUBLIC_PATH."../../controlador/add/";
        $this->linkEdit = PUBLIC_PATH."../../controlador/edit/";
        $this->linkDel = PUBLIC_PATH."../../controlador/del/";
        $this->linkAct = PUBLIC_PATH."../../controlador/act/";
        $con =new Controlador();
        $this->lista = $con->lista();
    }
    public function add() {
        if(Input::hasPost("a")){
            $vector = Input::post("a");
            $control =new Controlador();
            if($control->agregar($vector)){
                return Redirect::to("../../controlador");
            }
            
        }
        $this->titulo = "CONTROLADOR";
        $this->sub = "Agregar";
        $this->linkVolver = PUBLIC_PATH."../../controlador/";
    }
    public function edit($control_id=0) {
        if(Input::hasPost("a")){
            $vector = Input::post("a");
            $control_id = $vector["id"];
            $control =new Controlador();
            if($control->modificar($vector)){
                return Redirect::to("../../controlador");
            }
            
        }
        $this->titulo = "CONTROLADOR";
        $this->sub = "Modificar";
        $this->linkVolver = PUBLIC_PATH."../../controlador/";
        $c =new Controlador();
        $this->a = $c->hallar($control_id);
    }
    public function del($control_id=0) {
        if(Input::hasPost("a")){
            $vector = Input::post("a");
            $control_id = $vector["id"];
            $control =new Controlador();
            if($control->desactivar($vector)){
                return Redirect::to("../../controlador");
            }
            
        }
        $this->titulo = "CONTROLADOR";
        $this->sub = "Desactivar";
        $this->linkVolver = PUBLIC_PATH."../../controlador/";
        $c =new Controlador();
        $this->a = $c->hallar($control_id);
    }
    public function act($control_id=0) {
        if(Input::hasPost("a")){
            $vector = Input::post("a");
            $control_id = $vector["id"];
            $control =new Controlador();
            if($control->activar($vector)){
                return Redirect::to("../../controlador");
            }
            
        }
        $this->titulo = "CONTROLADOR";
        $this->sub = "Activar";
        $this->linkVolver = PUBLIC_PATH."../../controlador/";
        $c =new Controlador();
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
            $this->modulo_id  = Input::post("modulo_id");
            $c =new Controlador();
            $this->lista = $c->lista_x_rol($this->rol_id,$this->modulo_id);
        }
//        print_r($this->lista);
//        die();
        
    }
}
