<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Household;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\UserBundle\Form\Type\RegistrationFormType;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends FOSRestController
{
    /**
     * @var UserManagerInterface
     */
    private $userManager;

    /**
     * UserController Constructor
     */
    public function __construct(UserManagerInterface $userManager)
    {
        $this->userManager = $userManager;
    }

    /**
     * @Post("/api/register")
     */
    public function registerAction(Request $request)
    {
        //デフォルトのを参考にディスパッチャを書くかどうか
        $data = json_decode($request->getContent(), true);

        $user = $this->userManager->createUser();
        $user->setEnabled(true);
        $form = $this->createForm(RegistrationFormType::class, $user, [
            'csrf_protection' => false
        ]);
        $form->submit($data);

        if (!$form->isValid()) {
            $errors = $this->getErrorsFromForm($form);

            $data = [
                'title' => 'validation error',
                'errors' => $errors
            ];

            return new JsonResponse($data, 400);
        }

        $household = new Household();
        $household->setName($user->getUsername());
        $em = $this->getDoctrine()->getManager();
        $em->persist($household);

        $user->setHousehold($household);
        $json = $this->serialize($user);
        $this->userManager->updateUser($user);


        return new Response($json, 200);
    }

    private function getErrorsFromForm(FormInterface $form)
    {
        $errors = array();
        foreach ($form->getErrors() as $error) {
            $errors[] = $error->getMessage();
        }

        foreach ($form->all() as $childForm) {
            if ($childForm instanceof FormInterface) {
                if ($childErrors = $this->getErrorsFromForm($childForm)) {
                    $errors[$childForm->getName()] = $childErrors;
                }
            }
        }

        return $errors;
    }

    private function serialize($data)
    {
        return $this->container->get('jms_serializer')
            ->serialize($data, 'json');
    }
}