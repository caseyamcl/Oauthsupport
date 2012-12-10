OAuth Support
=============

An OAuth 2.0 client library (draft 10 / specification 1),
forked from https://github.com/vznet/oauth_2.0_client_php,
written by Charron Pierrick and Berejeb Anis

LICENSE
-------

This Code is released under the GNU LGPL

Please do not change the header of the file(s).

This library is free software; you can redistribute it and/or modify it 
under the terms of the GNU Lesser General Public License as published 
by the Free Software Foundation; either version 2 of the License, or 
(at your option) any later version.

This library is distributed in the hope that it will be useful, but 
WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY 
or FITNESS FOR A PARTICULAR PURPOSE.

See the GNU Lesser General Public License for more details.


Installation
------------

Via composer/packagist:

    require {
        ...
        'caseyamcl/Oauthsupport': 'dev-master'
    }


Usage
-----

This library includes an abstract class named 'AuthService', which can be
extended to create OAuth 2.0 clients for specific services.

As an example, a Facebook and Google class are included in the code.  These
classes are fully functional, and can be used in production.

To create your own client, create a class that extends the __Oauth2\AuthService__
abstract class:

    class MyOauthClient extends \Oauth2\AuthService
    {
        /**
         * Get the Authorization URL
         * 
         * @return string
         */
        public function getAuthUrl()
        {
            return "http://SOME/URL/To/Authorization/Endpoint";
        }

        /**
         * Get the token URL
         * 
         * @return string
         */
        public function getTokenUrl()
        {
            return "http://SOME/URL/To/Token/Endpoint";
        }

        /**
         * Get info once logged-in
         * 
         * @param string $accessToken
         * @return array  Array of info
         */
        public function getInfo($accessToken)
        {
            $infoUrl = 'http://SOME/URL/To/Api/Stuff';
            $this->client->setAccessToken($accessToken);
            return $this->client->get($infoUrl);
        }        
    }