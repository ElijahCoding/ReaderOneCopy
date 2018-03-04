<?php

namespace App\Services;

use App\Services\HackerNews;
use App\Services\Transformers\HackerNewsTransformer;
use GuzzleHttp\Client as Guzzle;

class ServiceFactory
{
  protected $client;

  public function __construct(Guzzle $client)
  {
    $this->client = $client;
  }

  public function get($service, $limit = 10)
  {
    if (method_exists($this, $service)) {
      return $this->{$service}($limit);
    }
  }

  protected function hackernews($limit = 10)
  {
    $data = (new HackerNews($this->client))->get($limit);

    return (new HackerNewsTransformer($data))->create();
  }

    protected function sortResponseByTimestamp(array $data)
    {
        usort($data, function ($a, $b) {
            return $a['timestamp'] - $b['timestamp'];
        });

        return $data;
    }
}
