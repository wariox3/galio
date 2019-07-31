<?php

namespace App\Form\Type;

use App\Entity\TteCiudad;
use App\Entity\TteDestinatario;
use App\Entity\TteEmpresa;
use App\Entity\TteIdentificacionTipo;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DestinatarioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        global $kernel;
        $user = $kernel->getContainer()->get('security.token_storage')->getToken()->getUser();
        $builder
            ->add('numeroIdentificacion', TextType::class, ['required' => true, 'attr' => ['class' => 'form-control']])
            ->add('digitoVerificacion', IntegerType::class, ['required' => false, 'attr' => ['class' => 'form-control']])
            ->add('nombreCorto', TextType::class, ['required' => true, 'attr' => ['class' => 'form-control']])
            ->add('nombre1', TextType::class, ['required' => false, 'attr' => ['class' => 'form-control']])
            ->add('nombre2', TextType::class, ['required' => false, 'attr' => ['class' => 'form-control']])
            ->add('apellido1', TextType::class, ['required' => false, 'attr' => ['class' => 'form-control']])
            ->add('apellido2', TextType::class, ['required' => false, 'attr' => ['class' => 'form-control']])
            ->add('direccion', TextType::class, ['required' => true, 'attr' => ['class' => 'form-control']])
            ->add('barrio', TextType::class, ['required' => false, 'attr' => ['class' => 'form-control']])
            ->add('telefono', TextType::class, ['required' => true, 'attr' => ['class' => 'form-control']])
            ->add('correo', TextType::class, ['required' => false, 'attr' => ['class' => 'form-control']])
            ->add('ciudadRel', EntityType::class, [
                'class' => TteCiudad::class,
                'query_builder' => function (EntityRepository $er) use ($user) {
                    return $er->createQueryBuilder('er')
                        ->where("er.codigoOperadorFk = '{$user->getCodigoOperadorFk()}'")
                        ->orderBy('er.nombre');
                }, 'choice_label' => 'nombre',
                'required' => true,
                'attr' => ['class' => 'form-control']
            ])
            ->add('guardar', SubmitType::class, ['label' => 'Guardar', 'attr' => ['class' => 'btn btn-sm btn-primary float-right']]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TteDestinatario::class,
        ]);
    }
}
