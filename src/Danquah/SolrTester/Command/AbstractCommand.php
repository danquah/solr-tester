<?php

namespace Danquah\SolrTester\Command;

use Symfony\Component\Console\Command\Command;

class AbstractCommand extends Command
{
  /**
   * @var \Symfony\Component\Console\Input\InputInterface
   */
  protected $input;

  /**
   * @var \Symfony\Component\Console\Output\OutputInterface
   */
  protected $output;

  protected $configuration;

  public function __construct(array $configuration = [])
  {
    $this->configuration = $configuration;
    parent::__construct();
  }
}
