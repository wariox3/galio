<?php

namespace App\Form\Type;

use App\Entity\TteCiudad;
use App\Entity\TteGuia;
use App\Entity\TteGuiaTipo;
use App\Entity\TteProducto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GuiaType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        global $kernel;
        $user = $kernel->getContainer()->get('security.token_storage')->getToken()->getUser();
        $builder
            ->add('productoRel', EntityType::class, array(
                'required' => true,
                'class' => TteProducto::class,
                'query_builder' => function (EntityRepository $er) use ($options) {
                    return $er->createQueryBuilder('e')
                        ->where("e.codigoEmpresaFk = '{$options['data']->getEmpresaRel()->getCodigoEmpresaPk()}'")
                        ->orderBy('e.orden', 'ASC');
                },
                'choice_label' => 'nombre',
                'attr' => ['class' => 'form-control']

            ))
            ->add('ciudadDestinoRel',EntityType::class,[
                'required' => true,
                'class' => TteCiudad::class,
                'query_builder' => function (EntityRepository $er) use ($user) {
                    return $er->createQueryBuilder('c')
                        ->where("c.codigoOperadorFk = '{$user->getCodigoOperadorFk()}'")
                        ->orderBy('c.nombre', 'ASC');
                },
                'choice_label' => function($er){
                    $ciudad = $er->getNombre();
                    return $ciudad.' - '.$er->getDepartamentoRel()->getNombre();
                },
            ])
            ->add('guiaTipoRel', EntityType::class, array(
                'class' => TteGuiaTipo::class,
                'query_builder' => function (EntityRepository $er) use ($user) {
                    return $er->createQueryBuilder('t')
                        ->orderBy('t.orden', 'ASC');
                },
                'choice_label' => 'nombre',
                'attr' => ['class' => 'form-control']
            ))
            ->add('codigoDestinatarioFk',TextType::class,['attr' => ['class' => 'form-control','style' => 'float: right;'],'required' => false])
            ->add('clienteDocumento', TextType::class,['attr' => ['class' => 'form-control'],'required' => false])
            ->add('remitente', TextType::class,['attr' => ['class' => 'form-control']])
            ->add('destinatarioTelefono', TextType::class,['attr' => ['class' => 'form-control']])
            ->add('destinatarioNombre', TextType::class,['attr' => ['class' => 'form-control']])
            ->add('destinatarioDireccion', TextType::class,['attr' => ['class' => 'form-control']])
            ->add('destinatarioIdentificacion', TextType::class,['attr' => ['class' => 'form-control']])
            ->add('productoReferencia', TextType::class,['required' => false,'attr' => ['class' => 'form-control']])
            ->add('unidades', NumberType::class,['attr' => ['class' => 'form-control',],'required' => true])
            ->add('pesoReal', NumberType::class,['attr' => ['class' => 'form-control']])
            ->add('pesoVolumen', NumberType::class,['attr' => ['class' => 'form-control']])
            ->add('vrDeclara', NumberType::class,['attr' => ['class' => 'form-control']])
            ->add('comentario',TextareaType::class, ['required' => false, 'attr' => ['class' => 'form-control','rows' => '4']])
            ->add('guardar',SubmitType::class,['label' => 'Guardar','attr' => ['class' => 'btn btn-sm btn-primary float-right']]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TteGuia::class,
        ]);
    }
}
