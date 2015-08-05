<?php

namespace ChunkTypeBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class ChunkTypeBundle extends Bundle
{
  public function build(ContainerBuilder $container)
  {
    parent::build($container);
    $container->addCompilerPass(new ChunkTypeCompilerPass());
  }
}
