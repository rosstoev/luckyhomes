<?php
declare(strict_types=1);

namespace App\Form;

use App\Entity\Apartment;
use App\Entity\Floor;
use App\Entity\Image;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\Loader\CallbackChoiceLoader;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class ApartmentType extends AbstractType
{
    private const CONSTRAINT_MESSAGE = 'Моля, попълнете!';
    private const PATH_TO_IMG = '/assets/img/apartamenti/';

    /**
     * @var string
     */
    private $pathToImages;

    public function __construct(ContainerInterface $container)
    {
        $this->pathToImages = $container->getParameter('apartments_directory');
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $constraintOptions = ['message' => self::CONSTRAINT_MESSAGE];
        $edit = $options['edit'];
        $builder->add('name', TextType::class, [
            'label' => false,
            'required' => true,
            'constraints' => new NotBlank($constraintOptions)
        ]);
        $builder->add('buildingArea', NumberType::class, [
            'label' => false,
            'input' => 'number',
            'scale' => 1,
            'required' => true,
            'constraints' => new NotBlank($constraintOptions)
        ]);
        $builder->add('totalParts', NumberType::class, [
            'label' => false,
            'required' => false,
            'input' => 'number',
            'scale' => 1,
        ]);
        $builder->add('totalArea', NumberType::class, [
            'label' => false,
            'required' => true,
            'input' => 'number',
            'scale' => 1,
        ]);
        $builder->add('priceUnfinish', MoneyType::class, [
            'label' => false,
            'required' => false,
            'currency' => 'BGN',
            'scale' => 0,

        ]);
        $builder->add('priceFinish', MoneyType::class, [
            'label' => false,
            'required' => false,
            'currency' => 'BGN',
            'scale' => 0,
        ]);
        $builder->add('priceRent', MoneyType::class, [
            'label' => false,
            'required' => false,
            'currency' => 'BGN',
            'scale' => 0,
        ]);
        $builder->add('status', TextType::class, [
            'label' => false,
            'required' => false,

        ]);
        $builder->add('floor', EntityType::class, [
            'class' => Floor::class,
            'choice_label' => 'name',
            'choice_value' => 'id',
            'required' => true,
            'label' => false,
            'placeholder' => '- Избери -',
            'constraints' => new NotBlank($constraintOptions)
        ]);
        $builder->add('additionalInfo', TextareaType::class, [
            'required' => false,
            'label' => false,
            'row_attr' => ['rows' => '3'],
        ]);
        $builder->add('images', FileType::class, [
            'multiple' => true,
            'mapped' => false,
            'label' => false,
            'required' => false,

        ]);
        if($edit == true){
            /** @var Apartment $apartment */
            $apartment = $builder->getData();

            $builder->add('linkImage', EntityType::class, [
                'class' => Image::class,
                'choices' => $apartment->getImages()->getValues(),
                'choice_value'=> 'id',
                'choice_label' => 'name',
                'placeholder' => '--ИЗБЕРИ--',
                'required' => false,
                'label' => false,
            ]);
        }

        $builder->addEventListener(FormEvents::PRE_SET_DATA, [$this, 'preSetData']);
    }

    public function preSetData(FormEvent $event)
    {
        /** @var Apartment $apartment */
        $apartment = $event->getData();
        $form = $event->getForm();
        $pathToImages = $this->pathToImages;

        if($apartment){
            /** @var Image $images */
            $images = $apartment->getImages()->getValues();
            if($images){
                $form->add('deleteImages', ChoiceType::class, [
                    'required' => false,
                    'mapped' => false,
                    'choices' => $images,
                    'choice_value' => 'name',
                    'choice_label' => 'name',
                    'choice_attr' => function(Image $choice, $key, $value)use($pathToImages){
                        $imgAddress = self::PATH_TO_IMG . $choice->getApartment()->getId(). '/' . $choice->getName();
                        return ['data-img-src' => $imgAddress];
                    },
                    'label' => false,
                    'multiple' => true,
                    'attr' => ['id' => 'image-picker'],

                ]);
            }

        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Apartment::class,
            'edit' => null
        ]);
    }
}
