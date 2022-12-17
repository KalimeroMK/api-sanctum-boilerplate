<?php

namespace Modules\User\Http\Helper;

use ReflectionClass;
use ReflectionException;

class Helper
{
    
    /**
     * @param $class
     *
     * @return string
     */
    public static function getResourceName($class): string
    {
        try {
            $reflectionClass = new ReflectionClass($class);
            
            return $reflectionClass->getShortName();
        } catch (ReflectionException $exception) {
            return $exception->getMessage();
        }
    }
}