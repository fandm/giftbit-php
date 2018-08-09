<?php

  if (!function_exists('json_encode')) {
    throw new Exception('Giftbit needs the JSON PHP extension.');
  }

  require(dirname(__FILE__) . '/giftbit/client.php');

  class Giftbit {

    private $client;

    /**
     * Giftbit constructor.
     *
     * @param string $endpoint
     *   Giftbit endpoint URL.
     * @param string $auth_token
     *   Giftbit Auth Token.
     *
     * @throws \Exception
     */
    public function __construct($endpoint, $auth_token) {
      if (!$endpoint)
        throw new Exception("Giftbit Client endpoint parameter is required");
      if (!$auth_token)
        throw new Exception("Giftbit Client auth_token parameter is required");

      $this->client = new Giftbit\Client($endpoint, $auth_token);
    }

    /**
     * Ping call.
     *
     * @param int $http_code
     *   HTTP Response code.
     *
     * @return string
     *   JSON response.
     */
    public function ping(&$http_code = NULL) {
      return $this->client->ping($http_code);
    }

    /**
     * Brands call.
     *
     * @param array $request_data
     *   Request data array. Could contain:
     *   - region,
     *   - max_price_in_cents,
     *   - min_price_in_cents,
     *   - currencyisocode (CAD, USD, AUD),
     *   - search,
     *   - limit (default: 20),
     *   - offset (default: 0).
     * @param int $http_code
     *   HTTP Response code.
     *
     * @return string
     *   JSON response.
     */
    public function brands(array $request_data, &$http_code = NULL) {
      return $this->client->brands($request_data, $http_code);
    }

    /**
     * Get brand.
     *
     * @param string $brand_code
     *   Giftbit brand code.
     * @param int $http_code
     *   HTTP Response code.
     *
     * @return string
     *   JSON response.
     *
     * @throws \Exception
     */
    public function brand($brand_code, &$http_code = NULL) {
      if (!$brand_code)
        throw new Exception("Giftbit Client brand_code parameter is required");

      return $this->client->brand($brand_code, $http_code);
    }

    /**
     * Regions call.
     *
     * @param int $http_code
     *   HTTP Response code.
     *
     * @return string
     *   JSON response.
     */
    public function regions(&$http_code = NULL) {
      return $this->client->regions($http_code);
    }

    /**
     * Create campaign.
     *
     * @param array $request_data
     *   Request data array. Could contain:
     *   - message (required if no supplied gift_template),
     *   - subject (required if no supplied gift_template),
     *   - gift_template (template ID from the Giftbit dashboard),
     *   - delivery_type (SHORTLINK, GIFTBIT_EMAIL),
     *   - link_count (in case of SHORTLINK only),
     *   - contacts (array of contacts with fields:
     *       - email,
     *       - firstname,
     *       - lastname,
     *     ),
     *   - price_in_cents (2500 = $25),
     *   - brand_codes (array of brand codes gotten from /brands API call),
     *   - expiry (YYYY-MM-DD),
     *   - id (just unique string).
     * @param int $http_code
     *   HTTP Response code.
     *
     * @return string
     *   JSON response.
     */
    public function createCampaign(array $request_data, &$http_code = NULL) {
      return $this->client->createCampaign($request_data, $http_code);
    }

    /**
     * Get campaign.
     *
     * @param string $campaign_id
     *   Giftbit campaign ID.
     * @param int $http_code
     *   HTTP Response code.
     *
     * @return string
     *   JSON response.
     *
     * @throws \Exception
     */
    public function getCampaign($campaign_id, &$http_code = NULL) {
      if (!$campaign_id)
        throw new Exception("Giftbit Client campaign_id parameter is required");

      return $this->client->getCampaign($campaign_id, $http_code);
    }

    /**
     * Gifts call.
     *
     * @param array $request_data
     *   Request data array. Could contain:
     *   - uuid,
     *   - campaign_uuid,
     *   - campaign_id,
     *   - price_in_cents_greater_than,
     *   - price_in_cents_less_than,
     *   - recipient_name,
     *   - recipient_email,
     *   - delivery_status (UNSENT, DELIVERED, UNDELIVERABLE,
     *     TEMPORARILY_UNDELIVERABLE, UNSUBSCRIBED, COMPLAINT),
     *   - status (SENT_AND_REDEEMABLE, REDEEMED, TO_CHARITY, GIVER_CANCELLED,
     *     or EXPIRED),
     *   - created_date_greater_than (yyyy-MM-dd HH:mm:ss),
     *   - created_date_less_than (yyyy-MM-dd HH:mm:ss),
     *   - delivery_date_greater_than (yyyy-MM-dd HH:mm:ss),
     *   - delivery_date_less_than (yyyy-MM-dd HH:mm:ss),
     *   - redelivery_count_greater_than,
     *   - redelivery_count_less_than,
     *   - redeemed_date_greater_than (yyyy-MM-dd HH:mm:ss),
     *   - redeemed_date_less_than (yyyy-MM-dd HH:mm:ss),
     *   - limit (default: 20),
     *   - offset (default: 0),
     *   - sort (campaign_id, price_in_cents, recipient_name, recipient_email,
     *     delivery_status, or status),
     *   - order (asc or desc).
     * @param int $http_code
     *   HTTP Response code.
     *
     * @return string
     *   JSON response.
     */
    public function gifts(array $request_data, &$http_code = NULL) {
      return $this->client->gifts($request_data, $http_code);
    }

    /**
     * Get gift.
     *
     * @param string $gift_uuid
     *   Giftbit gift UUID.
     * @param int $http_code
     *   HTTP Response code.
     *
     * @return string
     *   JSON response.
     *
     * @throws \Exception
     */
    public function getGift($gift_uuid, &$http_code = NULL) {
      if (!$gift_uuid)
        throw new Exception("Giftbit Client gift_uuid parameter is required");

      return $this->client->getGift($gift_uuid, $http_code);
    }

    /**
     * Resend gift.
     *
     * @param string $gift_uuid
     *   Giftbit gift UUID.
     * @param int $http_code
     *   HTTP Response code.
     *
     * @return string
     *   JSON response.
     *
     * @throws \Exception
     */
    public function resendGift($gift_uuid, &$http_code = NULL) {
      if (!$gift_uuid)
        throw new Exception("Giftbit Client gift_uuid parameter is required");

      return $this->client->resendGift($gift_uuid, $http_code);
    }

    /**
     * Cancel gift.
     *
     * @param string $gift_uuid
     *   Giftbit gift UUID.
     * @param int $http_code
     *   HTTP Response code.
     *
     * @return string
     *   JSON response.
     *
     * @throws \Exception
     */
    public function cancelGift($gift_uuid, &$http_code = NULL) {
      if (!$gift_uuid)
        throw new Exception("Giftbit Client gift_uuid parameter is required");

      return $this->client->cancelGift($gift_uuid, $http_code);
    }

    /**
     * Get campaign.
     *
     * @param string $campaign_id
     *   Giftbit campaign ID.
     * @param array $request_data
     *   Request data array. Could contain: limit, offset.
     * @param int $http_code
     *   HTTP Response code.
     *
     * @return string
     *   JSON response.
     *
     * @throws \Exception
     */
    public function links($campaign_id, array $request_data, &$http_code = NULL) {
      if (!$campaign_id)
        throw new Exception("Giftbit Client campaign_id parameter is required");

      return $this->client->links($campaign_id, $request_data, $http_code);
    }

    /**
     * Funds call.
     *
     * @param int $http_code
     *   HTTP Response code.
     *
     * @return string
     *   JSON response.
     */
    public function funds(&$http_code = NULL) {
      return $this->client->funds($http_code);
    }

  }
