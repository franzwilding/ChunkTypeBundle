<?php

namespace ChunkTypeBundle\EventListener;

use ChunkTypeBundle\Util\ChunkManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpFoundation\Request;

class AddChunkFormListener implements EventSubscriberInterface
{

  /**
   * @var ChunkManager $chunkManager
   */
  private $chunkManager;

  /**
   * @var array $chunks
   */
  private $chunks;

  /**
   * @var Request $request
   */
  private $request;

  public function __construct(ChunkManager $chunkManager, $chunks, Request $request)
  {
    $this->chunkManager = $chunkManager;
    $this->chunks = $chunks;
    $this->request = $request;
  }

  public static function getSubscribedEvents() {
    return array(
      FormEvents::PRE_SET_DATA => 'onPreSetData',
    );
  }

  private function findFormTrail(FormInterface $form) {
    $trail = array($form->getName());
    if ($form->getParent()) {
      $trail = array_merge($trail, $this->findFormTrail($form->getParent()));
    }
    return $trail;
  }

  private function findChunkType($trail, $data)
  {
    while(count($trail) > 0) {
      $element = array_pop($trail);
      if(array_key_exists($element, $data)) {
        $data = $data[$element];
      } else {
        return false;
      }
    }
    return $data;
  }

  /**
   * @param FormEvent $event
   *
   * Add the corresponding chunk form type for the given chunk type.
   */
  public function onPreSetData(FormEvent $event)
  {
    $form = $event->getForm();
    $type_field_key = 'chunk_widget_chunk_type';

    if($rData = $this->findChunkType($this->findFormTrail($form), $this->request->request->all())) {
      if(array_key_exists($type_field_key, $rData)) {
        $event->setData(array($type_field_key => $rData[$type_field_key]));
      }
    }

    $data = $event->getData();
    $chunkType = $this->chunkManager->getChunkFormType($data['chunk_widget_chunk_type']);

    // If no chunk type is selected, we need to delete the chunk child form.
    if(!$chunkType) {
      $form->add($type_field_key, 'choice', array(
        'choices'   => $this->chunkManager->getChunkOptions($this->chunks),
        'multiple'  => false,
        'expanded'  => true,
        'mapped'    => false,
        'required'  => true,
      ));

      $form->remove('chunk');
      return;
    }

    // save type
    $form->add('chunk_widget_chunk_type', 'hidden');
    $form->add('preview', 'checkbox', array('required' => false));

    // add the chunk type form as inherited child of this widget.
    $form->add('chunk', $chunkType, array('inherit_data' => false, 'attr' => array('class' => 'chunk_holder')));
  }
}