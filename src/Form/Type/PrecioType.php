<?php

namespace App\Form\Type;

use App\Entity\TteCiudad;
use App\Entity\TteEmpresa;
use App\Entity\TtePrecio;
use App\Entity\TteProducto;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PrecioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('vrKilo', NumberType::class, ['required' => true, 'attr' => ['class' => 'form-control']])
            ->add('vrUnidad', NumberType::class, ['required' => true, 'attr' => ['class' => 'form-control']])
            ->add('ciudadOrigenRel', EntityType::class, [
                'required' => true,
                'attr' => ['class' => 'form-control'],
                'class' => TteCiudad::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('er')
                        ->orderBy('er.nombre');
                }
            ])
            ->add('ciudadDestinoRel', EntityType::class, [
                'required' => true,
                'attr' => ['class' => 'form-control'],
                'class' => TteCiudad::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('er')
                        ->orderBy('er.nombre');
                }
            ])
            ->add('productoRel', EntityType::class, [
                'required' => true,
                'attr' => ['class' => 'form-control'],
                'class' => TteProducto::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('er')
                        ->orderBy('er.nombre');
                }
            ])
            ->add('empresaRel', EntityType::class, [
                'required' => true,
                'attr' => ['class' => 'form-control'],
                'class' => TteEmpresa::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('er')
                        ->orderBy('er.nombre');
                }
            ])
            ->add('guardar', SubmitType::class, ['label' => 'Guardar', 'attr' => ['class' => 'btn btn-sm btn-primary float-right']]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TtePrecio::class,
        ]);
    }
}
