<?php

namespace AppBundle\Service;

use JMS\Serializer\SerializerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;


class CRUDManager {
    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @var JMS\Serializer\SerializerInterface
     */
    private $serializer;
    
    /**
     * CRUDManager constructor
     * @param FormFactoryInterface                  $formFactory
     * @param JMS\Serializer\SerializerInterface    $serializer
     */
    public function __construct(FormFactoryInterface $formFactory, SerializerInterface $serializer)
    {
        $this->formFactory = $formFactory;
        $this->serializer = $serializer;
    }

    /**
     * @param array     $reqData
     * @param string    $formType
     * @param mixed     $object
     * @param array     $options
     * 
     * @return void
     * @throws BadRequestHttpException
     */
    public function formProceed(array $reqData, string $formType, $object, array $options = []): void
    {

        $form = $this->createForm($formType, $object, $options);
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

    /**
     * @param FormInterface $form
     * 
     * @return array        $errors
     */
    private function getErrorsFromForm(FormInterface $form): array
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

    /**
     * @param mixed $data
     * 
     * @return string
     */
    public function serialize($data): string
    {
        return $this->serializer
            ->serialize($data, 'json');
    }

    /**
     * @param string    $type
     * @param mixed     $data
     * @param array     $options
     * 
     * @return FormInterface
     * @throws \Symfony\Component\OptionsResolver\Exception\InvalidOptionsException
     */
    private function createForm($type, $data = null, array $options = []) {
        return $this->formFactory->create($type, $data, $options);
    }
}