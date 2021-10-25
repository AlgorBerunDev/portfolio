<?php
namespace App\Contracts\Session;

interface SessionInterface {
    public function decode($token);
    public function validateAccess($token);
    public function validateRefresh($token);
    public function refresh($token);
    public function removeById($id);
    public function removeByToken($id);
}
