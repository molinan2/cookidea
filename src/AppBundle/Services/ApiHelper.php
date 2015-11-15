<?php

namespace AppBundle\Services;

use Doctrine\ORM\EntityManager;
use FOS\RestBundle\View\ViewHandler;
use FOS\RestBundle\View\View;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\Annotation\Groups;
use AppBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;

class ApiHelper
{
    /**
     * Constantes
     */
    const OK = "ok";
    const ERROR = "error";
    const STATE_OK = 1;
    const STATE_ERROR = 0;

    const MEAL_LUNCH = "lunch";
    const MEAL_DINNER = "dinner";
    const MEAL_BREAKFAST = "breakfast";

    /**
     * Constructor
     *
     * Recibe a través de 'app/config/services.yml' el EntityManager, el ViewHandler (para crear vistas con la respuesta)
     * y el UserPasswordEncoder (para comprobar la contrañeña del usuario con la base de datos).
     *
     * @param EntityManager $entityManager
     * @param ViewHandler $viewHandler
     * @param UserPasswordEncoder $userPasswordEncoder
     */
    public function __construct(EntityManager $entityManager, ViewHandler $viewHandler, UserPasswordEncoder $userPasswordEncoder)
    {
        $this->em = $entityManager;
        $this->viewhandler = $viewHandler;
        $this->encoder = $userPasswordEncoder;
    }

    /**
     * responseOk
     *
     * Crea y devuelve una respuesta de aceptación de la API.
     * Recibe en $data el conjunto de datos que devolverá la API.
     * Opcionalmente, se pueden especificar grupos para el contexto de la serialización.
     * Si no se especificam, el estado HTTP y el mensaje de error tendrán valores por defecto.
     *
     * @param $data
     * @param string $groups
     * @param string $message
     * @param int $httpStatusCode
     * @return Response
     */
    public function responseSuccess ($data, $groups = "", $message = "", $httpStatusCode = Response::HTTP_ACCEPTED)
    {
        $response['state'] = $this::STATE_OK;
        $response['message'] = strlen($message) ? $message : $this::OK;
        $response['data'] = $data;

        $view = View::create()
            ->setStatusCode($httpStatusCode)
            ->setData($response);

        if ((is_string($groups) and strlen($groups)) or is_array($groups)) {
            $groupsArray = (array) $groups;
            $view->setSerializationContext(SerializationContext::create()->setGroups($groupsArray));
        }

        return $this->viewhandler->handle($view);
    }

    /**
     * responseDenied
     *
     * Crea y devuelve una respuesta de denegación de la API.
     * Si no se proporcionan parámetros, el estado HTTP y el mensaje de error tendrán valores por defecto.
     *
     * @param string $message
     * @param int $httpStatusCode
     * @return Response
     */
    public function responseError ($message = "", $httpStatusCode = Response::HTTP_NOT_FOUND)
    {
        $response['state'] = $this::STATE_ERROR;
        $response['message'] = strlen($message) ? $message : $this::ERROR;
        $response['data'] = array();

        $view = View::create()
            ->setStatusCode($httpStatusCode)
            ->setData($response);

        return $this->viewhandler->handle($view);
    }

    /**
     * checkCredentials
     *
     * Comprueba si el usuario suministrado en el $request existe y si su password es correcta.
     * El $request debe tener 2 campos POST: 'email' y 'password'.
     * Devuelve 'true' si las credenciales son correctas. Devuelve 'false' en otro caso.
     *
     * No comprueba que los parámetros tengan un formato correcto (por tanto, debe haberse comprobado antes de
     * llamar a este método).
     *
     * @param Request $request
     * @return bool
     */
    public function checkCredentials (Request $request)
    {
        return $this->checkCredentialsNormal($request);
    }



    /**
     * checkCredentialsNormal
     *
     * Comprueba las credenciales normales (email y password)
     *
     * @param Request $request
     * @return bool
     */
    private function checkCredentialsNormal (Request $request)
    {
        /** @var User $user */
        $user = $this->em->getRepository('AppBundle:User')->findOneBy(array(
            'email' => $request->get('email')
        ));

        if (!$user)
            return false;

        if (!$user->isEnabled())
            return false;

        return $this->encoder->isPasswordValid($user, $request->get('password'));
    }

}