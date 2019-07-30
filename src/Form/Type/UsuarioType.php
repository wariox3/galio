<?php

namespace App\Form\Type;

use App\Entity\TteEmpresa;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class UsuarioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('username', TextType::class, ['required' => true, 'attr' => ['class' => 'form-control']])
            ->add('password', TextType::class, ['required' => true, 'attr' => ['class' => 'form-control']])
//            ->add('admin', CheckboxType::class, ['required' => true, 'attr' => ['class' => 'form-control']])
            ->add('codigoCiudadFk', TextType::class, ['required' => true, 'attr' => ['class' => 'form-control']])
//            ->add('codigoOperadorFk', TextType::class, ['required' => true, 'attr' => ['class' => 'form-control']])
            ->add('operacion', TextType::class, ['required' => true, 'attr' => ['class' => 'form-control']])
            ->add('codigoCienteFk', TextType::class, ['required' => true, 'attr' => ['class' => 'form-control']])
            ->add('empresaRel', EntityType::class, [
                'class' => TteEmpresa::class,
                'required' => true,
                'query_builder' => function (EntityRepository $er) use ($options) {
                    return $er->createQueryBuilder('em')
                        ->orderBy('em.nombre')
                        ->where("em.codigoOperadorFk = '". $options['data']->getOperadorRel()->getCodigoOperadorPk() ."'");
                }, 'choice_label' => 'nombre',
                'attr' => ['class' => 'form-control']
            ])
            ->add('guardar', SubmitType::class, ['label' => 'Guardar', 'attr' => ['class' => 'btn btn-sm btn-primary ']]);
    }
}
