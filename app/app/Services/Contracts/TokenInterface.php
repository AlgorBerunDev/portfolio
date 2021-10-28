<?php

namespace App\Services\Contracts;

interface TokenInterface {
    public function decode(string $token);
    public function validate(string $token);
    public function generate(array $payload);
    public function setOptions(array $options);
    public function setSecret(string $secretKey);
}
