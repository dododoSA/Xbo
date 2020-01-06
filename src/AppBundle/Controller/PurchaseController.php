<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Household;
use AppBundle\Entity\Purchase;
use AppBundle\Form\PurchaseType;
use DateTime;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * @Route(defaults={"_format": "json"})
 */

class PurchaseController extends FOSRestController {
    /**
     * とりあえず一個登録
     * @Post(/api/household/{id}/purchase)
     */
    public function createAction(Request $request, $id)
    {
        $data = json_decode($request->getContent(), true);

        $purchase = new Purchase();

        $form = $this->createForm(PurchaseType::class, $purchase, [
            'csrf_protection' => false,
        ]);
        $form->submit($data);

        if (!$form->isValid()) {
            $errors = $this->getErrorsFromForm($form);

            $errData = [
                'title' => 'validation error',
                'errors' => $errors,
            ];

            return new JsonResponse($errData, 400);
        }

        $purchase->setPurchasedAt(new DateTime());
        $household = $this->getDoctrine()->getRepository(Household::class)->find($id);
        if (!$household) {
            throw new AccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($purchase);
        $em->flush();

        $json = $this->serialize($purchase);

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