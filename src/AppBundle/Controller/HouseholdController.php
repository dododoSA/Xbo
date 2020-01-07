<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Household;
use AppBundle\Form\HouseholdType;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class HouseholdController extends FOSRestController
{
    /**
     * @Post("/api/household")
     */
    public function createAction(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        $household = new Household();

        $form = $this->createForm(HouseholdType::class, $household, [
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


        $em = $this->getDoctrine()->getManager();
        $em->persist($household);
        $em->flush();

        $json = $this->serialize($household);

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

        $json = $this->serialize($household);

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

        $form = $this->createForm(HouseholdType::class, $household);    
        $form->submit($data);
        
        if (!$form->isValid()) {
            $errors = $this->getErrorsFromForm($form);

            $data = [
                'title' => 'validation error',
                'errors' => $errors
            ];

            return new JsonResponse($data, 400);
        }

        $json = $this->serialize($household);

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

        $json = $this->serialize($household);

        $em = $this->getDoctrine()->getManager();
        $em->remove($household);
        $em->flush();

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