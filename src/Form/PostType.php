<?php

namespace App\Form;

use App\Entity\Post;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('body')
            ->add('publishDate', DateType::class, [
                'widget'=> 'single_text',
                'data' => new \DateTime()
            ])
        ;

        $builder->addEventListener(FormEvents::PRE_SET_DATA,function (FormEvent $event){
            /** @var Post $post */
            $post = $event->getData();
            $form = $event->getForm();
            $post->setTitle('change some data to title');
           // $form->add('isPublished');

            dump($post);

        });

        $builder->addEventListener(FormEvents::POST_SET_DATA,function (FormEvent $event){

            /** @var Post $post */
            $post = $event->getData();
            $form = $event->getForm();

            $post->setTitle('we can not set data anymore');

            $form->add('publishDate');

        });


    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
