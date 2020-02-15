<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\UserBundle\Model\UserManagerInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class SecurityController extends FOSRestController
{
    private $serializer;

    private $encFactory;

    private $userManager;

    private $tokenStorage;

    public function __construct(SerializerInterface $serializer, EncoderFactoryInterface $encFactory, UserManagerInterface $userManager, TokenStorageInterface $tokenStorage)
    {
        $this->serializer = $serializer;
        $this->encFactory = $encFactory;
        $this->userManager = $userManager;
        $this->tokenStorage = $tokenStorage;
    }
    /**
     * @Post("/login", name="login")
     */
    public function loginAction(Request $request)
    {
        $reqContent = json_decode($request->getContent(), true);
        $username = $reqContent['username'];
        $password = $reqContent['password'];

        $user = $this->userManager->findUserByUsername($username);

        if (!$user) {
            $user = $this->userManager->findUserByEmail($username);
        }

        if (!$user) {
            throw new NotFoundHttpException('ユーザー名が存在しません');
        }

        $encoder = $this->encFactory->getEncoder($user);

        if (!$encoder->isPasswordValid($user->getPassword(), $password, $user->getSalt())){
            throw new UnauthorizedHttpException('ユーザー名またはパスワードが違います');
        }

        $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
        $this->tokenStorage->setToken($token);

        $this->get('session')->set('_security_main', serialize($token));

        $event = new InteractiveLoginEvent($request, $token);
        $this->get("event_dispatcher")->dispatch("security.interactive_login", $event);

        return new Response($user->getUsername());
    }
}