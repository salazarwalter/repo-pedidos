<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clientesneg_controller
 *
 * @author salazarwalter
 */
class ClientesnegController extends AppController {
    
    public function index($page=1) {
        $this->titulo = "NEGOCIO";
        $this->sub = "Listado";
        $this->linkAdd = PUBLIC_PATH."../../clientesneg/add/";
        $this->linkEdit = PUBLIC_PATH."../../clientesneg/edit/";
        $this->linkDel = PUBLIC_PATH."../../clientesneg/del/";
        $this->linkAct = PUBLIC_PATH."../../clientesneg/act/";
        $prov =new Cliente();
        $this->lista = $prov->lista();
    }
    
    public function add() {
        if(Input::hasPost("a")){
            $vector = Input::post("a");
            $prov =new Cliente();
            if($prov->agregar($vector)){
                return Redirect::to("../../clientesneg");
            }
            
        }
        $this->titulo = "PROVINCIA";
        $this->sub = "Agregar";
        $this->linkVolver = PUBLIC_PATH."../../clientesneg/";
    }
    
    public function edit($cliente_id=0) {
        if(Input::hasPost("a")){
            $vector = Input::post("a");
            $cliente_id = $vector["id"];
            $control =new Cliente();
            if($control->modificar($vector)){
                return Redirect::to("../../clientesneg");
            }
            
        }
        $this->titulo = "NEGOCIO";
        $this->sub = "Modificar";
        $this->linkVolver = PUBLIC_PATH."../../clientesneg/";
        $c =new Cliente();
        $this->a = $c->hallar($cliente_id);
        $this->a->usu = base64_decode($this->a->usu);
    }
    
    public function del($cli_id=0) {
        if(Input::hasPost("a")){
            $vector = Input::post("a");
            $cli_id = $vector["id"];
            $control =new Cliente();
            $h=new Cliente();
            $x= $h->hallar($cli_id);
            $vector["id"]= $x->usuario_id;
            if($control->desactivar($vector)){
                return Redirect::to("../../clientesneg");
            }
            
        }
        $this->titulo = "PROVINCIA";
        $this->sub = "Desactivar";
        $this->linkVolver = PUBLIC_PATH."../../clientesneg/";
        $c =new Cliente();
        $this->a = $c->hallar($cli_id);
        $this->a->usu = base64_decode($this->a->usu);
    }
    
    public function act($cli_id=0) {
        if(Input::hasPost("a")){
            $vector = Input::post("a");
            $cli_id = $vector["id"];
            $cliente =new Cliente();
            $h=new Cliente();
            $x= $h->hallar($cli_id);
            $vector["id"]= $x->usuario_id;
            if($cliente->activar($vector)){
                return Redirect::to("../../clientesneg");
            }
            
        }
        $this->titulo = "PROVINCIA";
        $this->sub = "Activar";
        $this->linkVolver = PUBLIC_PATH."../../clientesneg/";
        $c =new Cliente();
        $this->a = $c->hallar($cli_id);
        $this->a->usu = base64_decode($this->a->usu);
    }
    
    public function panel() 
    {
        $this->titulo = "RUBROS";
        $this->sub = "Seleccionar";
        $r=new Rubro();
        $this->lista = $r->listaRubros();
        foreach ($this->lista as $value) {
            if(!$value->icono){
                $value->iconox = Rubro::$NO_IMAGE_FOLDER.Rubro::$NO_IMAGE_NAME;
            }else{
                $value->iconox = PUBLIC_PATH."files/upload/rubros/".$value->icono;
                
            }
        }
        $this->linkEmpresas=PUBLIC_PATH."../../clientesneg/empresas/";
    }    
    
    public function empresas($rubro_id) 
    {
        $this->titulo = "NEGOCIOS";
        $this->sub = "Seleccionar";
        $r=new Rubro();
        $this->a = $r->hallar($rubro_id);
        $n =new Negocio();
        $this->lista = $n->listaNegociosXRubro($rubro_id);
        $this->linkVolver=PUBLIC_PATH."../../clientesneg/panel/";
        $this->linkSig=PUBLIC_PATH."../../clientesneg/promosiones/";
    }
        
}
