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
class LocaladminController extends AppController {
    
    public function panel($page=1) {
        $this->titulo = "PANEL";
        $this->sub = "Administración";
        $ped=new Pedido();
        $this->cant_ped = $ped->count("negocio_id =".Auth::get("negocio_id")." AND estado='P'");
        $pro = new Articulo();
        $this->cant_pro = $pro->count("negocio_id =".Auth::get("negocio_id")." AND promosion='S' AND activo='S' ");
        $this->cant_art = $pro->count("negocio_id =".Auth::get("negocio_id")." AND promosion='N' AND activo='S'");
        $mar =new Marca();
        $this->cant_mar =$mar->count("negocio_id =".Auth::get("negocio_id")." AND activo='S'");
//        $this->linkAdd = PUBLIC_PATH."../../accion/add/";
//        $this->linkEdit = PUBLIC_PATH."../../accion/edit/";
//        $this->linkDel = PUBLIC_PATH."../../accion/del/";
//        $this->linkAct = PUBLIC_PATH."../../accion/act/";
//        $con =new Accion();
//        $this->lista = $con->lista();
        $e =new Negocio();
        $this->a = $e->find_by_id(Auth::get("negocio_id"));
    }
    public function perfil() 
    {
        if(Input::hasPost("a")){
            $vec=Input::post("a");
            $adm =new Administrador();
            if($adm->perfil($vec)){
                Flash::valid("Datos Personales Actualizados");
                Redirect::to("../../localadmin/perfil");
            }
        }
        $this->titulo = "ADMINISTRADOR";
        $this->sub = "Datos Personales";
        $a =new Administrador();
        $this->a = $a->find_first("usuario_id=".Auth::get("id"));
    }    
/*    
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
    
    */
}
