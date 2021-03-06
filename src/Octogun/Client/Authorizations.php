<?php

namespace Octogun\Client;

use Octogun\Api;

class Authorizations extends Api
{
    /**
     * List a users authorizations.
     * 
     * API for users to manage their own tokens.
     * You can only access your own tokens, and only through
     * Basic Authentication.
     * 
     * @see http://developer.github.com/v3/oauth/#list-your-authorizations
     *
     * @param array $options Optional options.
     *
     * @return array A list of authorizations for the authenticated user.
     */
    public function authorizations(array $options = [])
    {
        return $this->request()->get('authorizations', $options);
    }
    
     /**
     * Get a single authorization for the authenticated user.
     * 
     * You can only access your own tokens, and only through
     * Basic Authentication.
     * 
     * @see http://developer.github.com/v3/oauth/#get-a-single-authorization
     *
     * @param string $number  ID of the authorization.
     * @param array  $options Optional options.
     *
     * @return array A single authorization for the authenticated user.
     */
    public function authorization($number, array $options = [])
    {
        return $this->request()->get('authorizations/' . $number, $options);
    }
    
     /**
     * Create an authorization for the authenticated user.
     * 
     * You can create your own tokens, and only through
     * Basic Authentication.
     * 
     * @see http://developer.github.com/v3/oauth/#create-a-new-authorization
     *
     * @param array $options Optional options.
     *
     * @return array A single authorization for the authenticated user.
     */
    public function createAuthorization(array $options = [])
    {
        $options = array_merge(['scopes' => ''], $options);
        
        return $this->request()->post('authorizations', $options);
    }
    
    /**
     * Update an authorization for the authenticated user.
     * 
     * You can update your own tokens, but only through
     * Basic Authentication.
     * 
     * @see http://developer.github.com/v3/oauth/#update-a-new-authorization
     *
     * @param string $number  ID of the authorization.
     * @param array  $options Optional options.
     *
     * @return array A single (updated) authorization for the authenticated user.
     */
    public function updateAuthorization($number, array $options = [])
    {
        $options = array_merge(['scopes' => ''], $options);
        
        return $this->request()->patch('authorizations/' . $number, 'authorizations', $options);
    }
    
    /**
     * Delete an authorization for the authenticated user.
     * 
     * You can delete your own tokens, and only through
     * Basic Authentication.
     * 
     * @see http://developer.github.com/v3/oauth/#delete-an-authorization
     *
     * @param string $number  ID of the authorization.
     * @param array  $options Optional options.
     *
     * @return bool Success
     */
    public function deleteAuthorization($number, array $options = [])
    {
        return $this->request()->booleanFromResponse('delete', 'authorizations/' . $number, $options);
    }
    
    /**
     * Check scopes for a token.
     * 
     * @see http://developer.github.com/v3/oauth/#scopes
     *
     * @param string $token GitHub OAuth token.
     *
     * @return array OAuth scopes.
     */
    public function scopes($token = null)
    {
        $response = $this->request()->sendRequest('get', 'user', ['access_token' => $token]);
        $scopes = $response->getHeader('X-OAuth-Scopes');
        $scopes = explode(',', $scopes);
        
        foreach ($scopes as &$scope) {
            $scope = trim($scope);
        }
        
        sort($scopes);
        
        return $scopes;
    }
    
    /**
     * Get the URL to authorize a user for an application via the web flow
     * 
     * @see http://developer.github.com/v3/oauth/#web-application-flow
     *
     * @param array $options Optional options.
     *
     * @return string The url to redirect the user to authorize.
     */
    public function authorizeUrl(array $options = [])
    {
        $options = array_merge([
            'client_id' => $this->configuration()->get('client_id'),
            'endpoint'  => $this->configuration()->get('web_endpoint'),
        ], $options);
        
        $authorize_url = $options['endpoint'];
        unset($options['endpoint']);
        $authorize_url .= 'login/oauth/authorize?';
        $authorize_url .=  http_build_query($options);
        
        return $authorize_url;
    }
}
