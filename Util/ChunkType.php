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
   * @var string $model
   */
  private $model;

  /**
   * @param string $key
   * @param FormTypeInterface $form
   * @param string $model
   */
  public function __construct($key, $form, $model)
  {
    $this->key = $key;
    $this->form = $form;
    $this->model = $model;
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