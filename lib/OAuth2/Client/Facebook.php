<?php 

namespace OAuth2\Client;
use OAuth2\AuthService;

/**
 * Facebook OAUTH 2.0 Client Class
 */
class Facebook extends AuthService
{
    protected function getAuthUrl()
    {
        return 'https://www.facebook.com/dialog/oauth';
    }

    // -------------------------------------------------------------------------

    protected function getTokenurl()
    {
        return 'https://graph.facebook.com/oauth/access_token';
    }

    // -------------------------------------------------------------------------

    public function getAuthorizationUrl($params = array())
    {
        $params['state'] = md5(session_id());
        $params['scope'] = 'email';
        return parent::getAuthorizationUrl($params);
    }

    // -------------------------------------------------------------------------

    public function getAccessToken($code, $params = array())
    {
        $params['state'] = md5(session_id());
        $params['scope'] = 'email';

        $resp = parent::getAccessToken($code, $params);
        
        parse_str($resp['result'], $info);
        return $info['access_token'];
    }

    // -------------------------------------------------------------------------

    public function getInfo($accessToken, $params = array())
    {
        $url = "https://graph.facebook.com/me";
        $this->client->setAccessToken($accessToken);
        $info = $this->client->fetch($url);

        $out_array = array();
        $out_array['id'] = $info['result']['id'];
        $out_array['first_name'] = $info['result']['first_name'];
        $out_array['last_name'] = $info['result']['last_name'];
        $out_array['email'] = $info['result']['email'];

        return $out_array;
    }
}

/* EOF: Facebook.php */