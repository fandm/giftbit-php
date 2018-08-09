<?php

  namespace Giftbit;

  class Client {

    private $endpoint;
    private $authToken;

    public function __construct($endpoint, $auth_token) {
      $this->endpoint = $endpoint;
      $this->authToken = $auth_token;
    }

    public function ping(&$http_code = NULL) {
      $endpoint = $this->endpoint . '/ping';

      return $this->_send($endpoint, array(), $http_code);
    }

    public function brands(array $request_data, &$http_code = NULL) {
      $endpoint = $this->endpoint . '/brands';

      return $this->_send($endpoint, $request_data, $http_code);
    }

    public function brand($brand_code, &$http_code = NULL) {
      $endpoint = $this->endpoint . '/brands/' . $brand_code;

      return $this->_send($endpoint, array(), $http_code);
    }

    public function regions(&$http_code = NULL) {
      $endpoint = $this->endpoint . '/regions';

      return $this->_send($endpoint, array(), $http_code);
    }

    public function createCampaign(array $request_data, &$http_code = NULL) {
      $endpoint = $this->endpoint . '/campaign';

      return $this->_send($endpoint, $request_data, $http_code, 'post');
    }

    public function getCampaign($campaign_id, &$http_code = NULL) {
      $endpoint = $this->endpoint . '/campaign/' . $campaign_id;

      return $this->_send($endpoint, array(), $http_code);
    }

    public function gifts(array $request_data, &$http_code = NULL) {
      $endpoint = $this->endpoint . '/gifts';

      return $this->_send($endpoint, $request_data, $http_code);
    }

    public function getGift($gift_uuid, &$http_code = NULL) {
      $endpoint = $this->endpoint . '/gifts/' . $gift_uuid;

      return $this->_send($endpoint, array(), $http_code);
    }

    public function resendGift($gift_uuid, &$http_code = NULL) {
      $endpoint = $this->endpoint . '/gifts/' . $gift_uuid;
      $request_data = array(
        'resend' => TRUE,
      );

      return $this->_send($endpoint, $request_data, $http_code, 'put');
    }

    public function cancelGift($gift_uuid, &$http_code = NULL) {
      $endpoint = $this->endpoint . '/gifts/' . $gift_uuid;

      return $this->_send($endpoint, array(), $http_code, 'delete');
    }

    public function links($campaign_id, array $request_data, &$http_code = NULL) {
      $endpoint = $this->endpoint . '/links/' . $campaign_id;

      return $this->_send($endpoint, $request_data, $http_code);
    }

    public function funds(&$http_code = NULL) {
      $endpoint = $this->endpoint . '/funds';

      return $this->_send($endpoint, array(), $http_code);
    }

    private function _send($endpoint, array $request_data, &$http_code = NULL, $request_type = 'get') {
      if (isset($request_data['auth_token'])) {
        unset($request_data['auth_token']);
      }

      $headers = array(
        'Accept: application/json',
        'Content-Type: application/json',
        'Authorization: Bearer ' . $this->authToken,
      );

      $handle = curl_init();
      curl_setopt($handle, CURLOPT_HEADER, FALSE);
      curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($handle, CURLOPT_RETURNTRANSFER, TRUE);
      curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, FALSE);
      curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, FALSE);
      switch ($request_type) {
        case 'get':
          $query = http_build_query($request_data);
          curl_setopt($handle, CURLOPT_URL, $endpoint . '?' . $query);
          break;

        case 'post':
          curl_setopt($handle, CURLOPT_URL, $endpoint);
          curl_setopt($handle, CURLOPT_POST, TRUE);
          if (!empty($request_data)) {
            $request_data = json_encode($request_data);
            curl_setopt($handle, CURLOPT_POSTFIELDS, $request_data);
          }
          break;

        case 'put':
          curl_setopt($handle, CURLOPT_URL, $endpoint);
          curl_setopt($handle, CURLOPT_CUSTOMREQUEST, 'PUT');
          if (!empty($request_data)) {
            $request_data = json_encode($request_data);
            curl_setopt($handle, CURLOPT_POSTFIELDS, $request_data);
          }
          break;

        case 'delete':
          curl_setopt($handle, CURLOPT_URL, $endpoint);
          curl_setopt($handle, CURLOPT_CUSTOMREQUEST, 'DELETE');
          if (!empty($request_data)) {
            $request_data = json_encode($request_data);
            curl_setopt($handle, CURLOPT_POSTFIELDS, $request_data);
          }
          break;
      }

      $result = curl_exec($handle);
      $http_code = curl_getinfo($handle, CURLINFO_HTTP_CODE);
      curl_close($handle);

      return $result;
    }

  }
