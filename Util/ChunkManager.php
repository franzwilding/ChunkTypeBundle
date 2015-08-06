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
   */
  public function registerChunkType($key, $form)
  {
    $this->chunkTypes->set($key, new ChunkType($key, $form));
  }

  /**
   * Returns all chunks as options.
   *
   * @param array $keys
   * @return array
   */
  public function getChunkOptions($keys = array())
  {
    $options = array();
    foreach($keys as $key)
    {
      if($this->chunkTypes->containsKey($key)) {
        $options[$key] = $key;
      }
    }
    return $options;
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