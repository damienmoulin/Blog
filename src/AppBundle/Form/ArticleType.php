<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class,
                [
                    'attr' => [
                        'class' => 'form-control'
                    ],
                    'required' => true,
                    'label' => 'Titre *',
                    'label_attr' => array('class' => 'col-sm-3 control-label'),
                ])
            ->add('description', TextareaType::class,
                [
                    'attr' => [
                        'class' => 'form-control'
                    ],
                    'required' => true,
                    'label' => 'Contenu *',
                    'label_attr' => array('class' => 'col-sm-3 control-label'),
                ])
            ->add('theme', EntityType::class,
                [
                    'label' => 'Theme',
                    'class' => 'AppBundle\Entity\Theme',
                    'choice_label' => 'name'
                ])
            ->add('pictures', CollectionType::class ,
                [
                    'entry_type'   => PictureType::class ,
                    'allow_add'    => true,
                    'allow_delete' => true,
                    'by_reference' => false
                ]);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Article'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_article';
    }


}
