<?php

namespace ChunkTypeBundle\Util;

use Symfony\Component\Form\FormTypeInterface;

class ChunkType
{
  /**
   * @var string $key
   */
  private $key;

  /**
   * @var FormTypeInterface $form
   */
  private $form;


  /**
   * @param string $key
   * @param FormTypeInterface $form
   */
  public function __construct($key, $form)
  {
    $this->key = $key;
    $this->form = $form;
  }

  /**
   * @return string
   */
  public function getKey()
  {
    return $this->key;
  }

  /**
   * @return FormTypeInterface
   */
  public function getForm()
  {
    return $this->form;
  }
}