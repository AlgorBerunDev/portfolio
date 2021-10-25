<?php
namespace App\Services\Session;

use App\Contracts\Session\SessionInterface;
use App\Services\Session\AccessTokenService;
use App\Services\Session\RefreshTokenService;

class SessionService implements SessionInterface {
    private $accessService;
    private $refreshService;

    public function __construct(AccessTokenService $accessService, RefreshTokenService $refreshService)
    {
        $this->accessService = $accessService;
        $this->refreshService = $refreshService;
    }
    public function decode($token)
    {
        return $this->accessService->decode($token);
    }
    public function validateAccess($token)
    {
        return $this->accessService->validate($token);
    }
    public function validateRefresh($token)
    {
        return $this->refreshService->validate($token);
    }
    public function refresh($token)
    {

    }
    public function removeById($id)
    {

    }
    public function removeByToken($token)
    {

    }
    public function create()
    {

    }
}
