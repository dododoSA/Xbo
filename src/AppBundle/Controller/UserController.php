<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Household;
use AppBundle\Service\CRUDManager;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\UserBundle\Form\Type\ProfileFormType;
use FOS\UserBundle\Form\Type\RegistrationFormType;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class UserController extends FOSRestController
{
    /**
     * @var UserManagerInterface
     */
    private $userManager;

    /**
     * @var CRUDManager
     */
    private $CRUDManager;

    private $tokenStorage;

    /**
     * UserController Constructor
     * @param UserManagerInterface  $userManager
     * @param CRUDManager           $CRUDManager
     */
    public function __construct(UserManagerInterface $userManager, CRUDManager $CRUDManager, TokenStorageInterface $tokenStorage)
    {
        $this->userManager = $userManager;
        $this->CRUDManager = $CRUDManager;
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @Post("/api/register")
     * @param Request $request
     * @return Response
     */
    public function registerAction(Request $request): Response
    {
        //デフォルトのを参考にディスパッチャを書くかどうか
        $data = json_decode($request->getContent(), true);

        $user = $this->userManager->createUser();
        $user->setEnabled(true);

        $this->CRUDManager->formProceed($data, RegistrationFormType::class, $user, [
            'csrf_protection' => false
        ]);

        $household = new Household();
        $household->setName($user->getUsername());
        $em = $this->getDoctrine()->getManager();
        $em->persist($household);

        $user->setHousehold($household);
        $this->userManager->updateUser($user);

        $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
        $this->tokenStorage->setToken($token);

        $this->get('session')->set('_security_main', serialize($token));

        $resData = [
            'username' => $user->getUsername(),
            'household_id' => $user->getHousehold()->getId()
        ];

        $json = $this->CRUDManager->serialize($resData);

        return new Response($json, 201);
    }

    /**
     * @Put("/api/user")
     * @param Request $request
     * @return Response
     */
    public function editAction(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        //デフォルトのコントローラーを参考にしてる　こっちも後でイベントディスパッチャを書くかどうか問題
        $user = $this->getUser();
        
        if (!$user) {
             throw new AccessDeniedHttpException('This user does not have access to this section.');
        }

        trigger_error('hello');
        $this->CRUDManager->formProceed($data, ProfileFormType::class, $user);

        $json = $this->CRUDManager->serialize($user);
        $this->userManager->updateUser($user);

        return new Response($json, 200);
    }
}