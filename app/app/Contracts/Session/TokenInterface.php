<?php
namespace App\Contracts\Session;

interface TokenInterface {
    public function decode($token);
    public function generate(array $payload);
    public function validate($token);
}
