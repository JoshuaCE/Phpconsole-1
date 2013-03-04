<?php namespace Phpconsole\Facades;

use Illuminate\Support\Facades\Facade;

class Phpconsole extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'phpconsole'; }

}