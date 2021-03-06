<?php

namespace Octogun\Client;

use Octogun\Api;

class RateLimit extends Api
{
	/**
     * Gets the rate limit.
     * 
     * @see http://developer.github.com/v3/#rate-limiting
     *
     * @param array $options Optional options.
     *
     * @return int The rate limit.
     */
    public function rateLimit(array $options = [])
    {
        $response = $this->request()->sendRequest('get', 'rate_limit', $options);
        
        return $response->getHeader('X-RateLimit-Limit');
    }
    
    /**
     * Gets the rate limit remaining.
     * 
     * @see http://developer.github.com/v3/#rate-limiting
     *
     * @param array $options Optional options.
     *
     * @return int The rate limit remaining.
     */
    public function rateLimitRemaining(array $options = [])
    {
        $response = $this->request()->sendRequest('get', 'rate_limit', $options);
        
        return $response->getHeader('X-RateLimit-Remaining');
    }
}
