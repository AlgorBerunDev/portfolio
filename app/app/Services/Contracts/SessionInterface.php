<?php
namespace App\Services\Contracts;

interface SessionInterface {
    public function getId(string $token);
    public function getToken(): ?string;
    public function create();
    public function setFcmToken(string $fcmToken);
    public function getFcmToken(int $id = null);
    public function updateCurrent(array $payload);
    public function updateById(int $id, array $payload);
    public function remove(string $token = null);
    public function refresh(string $refresh_token = null);
    public function validate($token = null);
    public function validateRefreshToken($token = null);
}
