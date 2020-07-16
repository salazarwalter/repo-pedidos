<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of localidad_controller
 *
 * @author salazarwalter
 */
class LocalidadController extends AppController {
    
    public function index($page=1) {
        $this->titulo = "LOCALIDAD";
        $this->sub = "Listado";
        $this->linkAdd = PUBLIC_PATH."../../localidad/add/";
        $this->linkEdit = PUBLIC_PATH."../../localidad/edit/";
        $this->linkDel = PUBLIC_PATH."../../localidad/del/";
        $this->linkAct = PUBLIC_PATH."../../localidad/act/";
        $con =new Localidad();
        $this->lista = $con->lista();
    }
    public function add() {
        if(Input::hasPost("a")){
            $vector = Input::post("a");
            $control =new Localidad();
            if($control->agregar($vector)){
                return Redirect::to("../../localidad");
            }
            
        }
        $this->titulo = "LOCALIDAD";
        $this->sub = "Agregar";
        $this->linkVolver = PUBLIC_PATH."../../localidad/";
    }
    public function edit($loca_id=0) {
        if(Input::hasPost("a")){
            $vector = Input::post("a");
            $loca_id = $vector["id"];
            $control =new Localidad();
            if($control->modificar($vector)){
                return Redirect::to("../../localidad");
            }
            
        }
        $this->titulo = "LOCALIDAD";
        $this->sub = "Modificar";
        $this->linkVolver = PUBLIC_PATH."../../localidad/";
        $c =new Localidad();
        $this->a = $c->hallar($loca_id);
    }
    public function del($loca_id=0) {
        if(Input::hasPost("a")){
            $vector = Input::post("a");
            $loca_id = $vector["id"];
            $control =new Localidad();
            if($control->desactivar($vector)){
                return Redirect::to("../../localidad");
            }
            
        }
        $this->titulo = "LOCALIDAD";
        $this->sub = "Desactivar";
        $this->linkVolver = PUBLIC_PATH."../../localidad/";
        $c =new Localidad();
        $this->a = $c->hallar($loca_id);
    }
    public function act($loca_id=0) {
        if(Input::hasPost("a")){
            $vector = Input::post("a");
            $loca_id = $vector["id"];
            $control =new Localidad();
            if($control->activar($vector)){
                return Redirect::to("../../localidad");
            }
            
        }
        $this->titulo = "LOCALIDAD";
        $this->sub = "Activar";
        $this->linkVolver = PUBLIC_PATH."../../localidad/";
        $c =new Localidad();
        $this->a = $c->hallar($loca_id);
    }
    /* ++++++++++++++++++++++++++ AJAX ++++++++++++++++++++++++++++*/
    /* ++++++++++++++++++++++++++ AJAX ++++++++++++++++++++++++++++*/
    /* ++++++++++++++++++++++++++ AJAX ++++++++++++++++++++++++++++*/
    public function lista_por_provincia() {
        $this->lista=NULL;
        $this->loc_id =0;
        View::template(NULL);
        if(Input::hasPost("prov_id")){
            $prov_id = Input::post("prov_id");
            $this->loc_id = Input::post("loc_id");
            $loc = new Localidad();
            $this->lista = $loc->lista_x_provincia($prov_id);
        }
    }
}
