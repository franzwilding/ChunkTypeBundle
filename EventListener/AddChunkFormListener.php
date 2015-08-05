<?php

namespace ChunkTypeBundle\EventListener;

use ChunkTypeBundle\Util\ChunkManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class AddChunkFormListener implements EventSubscriberInterface
{

  /**
   * @var ChunkManager $chunkManager
   */
  private $chunkManager;

  public function __construct(ChunkManager $chunkManager)
  {
    $this->chunkManager = $chunkManager;
  }

  public static function getSubscribedEvents() {
    return array(
      FormEvents::PRE_SET_DATA => 'onPreSetData',
    );
  }

  /**
   * @param FormEvent $event
   *
   * Add the corresponding chunk form type for the given chunk type.
   */
  public function onPreSetData(FormEvent $event)
  {
    $form = $event->getForm();
    $data = $event->getData();
    $chunkType = $this->chunkManager->getChunkFormType($data['chunkType']);

    // If no chunk type is selected, we need to delete the chunk child form.
    if(!$chunkType) {
      $form->remove('chunk');
      return;
    }

    // add the chunk type form as inherited child of this widget.
    $form->add('chunk', $chunkType, array('inherit_data' => true));

  }
}