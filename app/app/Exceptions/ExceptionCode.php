<?php
namespace App\Exceptions;

class ExceptionCode {
    const NOT_FOUND=1;
    const ACCESS_DENIED=2;
    const UNAUTHORIZED=3;
    const TOKEN_EXPIRED=4;
    const TOKEN_FAILED=5;

    protected function getCodeMessage($code) {
        switch ($code) {
            case self::NOT_FOUND:
                return "Not found";
            case self::ACCESS_DENIED:
                return "Access denied";
            case self::UNAUTHORIZED:
                return "Unauthorized";
            case self::TOKEN_EXPIRED:
                return "Token expired";
            case self::TOKEN_FAILED:
                return "Token failed";

            default:
                return "Default message";
        }
    }
}
