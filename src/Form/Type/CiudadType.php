<?php

namespace App\Form\Type;

use App\Entity\TteCiudad;
use App\Entity\TteDepartamento;
use App\Entity\TteProducto;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CiudadType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        global $kernel;
        $user = $kernel->getContainer()->get('security.token_storage')->getToken()->getUser();
        $builder
            ->add('departamentoRel', EntityType::class, array(
                'class' => TteDepartamento::class,
                'query_builder' => function (EntityRepository $er) use ($user) {
                    return $er->createQueryBuilder('d')
                        ->orderBy('d.nombre', 'ASC');
                },
                'choice_label' => 'nombre',
                'attr' => ['class' => 'form-control']
            ))
            ->add('nombre', TextType::class, ['required' => true, 'attr' => ['class' => 'form-control']])
            ->add('codigoInterface', TextType::class, ['required' => true, 'attr' => ['class' => 'form-control']])
            ->add('codigoOperadorFk', TextType::class, ['required' => true, 'attr' => ['class' => 'form-control']])
            ->add('codigoCiudadOperadorFk', TextType::class, ['required' => true, 'attr' => ['class' => 'form-control']])
            ->add('guardar', SubmitType::class, ['label' => 'Guardar', 'attr' => ['class' => 'btn btn-sm btn-primary float-right']]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TteCiudad::class,
        ]);
    }
}
