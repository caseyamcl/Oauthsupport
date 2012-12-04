<?php

namespace OAuth2\Client;
use OAuth2\AuthService;

class Google extends AuthService
{
    protected function getAuthUrl()
    {
        return 'https://accounts.google.com/o/oauth2/auth';
    }

    // -------------------------------------------------------------------------

    protected function getTokenurl()
    {
        return 'https://accounts.google.com/o/oauth2/token';
    }    

    // -------------------------------------------------------------------------

    public function getAuthorizationUrl($params = array())
    {
        $params['state'] = md5(session_id());
        $params['response_type'] = 'code';
        $params['access_type'] = 'online';
        $params['approval_prompt'] = 'auto';
        $params['scope'] = 'https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email';
        return parent::getAuthorizationUrl($params);
    }

    // -------------------------------------------------------------------------

    public function getAccessToken($code, $params = array())
    {
        $params['grant_type'] = 'authorization_code';
        $resp = parent::getAccessToken($code, $params);
        return $resp['result']['access_token'];
    }

    // -------------------------------------------------------------------------

    public function getInfo($accessToken, $params = array())
    {
        $url = "https://www.googleapis.com/oauth2/v1/userinfo";

        $this->client->setAccessToken($accessToken);
        $info = $this->client->fetch($url);

        return array(
            'id'         => $info['result']['id'],
            'first_name' => $info['result']['given_name'],
            'last_name'  => $info['result']['family_name'],
            'email'      => $info['result']['email']
        );
    }
}