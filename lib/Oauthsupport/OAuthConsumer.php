<?php

/**
 * OAuth Consumer
 *
 * Stores the API Key, Secret, and optionally, a callback URL
 */
class OAuthConsumer {

  public $key;
  public $secret;
  public $callback_url;

  function __construct($key, $secret, $callback_url=NULL) {
    $this->key = $key;
    $this->secret = $secret;
    $this->callback_url = $callback_url;
  }

  function __toString() {
    return "OAuthConsumer[key=$this->key,secret=$this->secret]";
  }
}

/* EOF: OAuthConsumer.php */