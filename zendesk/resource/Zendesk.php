<?php
namespace Zendesk\Resource;

use Zendesk\API\Client as ZendeskAPI;
use Config, InvalidArgumentException, BadMethodCallException;

class Zendesk {

    public function __construct() {
        
        $this->subdomain = config('zendesk-config.subdomain');
        $this->username = config('zendesk-config.username');
        $this->token = config('zendesk-config.token');


        if(!$this->subdomain || !$this->username || !$this->token) {
            throw new InvalidArgumentException('Please set ZENDESK_SUBDOMAIN, ZENDESK_USERNAME and ZENDESK_TOKEN environment variables.');
        }
        $this->client = new ZendeskAPI($this->subdomain, $this->username);
        $this->client->setAuth('token',$this->token);
    }

    public function __call($method, $args) {
        if(is_callable([$this->client,$method])) {
            return call_user_func_array([$this->client,$method],$args);
        } else {
            throw new BadMethodCallException("Method $method does not exist");
        }
    }


}