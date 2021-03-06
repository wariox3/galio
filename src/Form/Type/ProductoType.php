<?php

namespace App\Form\Type;

use App\Entity\TteProducto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre', TextType::class, ['required' => true, 'attr' => ['class' => 'form-control']])
            ->add('orden', IntegerType::class, ['required' => true, 'attr' => ['class' => 'form-control']])
            ->add('codigoProductoOperadorFk', TextType::class, ['required' => true, 'attr' => ['class' => 'form-control']])
            ->add('guardar', SubmitType::class, ['label' => 'Guardar', 'attr' => ['class' => 'btn btn-sm btn-primary float-right']]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TteProducto::class,
        ]);
    }
}
