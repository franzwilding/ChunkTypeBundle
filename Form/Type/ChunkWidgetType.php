<?php

namespace ChunkTypeBundle\Form\Type;

use ChunkTypeBundle\EventListener\AddChunkFormListener;
use ChunkTypeBundle\Util\ChunkManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class ChunkWidgetType extends AbstractType
{

  /**
   * @var ChunkManager $chunkManager
   */
  private $chunkManager;

  public function __construct(ChunkManager $chunkManager)
  {
    $this->chunkManager = $chunkManager;
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $choices = array();

    $builder->add('id', 'hidden');
    $builder->add('weight', 'hidden');
    $builder->add('chunkType', 'choice', array(
      'choices'   => $this->chunkManager->getChunkOptions(),
      'multiple'  => false,
      'expanded'  => true,
      'mapped'    => false,
      'required'  => true,
    ));
    $builder->addEventSubscriber(new AddChunkFormListener($this->chunkManager));
  }

  /**
   * {@inheritdoc}
   */
  public function setDefaultOptions(OptionsResolverInterface $resolver)
  {
    $resolver->setDefaults(array(
      'label' => false,
    ));
  }

  /**
   * {@inheritdoc}
   */
  public function getName()
  {
    return 'chunk_widget_type';
  }
}