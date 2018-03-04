<?php

namespace App\Services;

use App\Services\HackerNews;
use App\Services\Transformers\RedditTransformer;
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
      return $this->sortResponseByTimestamp($this->{$service}($limit));
    }
  }

  protected function hackernews($limit = 10)
  {
    $data = json_encode((new HackerNews($this->client))->get($limit));

     return (new HackerNewsTransformer(json_decode($data)))->create();
  }

  protected function reddit($limit = 10)
  {
    $data = json_encode((new Reddit($this->client))->get($limit));

    return (new RedditTransformer(json_decode($data)))->create();
  }

    protected function sortResponseByTimestamp(array $data)
    {
        usort($data, function ($a, $b) {
            return $a['timestamp'] - $b['timestamp'];
        });

        return $data;
    }
}
