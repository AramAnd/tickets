<?php

namespace Zendesk\Facades;
use Illuminate\Support\Facades\Facade;

class Zendesk extends Facade{
    protected static function getFacadeAccessor() { return 'zendesk'; }
}