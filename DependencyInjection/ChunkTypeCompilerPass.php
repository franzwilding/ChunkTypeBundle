<?php

namespace ChunkTypeBundle;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use Symfony\Component\DependencyInjection\Reference;

class ChunkTypeCompilerPass implements CompilerPassInterface
{

  /**
   * @var array
   */
  private $requiredAttributes = array('form', 'model');


  public function __construct()
  {
    ksort($this->requiredAttributes);
  }

  /**
   * You can modify the container here before it is dumped to PHP code.
   *
   * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
   * @throws InvalidArgumentException if path is not defined.
   */
  public function process(ContainerBuilder $container)
  {
    if (!$container->hasDefinition('chunk.manager')) {
      return;
    }

    $definition = $container->getDefinition('chunk.manager');
    $taggedServices = $container->findTaggedServiceIds('chunk.type');

    foreach ($taggedServices as $key => $tags) {
      foreach ($tags as $attributes) {

        ksort($attributes);

        if(array_keys($attributes) != $this->requiredAttributes) {
          throw new \Symfony\Component\OptionsResolver\Exception\InvalidArgumentException('One or more attributes are missing. Required attributes: ' . join(', ', $this->requiredAttributes));
        }

        // add key attribute
        $attr = array($key);

        // add all other attributes as config
        $attr[] = $attributes;

        $definition->addMethodCall('registerChunkType', $attr);
      }
    }
  }
}