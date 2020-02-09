<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Household;
use AppBundle\Form\HouseholdType;
use AppBundle\Service\CRUDManager;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class HouseholdController extends FOSRestController
{
    private $CRUDManager;

    public function __construct(CRUDManager $CRUDManager)
    {
        $this->CRUDManager = $CRUDManager;
    }

    /**
     * @Post("/api/household")
     */
    public function createAction(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        $household = new Household();

        $this->CRUDManager->formProceed($data, HouseholdType::class, $household, [
            'csrf_protection' => false,
        ]);


        $em = $this->getDoctrine()->getManager();
        $em->persist($household);
        $em->flush();

        $json = $this->CRUDManager->serialize($household);

        return new Response($json, 200);
    }

    /**
     * @Get("/api/household/{id}")
     */
    public function readAction($id)
    {
        $household = $this->getDoctrine()->getRepository(Household::class)->find($id);

        if (!$household) {
            throw new NotFoundHttpException();
        }

        $json = $this->CRUDManager->serialize($household);

        return new Response($json, 200);
    }

    /**
     * @Put("/api/household/{id}")
     */
    public function updateAction(Request $request, $id)
    {
        $data = json_decode($request->getContent(), true);

        $household = $this->getDoctrine()->getRepository(Household::class)->find($id);

        if (!$household) {
            throw new NotFoundHttpException();
        }

        $this->CRUDManager->formProceed($data, HouseholdType::class, $household);

        $json = $this->CRUDManager->serialize($household);

        $em = $this->getDoctrine()->getManager();
        $em->flush();

        return new Response($json, 200);
    }

    /**
     * @Delete("/api/household/{id}")
     */
    public function deleteAction($id)
    {
        $household = $this->getDoctrine()->getRepository(Household::class)->find($id);

        if (!$household) {
            throw new NotFoundHttpException();
        }

        $json = $this->CRUDManager->serialize($household);

        $em = $this->getDoctrine()->getManager();
        $em->remove($household);
        $em->flush();

        return new Response($json, 200);
    }
}