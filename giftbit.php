<?php

  if (!function_exists('json_encode')) {
    throw new Exception('Giftbit needs the JSON PHP extension.');
  }

  require(dirname(__FILE__) . '/giftbit/client.php');

  class Giftbit {

    private $client;

    /**
     * @throws \Exception
     */
    public function __construct($auth_token) {
      if (!$auth_token)
        throw new Exception("Giftbit Client auth_token parameter is required");

      $this->client = new Giftbit\Client($auth_token);
    }

    public function ping(&$http_code = NULL) {
      return $this->client->ping($http_code);
    }

  }
