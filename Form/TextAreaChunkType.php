<?php

namespace ChunkTypeBundle\Form;

use ChunkTypeBundle\Form\Type\ChunkType;
use Symfony\Component\Form\FormBuilderInterface;

class TextAreaChunkType extends ChunkType
{

  /**
   * {@inheritdoc}
   */
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    parent::buildForm($builder, $options);
    $builder->add('text', 'textarea');
  }

  /**
   * {@inheritdoc}
   */
  public function getName()
  {
    return 'chunk_text_area_type';
  }
}