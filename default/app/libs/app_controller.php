<?php
/**
 * @see Controller nuevo controller
 */
require_once CORE_PATH . 'kumbia/controller.php';

/**
 * Controlador principal que heredan los controladores
 *
 * Todas las controladores heredan de esta clase en un nivel superior
 * por lo tanto los metodos aqui definidos estan disponibles para
 * cualquier controlador.
 *
 * @category Kumbia
 * @package Controller
 */
Load::model("carrito/carrito");
class AppController extends Controller
{

    public  static $ANONIMO_FOTO="anonimo.svg";
    public  static $ANONIMO_NOMBRE="SayaYin";
    public  static $LINK_MISDATOS="#";
    
    public  static $MODULOS;
    final protected function initialize()
    {
        if(Auth::is_valid()){
//            Carrito::clearAll();
            $usu=new Usuario();
            $hallado = $usu->find_by_id(Auth::get("id"));
            if($hallado->foto){
                AppController::$ANONIMO_FOTO = PUBLIC_PATH."img/upload/perfiles/".$hallado->foto;
            }else{
                AppController::$ANONIMO_FOTO = PUBLIC_PATH."img/".AppController::$ANONIMO_FOTO;
            }
            AppController::$ANONIMO_NOMBRE= base64_decode($hallado->usu);
            switch (Auth::get("rol_id")){
                case "2"://administrador Local
                        $a=new Administrador();
                        $adm = $a->find_first("usuario_id=".Auth::get("id"));
                        AppController::$ANONIMO_NOMBRE = $adm->adm_nom;
                        AppController::$LINK_MISDATOS = PUBLIC_PATH."../../localadmin/perfil/";
                    break;
                case "3"://negocio cliente
                        $a   =new Cliente();
//                    die("usuario_id=".Auth::get("id"));
                        $cli = $a->find_first("usuario_id=".Auth::get("id"));
                        AppController::$ANONIMO_NOMBRE = $cli->cli_nom;
                        AppController::$LINK_MISDATOS = PUBLIC_PATH."../../clientesneg/perfil/";
                    break;
            }
            AppController::$MODULOS = $usu->tieneAcceso($this->controller_name, $this->action_name);
            if(count(AppController::$MODULOS)==0){
                die( "No ACCEDE controlador(". $this->controller_name.") accion(".$this->action_name.") ROL ID=".Auth::get("rol_id"));
            }else{
                
            }
        }else{
            
            if($this->controller_name=="index" && $this->action_name=="index" ||
                    $this->controller_name=="ingreso" && $this->action_name=="index"
                    )
            {}else{
                 Redirect::to("../../");
                die( "No ACCEDE controlador(". $this->controller_name.") accion(".$this->action_name.") ");
            }

        }
    }

    final protected function finalize()
    {
        
    }
    
    

}
