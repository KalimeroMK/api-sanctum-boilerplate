<?php

namespace Modules\Core\Helpers;

use ReflectionClass;
use ReflectionException;

class Helper
{
    public const SOMETHING_WENT_WRONG = 250;
    public const INVALID_CREDENTIALS = 251;
    public const VALIDATION_ERROR = 252;
    public const EMAIL_ALREADY_VERIFIED = 253;
    public const INVALID_EMAIL_VERIFICATION_URL = 254;
    public const INVALID_RESET_PASSWORD_TOKEN = 255;

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
