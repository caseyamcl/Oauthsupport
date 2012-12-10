<?php

namespace OAuth2;

/**
 * Auth Service Abstract Class
 */
abstract class AuthService
{
    /**
     * @var string
     */
    protected $redirectUrl;

    /**
     * @var \Oauth2\Client
     */
    protected $client;

    // -------------------------------------------------------------------------

    /**
     * Constructor
     *
     * @var string $key
     * @var string $secret
     * @var string $redirectUrl
     */
    public function __construct($key, $secret, $redirectUrl)
    {
        //Redirect URL
        $this->redirectUrl = $redirectUrl;

        //Build client
        $this->client = new Client($key, $secret);
    }

    // -------------------------------------------------------------------------

    /**
     * Get user info
     *
     * Return an array:
     *  $array['id'] = SERVICE_USER_ID_STRING_FOR_OAUTH_SERVICE
     * Also include other identifying information
     * (see Entities\User.php for other values)
     *
     * @param string $accessToken
     * @return array
     */
    abstract public function getInfo($accessToken);

    // -------------------------------------------------------------------------

    /**
     * Return authorization URL
     *
     * @return string
     */
    abstract protected function getAuthUrl();

    // -------------------------------------------------------------------------

    /** 
     * Return token URL
     *
     * @return string
     */

    abstract protected function getTokenUrl();

    // -------------------------------------------------------------------------

    /**
     * Get Authorization URL (usually for redirect)
     *
     * @param array $params  Optional key/value query parameters to send
     * @return string
     */
    public function getAuthorizationUrl($params = array())
    {
        return $this->client->getAuthenticationUrl(
            $this->getAuthUrl(),
            $this->redirectUrl,
            $params
        );
    }

  // -------------------------------------------------------------------------

    /**
     * Get Access Token
     * 
     * @param string $code  Access code sent by OAuth provider authorization callback
     * @param array $params Optional array of additional query parameters to send (key/value)
     * @return string
     */
    public function getAccessToken($code, $params = array())
    {
        $params['code']         = $code;
        $params['redirect_uri'] = $this->redirectUrl;

        $response = $this->client->getAccessToken($this->getTokenUrl(), 'authorization_code', $params);
        return $response;
    }
}

/* EOF: AuthService.php */