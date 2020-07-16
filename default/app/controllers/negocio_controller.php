<?php

/**
 * Controller por defecto si no se usa el routes
 *
 */
class NegocioController extends AppController
{

    public function index()
    {
        $this->titulo ="NEGOCIO";
        $this->sub ="Listado";
        $this->linkAdd=PUBLIC_PATH."../../negocio/add/";
        $this->linkEdit=PUBLIC_PATH."../../negocio/edit/";
        $this->linkDel=PUBLIC_PATH."../../negocio/del/";
        $this->linkAct=PUBLIC_PATH."../../negocio/act/";
        $neg = new Negocio();
        $this->lista = $neg->lista();
    }
    public function add()
    {
        if(Input::hasPost("a")){
            $vec= Input::post("a");
            $neg =new Negocio();
            if($neg->agregar($vec)){
                Redirect::to("../../negocio/");
            }
        }
        $this->titulo ="NEGOCIOS";
        $this->sub ="Agregar";
        $this->linkVolver=PUBLIC_PATH."../../negocio/";
    }
    public function edit($nego_id=0)
    {
        if(Input::hasPost("a")){
            $vec= Input::post("a");
            $neg =new Negocio();
            if($neg->modificar($vec)){
                Redirect::to("../../negocio/");
            }
        }
        $neg =new Negocio();
        $this->a = $neg->hallar($nego_id);
        $this->titulo ="NEGOCIO";
        $this->sub ="Modificar";
        $this->linkVolver=PUBLIC_PATH."../../negocio/";
    }
    public function del($nego_id=0)
    {
        if(Input::hasPost("a")){
            $vec= Input::post("a");
            $neg =new Negocio();
            if($neg->desactivar($vec)){
                Redirect::to("../../negocio/");
            }
        }
        $neg =new Negocio();
        $this->a = $neg->hallar($nego_id);
        $this->titulo ="NEGOCIO";
        $this->sub ="Desactivar";
        $this->linkVolver=PUBLIC_PATH."../../negocio/";
    }
    public function act($nego_id=0)
    {
        if(Input::hasPost("a")){
            $vec= Input::post("a");
            $neg =new Negocio();
            if($neg->activar($vec)){
                Redirect::to("../../negocio/");
            }
        }
        $neg =new Negocio();
        $this->a = $neg->hallar($nego_id);
        $this->titulo ="NEGOCIO";
        $this->sub ="Activar";
        $this->linkVolver=PUBLIC_PATH."../../negocio/";
    }

    public function general() {
        if(Input::hasPost("a")){
            $vec = Input::post("a");
            $n=new Negocio();
            if($n->general($vec)){
                Flash::valid("Datos Satisfactoriamente Actualizados");  
                Redirect::to("../../negocio/general");
            }
        }
        $this->titulo ="NEGOCIO";
        $this->sub ="Datos Generales";
        $n =new Negocio();
        $this->a = $n->hallar(Auth::get("negocio_id"));
    }
    public function domicilio() {
        if(Input::hasPost("a")){
            $vec = Input::post("a");
            $n=new Negocio();
            if($n->domicilio($vec)){
                Flash::valid("Domicilio Satisfactoriamente Actualizado");  
                Redirect::to("../../negocio/domicilio");
            }
        }
        $this->titulo ="NEGOCIO";
        $this->sub ="Domicilio";
        $n =new Negocio();
        $this->a = $n->hallar(Auth::get("negocio_id"));
//        print_r($this->a);
//        die();
    }
    
    public function busqueda() {
        if(Input::hasPost("a")){
            $vec = Input::post("a");
            $n=new Negocio();
            if($n->busqueda($vec)){
                Flash::valid("Horarios Satisfactoriamente Actualizado");  
                Redirect::to("../../negocio/busqueda");
            }
        }
        $this->titulo ="NEGOCIO";
        $this->sub ="Horarios";
        $n =new Negocio();
        $this->a = $n->hallar(Auth::get("negocio_id"));
    }
    
}
