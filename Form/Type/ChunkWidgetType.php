<?php

namespace ChunkTypeBundle\Form\Type;

use ChunkTypeBundle\EventListener\AddChunkFormListener;
use ChunkTypeBundle\Util\ChunkManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class ChunkWidgetType extends AbstractType
{

  /**
   * @var ChunkManager $chunkManager
   */
  private $chunkManager;

  /**
   * @var RequestStack $requestStack
   */
  private $requestStack;

  public function __construct(ChunkManager $chunkManager, RequestStack $requestStack)
  {
    $this->chunkManager = $chunkManager;
    $this->requestStack = $requestStack;
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder->addEventSubscriber(new AddChunkFormListener($this->chunkManager, $options['chunks'], $this->requestStack->getCurrentRequest()));
  }

  /**
   * {@inheritdoc}
   */
  public function buildView(FormView $view, FormInterface $form, array $options)
  {
    if($form->getData() && array_key_exists('preview', $form->getData())) {
      $view->vars['preview'] = $form->getData()['preview'];
    }
  }

  /**
   * {@inheritdoc}
   */
  public function setDefaultOptions(OptionsResolverInterface $resolver)
  {
    $resolver->setDefaults(array(
      'chunks' => array(),
    ));
  }

  /**
   * {@inheritdoc}
   */
  public function getName()
  {
    return 'chunk';
  }
}