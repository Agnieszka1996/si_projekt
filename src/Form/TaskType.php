<?php
/**
 * Task type.
 */

namespace App\Form;

use App\Entity\Task;
use App\Form\DataTransformer\TagsDataTransformer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class TaskType.
 */
class TaskType extends AbstractType
{
    /**
     * Tags data transformer.
     *
     * @var \App\Form\DataTransformer\TagsDataTransformer
     */
    private $tagsDataTransformer;

    /**
     * TaskType constructor.
     *
     * @param \App\Form\DataTransformer\TagsDataTransformer $tagsDataTransformer Tags data transformer
     */
    public function __construct(TagsDataTransformer $tagsDataTransformer)
    {
        $this->tagsDataTransformer = $tagsDataTransformer;
    }

    /**
     * Builds the form.
     *
     * This method is called for each type in the hierarchy starting from the
     * top most type. Type extensions can further modify the form.
     *
     * @see FormTypeExtensionInterface::buildForm()
     *
     * @param \Symfony\Component\Form\FormBuilderInterface $builder The form builder
     * @param array                                        $options The options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add(
            'name',
            TextType::class,
            [
                'label' => 'label_name',
                'required' => true,
                'attr' => ['max_length' => 45],
            ]
        );

        $builder
            ->add('term', DateType::class, [
                'label' => 'label_term',
                'required' => true,
            ]);

        $builder->add(
            'alarm',
            EntityType::class,
            [
                'label' => 'label_alarm',
                'required' => true,
                'class' => 'App\Entity\Alarm',
                'choice_label' => 'name',
            ]
        );

        $builder->add(
            'description',
            TextType::class,
            [
                'label' => 'label_description',
                'required' => true,
                'attr' => ['max_length' => 255],
            ]
        );

        $builder->add(
            'priority',
            EntityType::class,
            [
                'label' => 'label_priority',
                'required' => true,
                'class' => 'App\Entity\Priority',
                'choice_label' => 'name',
            ]
        );

        $builder->add(
            'category',
            EntityType::class,
            [
                'label' => 'label_category',
                'required' => true,
                'class' => 'App\Entity\Category',
                'choice_label' => 'name',
            ]
        );

        $builder->add(
            'tags',
            TextType::class,
            [
                'label' => 'label_tags',
                'required' => false,
                'attr' => ['max_length' => 128],
            ]
        );

        $builder->get('tags')->addModelTransformer(
            $this->tagsDataTransformer
        );
    }

    /**
     * Configures the options for this type.
     *
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver The resolver for the options
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => Task::class]);
    }

    /**
     * Returns the prefix of the template block name for this type.
     *
     * The block prefix defaults to the underscored short class name with
     * the "Type" suffix removed (e.g. "UserProfileType" => "user_profile").
     *
     * @return string The prefix of the template block name
     */
    public function getBlockPrefix(): string
    {
        return 'task';
    }
}
