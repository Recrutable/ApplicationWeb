<?php

namespace QcmBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class QuestionsType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('question')
            ->add('reponseA')
            ->add('reponseB')
            ->add('reponseC')
            ->add('bonneReponse', ChoiceType::class, array(
                'choices' => array('A'=>'A','B'=>'B','C'=>'C'),
                'choices_as_values' => true,
                'multiple' => false,
                'expanded'=> false,
                'required' => true,
            ))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'QcmBundle\Entity\Questions'
        ));
    }
}
