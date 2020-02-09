<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Household;
use AppBundle\Service\CRUDManager;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\UserBundle\Form\Type\RegistrationFormType;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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

    /**
     * UserController Constructor
     * @param UserManagerInterface  $userManager
     * @param CRUDManager           $CRUDManager
     */
    public function __construct(UserManagerInterface $userManager, CRUDManager $CRUDManager)
    {
        $this->userManager = $userManager;
        $this->CRUDManager = $CRUDManager;
    }

    /**
     * @Post("/api/register")
     * @param Request $request
     */
    public function registerAction(Request $request)
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
        $json = $this->CRUDManager->serialize($user);
        $this->userManager->updateUser($user);


        return new Response($json, 200);
    }
}