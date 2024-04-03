<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class CalendarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('mode', ChoiceType::class,[
                'expanded' => true,
                'choices'  => [
                    'select' => true,
                    'new' => false
                ],
                'data' => true,
                'attr' => ['class' => 'mode-radio']

            ])
            ->add('name', TextType::class,[
                'row_attr' => ['class'=> 'name-wrapper'],
                'constraints' => [ new Callback([
                    'callback' => function ($data, ExecutionContextInterface $context) {
                        $formData = $context->getRoot()->getData();
                        if (!$data && $formData['mode']) {
                            $context->buildViolation('This value can not be empty.')
                                ->addViolation();
                        }
                    }
                ]) ]
            ])
            ->add('select-description', TextareaType::class,[
                'constraints' => [ new Callback([
                    'callback' => function ($data, ExecutionContextInterface $context) {
                        $formData = $context->getRoot()->getData();


                        if($formData['mode']){
                            return;
                        }

                        $notBlank = new NotBlank();
                        $lengthConstraint = new Length([
                            'min' => 5,
                            'minMessage' => 'The value should be at least {{ limit }} characters long.',
                        ]);
                        $errors = $context->getValidator()->validate($data, [$notBlank,$lengthConstraint]);
                        if (count($errors) > 0) {
                            foreach ($errors as $error) {
                                $context->buildViolation($error->getMessage())
                                    ->addViolation();
                            }
                        }
                    }
                ])],
                'row_attr' => ['class'=> 'textarea-wrapper' , 'style' => 'display: none;'],
            ])

            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
