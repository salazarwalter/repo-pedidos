<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of contrata_controller
 *
 * @author salazarwalter
 */
class ContrataController extends AppController {
    public function index() {
        $this->titulo="CONTRATACIÓN";
        $this->sub="Módulos";
        $this->linkAdd=PUBLIC_PATH."../../contrata/add/";
        $this->linkEdit=PUBLIC_PATH."../../contrata/edit/";
        $c =new Contrata();
        $this->lista =$c->lista();
    }
    public function add($neg_id=0) {
        if(Input::hasPost("a")){
            $vec = Input::post("a");
            $neg_id = $vec["negocio_id"];
            $con =new Contrata();
            if($con->agregar($vec)){
                Redirect::to("../../contrata/add/$neg_id");
            }
        }
        $this->titulo="CONTRATACIÓN";
        $this->sub="Agregar";
        $this->linkVolver=PUBLIC_PATH."../../contrata/";
        $n = new Negocio();
        if($neg_id==0){
            $neg= $n->find_first("activo='S'");
            $neg_id= $neg->id;
        }
        $c =new Contrata();
        $this->lista = $c->lista_x_negocio($neg_id);
        
        $this->a =new Contrata();
        $this->a->negocio_id = $neg_id;
    }

    public function edit($contrata_id) {
        if(Input::hasPost("a")){
            $vec =Input::post("a");
            $contrata_id = $vec["id"];
            $c =new Contrata();
            if($c->modificar($vec)){
                Redirect::to("../../contrata/");
            }
        }
        $this->titulo ="CONTRATA";
        $this->sub ="Modificar";
        $c = new Contrata();
        $this->a = $c->hallar($contrata_id);
        $this->linkVolver =PUBLIC_PATH."../../contrata/";
    }    
}
