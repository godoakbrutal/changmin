<?php

namespace PhpMob\Grid\FieldType;

use Sylius\Component\Grid\DataExtractor\DataExtractorInterface;
use Sylius\Component\Grid\Definition\Field;
use Sylius\Component\Grid\FieldTypes\FieldTypeInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TplFieldType implements FieldTypeInterface
{
    /**
     * @var DataExtractorInterface
     */
    private $dataExtractor;

    /**
     * @var \Twig_Environment
     */
    private $twig;

    /**
     * @param DataExtractorInterface $dataExtractor
     * @param \Twig_Environment $twig
     */
    public function __construct(DataExtractorInterface $dataExtractor, \Twig_Environment $twig)
    {
        $this->dataExtractor = $dataExtractor;
        $this->twig = $twig;
    }

    /**
     * {@inheritdoc}
     */
    public function render(Field $field, $data, array $options)
    {
        if ('.' !== $field->getPath()) {
            $data = $this->dataExtractor->get($field, $data);
        }

        return $this->twig->render($options['template'], ['data' => $data, 'options' => $options]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired('template');
        $resolver->setAllowedTypes('template', 'string');

        $resolver->setDefined('vars');
        $resolver->setAllowedTypes('vars', 'array');

        $resolver->setDefaults([
            'width' => 'auto',
            'align' => 'left',
        ]);

        $resolver->setAllowedTypes('align', 'string');
        $resolver->setAllowedTypes('width', 'string');
    }
}
