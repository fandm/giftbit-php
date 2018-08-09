<?php

  namespace Giftbit;

  class Client {

    private $auth_token;

    public function __construct($auth_token) {
      $this->auth_token = $auth_token;
    }

    public function ping(&$http_code = NULL) {
      $endpoint = "https://api-testbed.giftbit.com/papi/v1/ping";
      $request_data = array(
        'auth_token' => $this->auth_token,
      );

      return $this->_send($endpoint, $request_data, 'get', $http_code);
    }

    private function _send($endpoint, $request_data, $request_type = 'post', &$http_code = NULL) {
      $auth_token = '';
      if (isset($request_data['auth_token'])) {
        $auth_token = $request_data['auth_token'];
        unset($request_data['auth_token']);
      }
      $request_data = json_encode($request_data);

      $headers = array(
        'Accept: application/json',
        'Content-Type: application/json',
        'Authorization: Bearer ' . $auth_token,
      );

      $handle = curl_init();
      curl_setopt($handle, CURLOPT_URL, $endpoint);
      curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($handle, CURLOPT_RETURNTRANSFER, TRUE);
      curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, FALSE);
      curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, FALSE);
      switch ($request_type) {
        case 'post':
          curl_setopt($handle, CURLOPT_POST, TRUE);
          break;

        case 'put':
          curl_setopt($handle, CURLOPT_CUSTOMREQUEST, "PUT");
          break;
      }
      curl_setopt($handle, CURLOPT_POSTFIELDS, $request_data);

      $result = curl_exec($handle);
      $http_code = curl_getinfo($handle, CURLINFO_HTTP_CODE);
      curl_close($handle);

      return $result;
    }

  }
