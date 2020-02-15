<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\FOSRestController;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityController extends FOSRestController
{
    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }
    /**
     * @Post("/login", name="login")
     */
    public function loginAction(Request $request)
    {
        $user = $this->getUser();

        return new Response($user->getUsername(), true);
    }
}