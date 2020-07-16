<?php

/**
 * Controller por defecto si no se usa el routes
 *
 */
class UsuarioController extends AppController
{

    public function perfil() {
        if(Input::hasPost("a")){
            $vector = Input::post("a");
            $per =new Usuario();
            $vector["id"]= Auth::get("id");
            if($per->save($vector)){
                Flash::valid("Datos Actualizados Correctamente . . .");
                Redirect::to("../../usuario/perfil");
            }
        }
        $this->linkFoto =PUBLIC_PATH."../../usuario/foto";
        $this->titulo ="MIS DATOS";
        $this->sub    ="Datos Personales";
        $i=new Usuario();
        $this->a=$i->find_by_id(Auth::get("id"));
        switch (Auth::get("rol")){
            case "L":
                $loc=new Localadmin();
                $this->b = $loc->find_first("usuario_id=".Auth::get("id"));
                break;
        }
    }

    public function foto() {
        if(Input::hasPost("a")){
            $vector = Input::post("a");
            $usu=new Usuario();
            if($usu->cambiarFoto()){
                Flash::valid("Foto Actualizada Correctamente . . .");
                Redirect::to("../../usuario/foto");
            }
        }
        $this->linkPerfil =PUBLIC_PATH."../../usuario/perfil";
        $this->titulo ="MI FOTO";
        $this->sub    ="Actualizar";
    }
    
    public function clave() {
        if(Input::hasPost("a")){
            $vector = Input::post("a");
            $usu=new Usuario();
            if($usu->cambiarClave($vector)){
                Flash::valid("Contraseña Actualizada Correctamente . . .");
                Redirect::to("../../usuario/clave");
            }
        }
        
        $this->titulo     = "CONTRASEÑA";
        $this->sub    ="Cambiar";
        $this->linkFoto =PUBLIC_PATH."../../usuario/foto";
        
    }
    
    public function registrarse() 
    {
        View::template("default_1");
    
        if(Input::hasPost("a")){
            $vector = Input::post("a");
            $usu=new Usuario();
            if($usu->registrarse($vector)){
                Redirect::to("../../usuario/exitoUsuario");
            }
            
        }
    }
    
    public function exitoUsuario() {
        //View::template("default_1");
        
    }

    
/*************************************************************************************************************/    
/*************************************************************************************************************/    
/*************************************************************************************************************/    
    
    public function ingresar()
    {
        //View::template("default_1");
        if(Input::hasPost("usuario")){
            $usuario = Input::post("usuario");
            $clave = Input::post("clave");
            print_r($_POST);
            die();
            if(!$usuario || !$clave){
                Flash::error("Usuario/clave no reconocido por esl sistema $usuario   $clave");
            }else{
                
                $usuario = base64_encode($usuario);
                $clave   = base64_encode($clave);
                $auth = new Auth("model", "class: usuario", "usu: $usuario", "cla: $clave");
                if(!$auth->authenticate()){
//                $usuario = base64_decode($usuario);
//                $clave   = base64_decode($clave);
                    Flash::error("Usuario/clave no reconocido por esl sistema ");
//                    Flash::error("Usuario/clave no reconocido por esl sistema $usuario   $clave");
                }else{
                    switch (Auth::get("rol_id")){
                      case "1": Redirect::to("../../negocio/");
                          break;
                      case "L": Redirect::to("../../localadmin/panel");
                          break;
                      case "C": Redirect::to("../../interesado/negocios1");
                          break;
                    }
                }
            }
            
        }
        $this->linkImg=PUBLIC_PATH."img/social.svg";
    }
    
   
    public function salir() {
        Auth::destroy_identity();
        Redirect::to("../../");
    }    

}
