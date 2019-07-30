<?php

namespace App\Form\Type;

use App\Entity\TteEmpresa;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmpresaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre',TextType::class,['required' => true,'attr' => ['class' => 'form-control']])
            ->add('nit',TextType::class,['required' => true,'attr' => ['class' => 'form-control']])
            ->add('direccion',TextType::class,['required' => false,'attr' => ['class' => 'form-control']])
            ->add('telefono',TextType::class,['required' => false,'attr' => ['class' => 'form-control']])
            ->add('consecutivoGuia',IntegerType::class,['required' => true,'attr' => ['class' => 'form-control']])
            ->add('consecutivoGuiaDesde',IntegerType::class,['required' => true,'attr' => ['class' => 'form-control']])
            ->add('consecutivoGuiaHasta',IntegerType::class,['required' => true,'attr' => ['class' => 'form-control']])
            ->add('porcentajeManejo',NumberType::class,['required' => false,'attr' => ['class' => 'form-control']])
            ->add('listaPrecio',NumberType::class,['required' => true,'attr' => ['class' => 'form-control']])
            ->add('manejoMinimoDespacho',NumberType::class,['required' => true,'attr' => ['class' => 'form-control']])
            ->add('codigoCondicionFk', TextType::class, ['required' => true, 'attr' => ['class' => 'form-control']])
            ->add('tipoLiquidacion', TextType::class, ['required' => true, 'attr' => ['class' => 'form-control']])
            ->add('guardar',SubmitType::class,['label' => 'Guardar','attr' => ['class' => 'btn btn-sm btn-primary float-right']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TteEmpresa::class,
        ]);
    }
}
