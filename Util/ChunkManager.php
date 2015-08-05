<?php

namespace ChunkTypeBundle\Util;

use ChunkTypeBundle\Model\ChunkInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormTypeInterface;

class ChunkManager
{

  /**
   * @var ArrayCollection|ChunkType[]
   */
  private $chunkTypes;

  /**
   * @var EntityManager $entityManager
   */
  private $entityManager;

  public function __construct(EntityManager $entityManager)
  {
    $this->chunkTypes = new ArrayCollection();
    $this->entityManager = $entityManager;
  }

  /**
   * @param string $key
   * @param FormTypeInterface $form
   * @param string $model
   */
  public function registerChunkType($key, $form, $model)
  {
    $this->chunkTypes->set($key, new ChunkType($key, $form, $model));
  }

  /**
   * Returns all chunks as options.
   *
   * @return array
   */
  public function getChunkOptions()
  {
    $options = array();
    foreach($this->chunkTypes as $type)
    {
      $options[$type->getKey()] = $type->getKey();
    }
  }

  /**
   * Returns a found chunk form type by type key or null, if none was found.
   * @param string $key
   * @return FormTypeInterface|null
   */
  public function getChunkFormType($key)
  {
    /**
     * @var ChunkType $chunkType
     */
    if($chunkType = $this->chunkTypes->get($key)) {
      return $chunkType->getForm();
    }

    return null;
  }

  /**
   * Returns a found chunk by id or null, if none was found.
   *
   * @param int $id
   * @return ChunkInterface
   */
  public function getChunk($id)
  {
    return $this->entityManager->getRepository('TODO')->find($id);
  }
}