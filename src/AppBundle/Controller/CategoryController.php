<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use AppBundle\Entity\Household;
use AppBundle\Form\CategoryType;
use AppBundle\Service\CRUDManager;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CategoryController extends FOSRestController
{
    /**
     * @param CRUDManager
     */
    private $CRUDManager;

    /**
     * CategoryController constructor
     * @param CRUDManager $CRUDManager
     */
    public function __construct(CRUDManager $CRUDManager)
    {
        $this->CRUDManager = $CRUDManager;
    }

    /**
     * @Post("/api/household/{id}/category")
     * @param Request $request
     */
    public function createAction(Request $request, int $household_id): Response
    {
        $data = json_decode($request->getContent(), true);

        $category = new Category();

        $this->CRUDManager->formProceed($data, CategoryType::class, $category, [
            'csrf_protection' => false,
        ]);

        $household = $this->getDoctrine()->getRepository(Household::class)->find($household_id);
        if (!$household) {
            throw new NotFoundHttpException();
        }

        //家計に存在しない名前は登録できないようにする。なんかオプションとかでこの辺は設定できそうなので後日余裕があったら調べる
        if ($this->validateCategory($category->getName(), $household)) {
            $category->setHousehold($household);
        }
        else {
            throw new BadRequestHttpException();
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($category);
        $em->flush();

        $json = $this->CRUDManager->serialize($category);

        return new Response($json, 200);
    }

    /**
     * @Get("/api/household/{id}/categories")
     * @param int $id
     * @return Response
     * @throws Exception
     */
    public function listAction(int $id): Response
    {
        $household = $this->getDoctrine()->getRepository(Household::class)->find($id);

        if (!$household) {
            throw new NotFoundHttpException();
        }

        $categories = $household->getCategories();

        $cArray = $this->CRUDManager->toArray($categories);

        $json = json_encode($cArray);

        return new Response($json, 200);
    }

    /**
     * @Put("/api/household/{household_id}/category/{id}")
     * @param Request  $request
     * @param int      $id 
     */
    public function updateAction(Request $request, int $household_id, int $id): Response
    {
        $data = json_decode($request->getContent(), true);

        $category = $this->getDoctrine()->getRepository(Category::class)->find($id);

        if (!$category) {
            throw new NotFoundHttpException();
        }

        $this->CRUDManager->formProceed($data, CategoryType::class, $category);

        $json = $this->CRUDManager->serialize($category);

        $em = $this->getDoctrine()->getManager();
        $em->flush();

        return new Response($json, 200);
    }

    /**
     * @Delete("/api/household/{household_id}/category/{id}")
     * @param int $id
     * 
     * @return Response
     * @throws Exception
     */
    public function deleteAction(int $household_id, int $id): Response
    {
        $category = $this->getDoctrine()->getRepository(Category::class)->find($id);

        if (!$category) {
            throw new NotFoundHttpException();
        }

        $json = $this->CRUDManager->serialize($category);

        $em = $this->getDoctrine()->getManager();
        $em->remove($category);
        $em->flush();

        return new Response($json, 200);
    }

    private function validateCategory($categoryName, Household $household): bool
    {
        $categories = $household->getCategories();
        foreach ($categories as $category) {
            if ($category->getName() === $categoryName) {
                return true;
            }
        }
        return false;
    }
}