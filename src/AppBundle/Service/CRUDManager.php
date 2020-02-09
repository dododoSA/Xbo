<?php

namespace AppBundle\Service;

use JMS\Serializer\SerializerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;


class CRUDManager {
    private $formFactory;

    private $serializer;
    
    public function __construct(FormFactoryInterface $formFactory, SerializerInterface $serializer)
    {
        $this->formFactory = $formFactory;
        $this->serializer = $serializer;
    }

    public function formProceed(array $reqData, string $formType, $object, array $option = []): void
    {

        $form = $this->createForm($formType, $object, $option);
        $form->submit($reqData);

        $errors = array();
        if (!$form->isValid()) {
            $errors = $this->getErrorsFromForm($form);

            $data = [
                'title' => 'validation error',
                'errors' => $errors
            ];

            throw new BadRequestHttpException($data);
        }
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

    public function serialize($data)
    {
        return $this->serializer
            ->serialize($data, 'json');
    }

    private function createForm($type, $data = null, array $options = []) {
        return $this->formFactory->create($type, $data, $options);
    }
}