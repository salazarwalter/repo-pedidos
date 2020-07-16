<?php

/**
 * Controller por defecto si no se usa el routes
 *
 */
class IngresoController extends AppController
{

    public function index()
    {
        View::template("default_1");
        if(Input::hasPost("x")){
            $vec= Input::post("x");
            $usuario    = $vec["usuario"];
            $clave      = $vec["clave"];
            $negocio_id = $vec["negocio_id"];
            if(!$usuario || !$clave){
                Flash::error("Usuario/clave no reconocido por esl sistema $usuario   $clave");
            }else{
                
                $usuario = base64_encode($usuario);
                $clave   = base64_encode($clave);
                $auth = new Auth("model", "class: usuario", "usu: $usuario", "cla: $clave");
                if(!$auth->authenticate()){
                    Flash::error("Usuario/clave no reconocido por el sistema o No Pertenece a esta empresa");
                }else{
//            print_r($_POST);
//            die();
                    
                    if($negocio_id==Auth::get("negocio_id")){
                    switch (Auth::get("rol_id")){
                      case "1": Redirect::to("../../negocio/");
                          break;
                      case "2": Redirect::to("../../localadmin/panel");
                          break;
                      case "3": Redirect::to("../../clientesneg/panel");
                          break;
                    }
                    }else{
                        Auth::destroy_identity();
                        Flash::info("El Usuario/CLave no hallado o no Pertenece a esta empresa");
                        Redirect::to("../../ingreso");
                    }
                }
            }
            
        }
        $this->linkImg=PUBLIC_PATH."img/social.svg";
        
    }
}
