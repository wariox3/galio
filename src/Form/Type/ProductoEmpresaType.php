<?php

namespace App\Form\Type;

use App\Entity\TteCiudad;
use App\Entity\TteGuia;
use App\Entity\TteGuiaTipo;
use App\Entity\TteProducto;
use App\Entity\TteProductoEmpresa;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductoEmpresaType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        global $kernel;
        $user = $kernel->getContainer()->get('security.token_storage')->getToken()->getUser();
        $builder
            ->add('productoRel', EntityType::class, array(
                'class' => TteProducto::class,
                'query_builder' => function (EntityRepository $er) use ($user) {
                    return $er->createQueryBuilder('e')
                        ->where("e.codigoOperadorFk = '{$user->getCodigoOperadorFk()}'")
                        ->orderBy('e.orden', 'ASC');
                },
                'choice_label' => 'nombre',
                'attr' => ['class' => 'form-control to-select-2']
            ))
            ->add('guardar',SubmitType::class,['label' => 'Guardar','attr' => ['class' => 'btn btn-sm btn-primary float-right']]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TteProductoEmpresa::class,
        ]);
    }
}
