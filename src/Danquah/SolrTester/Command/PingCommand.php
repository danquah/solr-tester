<?php

namespace Danquah\SolrTester\Command;


use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class PingCommand extends AbstractCommand {

	protected $virtualHostConfiguration = array();

	protected function configure() {
		$this
			->setName('ping')
			->setDescription('Ping an solr server')
			->addArgument('url', InputArgument::REQUIRED);
	}

	protected function execute(InputInterface $input, OutputInterface $output) {
		$this->input = $input;
		$this->output = $output;

    $parts = parse_url($input->getArgument('url'));

    $config = array(
      'adapteroptions' => array(
        'host' => $parts['host'],
        'port' => isset($parts['port']) ? $parts['port'] : 80,
        'path' => $parts['path'],
      )
    );

    $client = New \Solarium_Client($config);
    $ping = $client->createPing();
    $q_start = microtime(TRUE);
    $response = $client->execute($ping);
    $client_query_time = round((microtime(TRUE) - $q_start) * 1000, 1) . 'ms';

    $body = $response->getResponse()->getBody();
    if (!empty($body)) {
      $data = json_decode($body);
      $status = isset($data->status) ? $data->status : 'Unknown';
      $server_query_time = isset($data->responseHeader->QTime) ? $data->responseHeader->QTime . 'ms' : 'Unknown';

      $output->writeln("Ping status $status completed in (client/server) $client_query_time/$server_query_time");
    }
	}
}

