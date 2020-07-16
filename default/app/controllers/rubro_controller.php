<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of rubro_controller
 *
 * @author salazarwalter
 */
class RubroController extends AppController {
    
    public function index($page=1) {
        $this->titulo = "RUBRO";
        $this->sub = "Listado";
        $this->linkAdd = PUBLIC_PATH."../../rubro/add/";
        $this->linkEdit = PUBLIC_PATH."../../rubro/edit/";
        $this->linkDel = PUBLIC_PATH."../../rubro/del/";
        $this->linkAct = PUBLIC_PATH."../../rubro/act/";
        $this->linkIcono = PUBLIC_PATH."../../rubro/icono/";
        $prov =new Rubro();
        $this->lista = $prov->lista();
        foreach ($this->lista as $value) {
            if(!$value->icono){
                $value->iconox = Rubro::$NO_IMAGE_FOLDER.Rubro::$NO_IMAGE_NAME;
            }else{
                $value->iconox = PUBLIC_PATH."files/upload/rubros/".$value->icono;
                
            }
        }
        
    }
    
    public function add() {
        if(Input::hasPost("a")){
            $vector = Input::post("a");
            $prov =new Rubro();
            if($prov->agregar($vector)){
                return Redirect::to("../../rubro");
            }
            
        }
        $this->titulo = "RUBRO";
        $this->sub = "Agregar";
        $this->linkVolver = PUBLIC_PATH."../../rubro/";
    }
    public function edit($prov_id=0) {
        if(Input::hasPost("a")){
            $vector = Input::post("a");
            $prov_id = $vector["id"];
            $control =new Rubro();
            if($control->modificar($vector)){
                return Redirect::to("../../rubro");
            }
            
        }
        $this->titulo = "RUBRO";
        $this->sub = "Modificar";
        $this->linkVolver = PUBLIC_PATH."../../rubro/";
        $c =new Rubro();
        $this->a = $c->hallar($prov_id);
    }
    public function del($control_id=0) {
        if(Input::hasPost("a")){
            $vector = Input::post("a");
            $control_id = $vector["id"];
            $control =new Rubro();
            if($control->desactivar($vector)){
                return Redirect::to("../../rubro");
            }
            
        }
        $this->titulo = "RUBRO";
        $this->sub = "Desactivar";
        $this->linkVolver = PUBLIC_PATH."../../rubro/";
        $c =new Rubro();
        $this->a = $c->hallar($control_id);
    }
    public function act($control_id=0) {
        if(Input::hasPost("a")){
            $vector = Input::post("a");
            $control_id = $vector["id"];
            $control =new Rubro();
            if($control->activar($vector)){
                return Redirect::to("../../rubro");
            }
            
        }
        $this->titulo = "RUBRO";
        $this->sub = "Activar";
        $this->linkVolver = PUBLIC_PATH."../../rubro/";
        $c =new Rubro();
        $this->a = $c->hallar($control_id);
    }
    
  public function icono($rubro_id=0)
    {
        if(Input::hasPost("a")){
            $vector= Input::post("a");
            $obj=new Rubro();
            
            if($obj->icono($vector)){
                Redirect::to("../../rubro");
            }
        }
        $mod=new rubro();
        $this->a=$mod->hallar($rubro_id);
//        print_r($this->a);
//        die();
        $this->titulo = "RUBRO";
        $this->sub = "Ícono";
        $this->linkVolver=PUBLIC_PATH."../../rubro";
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
            $c =new Rubro();
            $this->lista = $c->lista_x_rol($this->rol_id);
        }
//        print_r($this->lista);
//        die();
        
    }
}
