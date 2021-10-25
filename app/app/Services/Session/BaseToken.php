<?php

namespace App\Services\Session;

use Firebase\JWT\JWT;
use App\Contracts\Session\TokenInterface;

class BaseToken implements TokenInterface {
    private $algorithm;
    private $secret_key;
    private $payload = [];

    public function __construct(array $options){

        $issuedAt   = new \DateTimeImmutable();
        $expire = $options['expire']?
            $issuedAt->modify($options["expire"])->getTimestamp()
            : $issuedAt->modify("+60 minutes")->getTimestamp();
        $serverName = $options['serverName']? $options['serverName'] : "Laravel";
        $serverUrl = $options['serverUrl']? $options['serverUrl'] : "http://localhost";
        $this->algorithm = $options['algorithm']? $options['algorithm'] : "HS512";
        $this->secret_key = $options['secret_key']? $options['secret_key'] : "Secret key";

        $this->payload = array(
            "iss" => $serverName, // строка, содержащая имя или идентификатор эмитента. Может быть доменным именем и может использоваться для удаления токенов из других приложений.
            "aud" => $serverUrl,
            "iat" => $issuedAt->getTimestamp(), // метка времени выпуска токена.
            "nbf" => $issuedAt->getTimestamp(), // отметка времени, когда токен должен считаться действительным. Должно быть равно или больше iat.
            "exp" => $expire, // отметка времени, когда токен должен перестать быть действительным. Должно быть больше iatи nbf.
        );
    }

    public function decode($token) {
        list($header, $payload, $signature) = explode (".", $token);
        $json = base64_decode($payload);
        return json_decode($json);
    }

    public function validate($token) {
        return JWT::decode($token, $this->secret_key, [$this->algorithm]);
    }

    public function generate(array $payload) {
        return JWT::encode(
            array_merge(
                $payload,
                $this->payload
            ),
            $this->secret_key,
            $this->algorithm
        );
    }

}
