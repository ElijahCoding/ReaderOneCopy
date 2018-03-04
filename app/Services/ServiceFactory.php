<?php

namespace App\Services;

class ServiceFactory
{
  public function get($service, $limit = 10)
  {
    if (method_exists($this, $service)) {
      return $this->{$service}($limit);
    }
  }

  protected function hackernews($limit = 10)
  {
    return 'hacker news';
  }
}
