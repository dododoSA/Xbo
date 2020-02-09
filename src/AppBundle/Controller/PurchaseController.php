<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Household;
use AppBundle\Entity\Purchase;
use AppBundle\Form\PurchaseType;
use AppBundle\Service\CRUDManager;
use DateTime;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * @Route(defaults={"_format": "json"})
 */
class PurchaseController extends FOSRestController {
    private $CRUDManager;

    public function __construct(CRUDManager $CRUDManager)
    {
        $this->CRUDManager = $CRUDManager;
    }

    /**
     * とりあえず一個登録
     * @Post("/api/household/{id}/purchase")
     */
    public function createAction(Request $request, $id)
    {
        $data = json_decode($request->getContent(), true);

        $purchase = new Purchase();

        $this->CRUDManager->formProceed($data, PurchaseType::class, $purchase);

        $purchase->setPurchasedAt(new DateTime());
        $household = $this->getDoctrine()->getRepository(Household::class)->find(1);
        if (!$household) {
            throw new AccessDeniedException();
        }

        $purchase->setHousehold($household);

        $em = $this->getDoctrine()->getManager();
        $em->persist($purchase);
        $em->flush();

        $json = $this->CRUDManager->serialize($purchase);

        return new Response($json, 201);
    }

    /**
     * @Get("/api/household/{household_id}/purchase")
     */
    public function listAction($household_id) 
    {
        $purchases = $this->getDoctrine()
            ->getRepository(Household::class)
            ->find(1)
            ->getPurchases();

        if (!$purchases) {
            throw new NotFoundHttpException();
        }
        
        $json = $this->CRUDManager->serialize($purchases);

        return new Response($json, 200);
    }

    /**
     * @Get("/api/household/{household_id}/purchase/{id}")
     */
    public function readAction($household_id, $id)
    {
        $purchase = $this->getDoctrine()->getRepository(Purchase::class)->find($id);

        if (!$purchase) {
            throw new NotFoundHttpException();
        }

        $json = $this->CRUDManager->serialize($purchase);

        return new Response($json, 200);
    }

    /**
     * @Put("/api/household/{household_id}/purchase/{id}")
     */
    public function updateAction(Request $request, $household_id, $id)
    {
        $data = json_decode($request->getContent(), true);

        $purchase = $this->getDoctrine()->getRepository(Purchase::class)->find($id);

        if (!$purchase) {
            throw new NotFoundHttpException();
        }

        $this->CRUDManager->formProceed($data, PurchaseType::class, $purchase);

        $json = $this->CRUDManager->serialize($purchase);

        $em = $this->getDoctrine()->getManager();
        $em->flush();

        return new Response($json, 200);
    }

    /**
     * @Delete("/api/household/{household_id}/purchase/{id}")
     */
    public function deleteAction($household_id, $id)
    {
        $purchase = $this->getDoctrine()->getRepository(Purchase::class)->find($id);

        if (!$purchase) {
            throw new NotFoundHttpException();
        }

        $json = $this->CRUDManager->serialize($purchase);

        $em = $this->getDoctrine()->getManager();
        $em->remove($purchase);
        $em->flush();

        return new Response($json, 200);
    }
}