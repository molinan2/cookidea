<?php

namespace AppBundle\Controller;

use AppBundle\Services\ApiHelper;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\View\View;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\Annotation\Groups;
use Doctrine\ORM\EntityManager;
use Doctrine\DBAL\DBALException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use AppBundle\Entity\User;



/**
 * Class ApiController
 *
 * Controlador principal de la API
 *
 * @package AppBundle\Controller
 */
class ApiController extends FOSRestController
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Post("ingredients/")
     */
    public function ingredientsAction(Request $request)
    {
        /** @var EntityManager $em */
        $em = $this->get('doctrine')->getManager();

        /** @var ApiHelper $apiHelper */
        $apiHelper = $this->get('apihelper');

        /*
        if (!$apiHelper->checkCredentials($request))
            return $apiHelper->responseError();
        */

        $ingredients = $em->getRepository('AppBundle:Ingredient')->findAll();

        return $apiHelper->responseSuccess($ingredients, "ingredients");
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Post("recipes/")
     */
    public function recipesAction(Request $request)
    {
        /** @var EntityManager $em */
        $em = $this->get('doctrine')->getManager();

        /** @var ApiHelper $apiHelper */
        $apiHelper = $this->get('apihelper');

        if (!$apiHelper->checkCredentials($request))
            return $apiHelper->responseError();

        $meal = $request->get('meal');
        $ingredients = json_decode($request->get('ingredients'), true); # Array de ID's de ingredientes

        # TODO: Calcular recetas acordes

        $recipes = $em->getRepository('AppBundle:Recipe')->findAll();

        return $apiHelper->responseSuccess($recipes, "recipes");
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Post("fav/")
     */
    public function favAction(Request $request)
    {
        /** @var EntityManager $em */
        $em = $this->get('doctrine')->getManager();

        /** @var ApiHelper $apiHelper */
        $apiHelper = $this->get('apihelper');

        if (!$apiHelper->checkCredentials($request))
            return $apiHelper->responseError();


        $recipeId = $request->get('recipe_id'); # ID de la receta a la que ha hecho fav

        # TODO: Cambiar fav de user en receta ID y devolver success

        return $apiHelper->responseSuccess(true);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Post("unfav/")
     */
    public function unfavAction(Request $request)
    {
        /** @var EntityManager $em */
        $em = $this->get('doctrine')->getManager();

        /** @var ApiHelper $apiHelper */
        $apiHelper = $this->get('apihelper');

        if (!$apiHelper->checkCredentials($request))
            return $apiHelper->responseError();


        $recipeId = $request->get('recipe_id'); # ID de la receta a la que ha hecho fav

        # TODO: Cambiar fav de user en receta ID y devolver success

        return $apiHelper->responseSuccess(true);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Post("comment/")
     */
    public function commentAction(Request $request)
    {
        /** @var EntityManager $em */
        $em = $this->get('doctrine')->getManager();

        /** @var ApiHelper $apiHelper */
        $apiHelper = $this->get('apihelper');

        if (!$apiHelper->checkCredentials($request))
            return $apiHelper->responseError();

        $recipeId = $request->get('recipe_id'); # ID de la receta que se va a comentar
        $comment = $request->get('comment'); # Texto del comentario

        # TODO: Guardar comment y devolver ficha completa de comment (con fecha y username)

        $comments = $em->getRepository('AppBundle:Comment')->findAll();

        return $apiHelper->responseSuccess($comments[0], "recipes");
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Post("login/")
     */
    public function loginAction(Request $request)
    {
        /** @var EntityManager $em */
        $em = $this->get('doctrine')->getManager();

        /** @var ApiHelper $apiHelper */
        $apiHelper = $this->get('apihelper');

        if (!$apiHelper->checkCredentials($request))
            return $apiHelper->responseError();

        return $apiHelper->responseSuccess(true);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Post("register/")
     */
    public function registerAction(Request $request)
    {
        /** @var EntityManager $em */
        $em = $this->get('doctrine')->getManager();

        /** @var ApiHelper $apiHelper */
        $apiHelper = $this->get('apihelper');

        $username = $request->get('username'); # TODO: Guardar username
        $email = $request->get('email');
        $password = $request->get('password');

        $user = $em->getRepository("AppBundle:User")->findBy(array(
            'email' => $email
        ));

        // Error: Si ya existe un usuario con este mail
        if ($user)
            return $apiHelper->responseError();

        if ($this->userRegister($email, $password, $username))
            return $apiHelper->responseSuccess(true);
        else
            return $apiHelper->responseError();
    }

    /**
     * userRegister
     *
     * Registra en la base de datos a un usuario con los datos suministrados. Si el registro ocurrió correctamente,
     * envía un mail de confirmación a la cuenta del usuario y devuelve true. En caso contrario, devuelve false.
     *
     * @param $email
     * @param $password
     * @param $name
     * @return bool
     */
    private function userRegister ($email, $password, $name)
    {
        $mailer = $this->container->get('fos_user.mailer');

        // Creacion del usuario mediante el userManager de FOS
        $userManager = $this->container->get('fos_user.user_manager');

        /** @var User $user */
        $user = $userManager->createUser();

        $user->setEmail($email);
        $user->setEmailCanonical($email);
        $user->setUsername($name);
        $user->setUsernameCanonical($name);
        $user->setPlainPassword($password);

        try {
            // Envio del token de confirmacion
            $token = sha1(uniqid(mt_rand(), true));
            $user->setConfirmationToken($token);
            $mailer->sendConfirmationEmailMessage($user);

            // Registro del usuario (sin confirmar)
            $userManager->updateUser($user);

            $status = true;
        } catch (DBALException $e) {
            $status = false;
        }

        return $status;
    }

}