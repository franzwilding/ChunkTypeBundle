<?php

namespace ChunkTypeBundle\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\InheritanceType("JOINED")
 * @ORM\Table(name="chunk")
 * @ORM\DiscriminatorColumn(name="chunk_type", type="string")
 */
abstract class Chunk implements ChunkInterface
{

  /**
   * @var int
   *
   * @ORM\Column(type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  protected $id;

  /**
   * @var int
   *
   * @ORM\Column(type="integer")
   */
  protected $weight;

  public function __construct() {
    $this->weight = 0;
  }

  /**
   * @param $id
   * @return Chunk
   */
  public function setId($id)
  {
    $this->id = $id;
    return $this;
  }

  /**
   * @return int
   */
  public function getId()
  {
    return $this->id;
  }

  /**
   * @param integer $weight
   * @return Chunk
   */
  public function setWeight($weight)
  {
    $this->weight = $weight;
    return $this;
  }

  /**
   * @return int
   */
  public function getWeight()
  {
    return $this->weight;
  }
}