<?php

namespace AppBundle\Services;
use FOS\RestBundle\View\ViewHandler;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\View\View;
use Doctrine\Bundle\DoctrineBundle\Registry;

class ApiHelper {

    const OK = "ok";
    const DENIED= "Data not valid";
    const USERNOTVALID = "User not valid";
    const GENERALERROR = "General error";

    public function __construct(Registry $doctrine, ViewHandler $viewHandler) {
        $this->doctrine = $doctrine;
        $this->viewhandler=$viewHandler;
    }

    /**
     * Funcion para representar un uso erroneo de la API
     * @param String $msg mensaje
     * @return Array $array mensaje con el estado
     */
    private function doDenied($msg=null) {
        $array = array();
        $array['state'] = -1;
        if($msg !== null)
            $array['msg'] = $msg;
        else
            $array['msg'] = "Access Denied";

        return $array;
    }

    /**
     * @return mixed
     */
    public function msgOk($msg=null, $status=200) {
        $view = view::create()
            ->setStatusCode($status)
            ->setData($this->doOk($msg));

        return $this->viewhandler->handle($view);
    }

    /**
     * @return mixed
     */
    public function msgDenied($msg=null, $status=200) {
        $view = view::create()
            ->setStatusCode($status)
            ->setData($this->doDenied($msg));

        return $this->viewhandler->handle($view);
    }

    /**
     * Funcion para representar un acceso valido a la API
     * @param array $data Serie de datos
     * @return array Serie de datos
     */
    private function doOK($data) {
        $ret = array();
        $arr = array();
        $ret['state'] = 1;
        $ret['msg'] = "Ok";

        if($data === null) {
            $arr[] = null;
            $ret['data'] = $arr;
        }
        else
            $ret['data'] = $data;

        return $ret;
    }

    /**
     * Funcion que controla el usuario que envia datos a la API, sin estar logueado, con parámetros email y pass
     *
     * @param $email
     * @param $password
     * @return bool
     */
    private function checkUser($email, $password){
        $user = $this->doctrine->getManager()->getRepository('\Application\Sonata\UserBundle\Entity\User')->findOneBy(array ("email"=>$email, "password"=>$password));

        if ($user === null){
            return false;
        }

        return $user;
    }

    /**
     * Funcion que controla si el usuario está logueado o se comprueba con su email y pass
     * * @param Request $request
     * @return bool
     */
    public  function checkPrivateAccess(Request $request) {
        $user = $this->checkUser($request->get('email'), $request->get('password'));

        return $user;
    }

    public function dumpVar($var){
        return $var;
    }
}
