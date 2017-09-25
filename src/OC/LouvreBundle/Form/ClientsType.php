<?php

namespace OC\LouvreBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientsType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('billet', BilletsType::class)
            ->add('nom', TextType::class)
            ->add('prenom', TextType::class)
            ->add('dateNaissance', BirthdayType::class, array(
                'format' => 'dd-MM-yyyy',
            ))
            ->add('pays', CountryType::class);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'OC\LouvreBundle\Entity\Clients'
        ));
    }


}
