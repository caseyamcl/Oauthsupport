<?php

/**
 * A class for implementing a Signature Method
 *
 * See section 9 ("Signing Requests") in the OAuth Spec
 * @link http://oauth.net/core/1.0/#signing_process
 */
abstract class OAuthSignatureMethod {

  /**
   * Needs to return the name of the Signature Method (ie HMAC-SHA1)
   * @return string
   */
  abstract public function get_name();

  /**
   * Build up the signature
   * NOTE: The output of this function MUST NOT be urlencoded.
   * the encoding is handled in OAuthRequest when the final
   * request is serialized
   * @param OAuthRequest $request
   * @param OAuthConsumer $consumer
   * @param OAuthToken $token
   * @return string
   */
  abstract public function build_signature($request, $consumer, $token);

  /**
   * Verifies that a given signature is correct
   * @param OAuthRequest $request
   * @param OAuthConsumer $consumer
   * @param OAuthToken $token
   * @param string $signature
   * @return bool
   */
  public function check_signature($request, $consumer, $token, $signature) {
    $built = $this->build_signature($request, $consumer, $token);

    // Check for zero length, although unlikely here
    if (drupal_strlen($built) == 0 || drupal_strlen($signature) == 0) {
      return FALSE;
    }

    if (drupal_strlen($built) != drupal_strlen($signature)) {
      return FALSE;
    }

    // Avoid a timing leak with a (hopefully) time insensitive compare
    $result = 0;
    for ($i = 0; $i < drupal_strlen($signature); $i++) {
      $result |= ord($built{$i}) ^ ord($signature{$i});
    }

    return $result == 0;
  }
}

/* EOF: OAuthSignatureMethod.php */