<?php
declare(strict_types=1);

namespace App\Form;

use App\Entity\Apartment;
use App\Entity\Floor;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class ApartmentType extends AbstractType
{
    const CONSTRAINT_MESSAGE = 'Моля, попълнете!';

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $constraintOptions = ['message' => self::CONSTRAINT_MESSAGE];
        $builder->add('name', TextType::class, [
            'label' => false,
            'required' => true,
            'constraints' => new NotBlank($constraintOptions)
        ]);
        $builder->add('buildingArea', IntegerType::class, [
            'label' => false,
            'required' => true,
            'constraints' => new NotBlank($constraintOptions)
        ]);
        $builder->add('totalParts', IntegerType::class, [
            'label' => false,
            'required' => false,
        ]);
        $builder->add('totalArea', IntegerType::class, [
            'label' => false,
            'required' => true,
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
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Apartment::class
        ]);
    }
}
