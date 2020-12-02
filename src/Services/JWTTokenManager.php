<?php


namespace App\Services;


use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Key;
use Lcobucci\JWT\Signer\Rsa\Sha256;
use Lcobucci\JWT\Token;
use Symfony\Component\Serializer\SerializerInterface;

class JWTTokenManager
{

    private SerializerInterface $serializer;
    private string $opensslPrivateKeysPath;
    private int $ttl;
    private string $baseUrl;

    public function __construct(
        SerializerInterface $serializer,
        string $opensslPrivateKeysPath,
        int $ttl,
        string $baseUrl
    ) {
        $this->serializer = $serializer;
        $this->opensslPrivateKeysPath = $opensslPrivateKeysPath;
        $this->ttl = $ttl;
        $this->baseUrl = $baseUrl;
    }

    public function create($payload, string $privateKeyName, ?string $passphrase = null): Token
    {
        $privateKeyPath = $this->opensslPrivateKeysPath . DIRECTORY_SEPARATOR . $privateKeyName;

        $signer = new Sha256();
        $privateKey = new Key('file://' . $privateKeyPath, $passphrase);

        $time = time();

        $builder = (new Builder())
            ->issuedBy($this->baseUrl)
            ->permittedFor($this->baseUrl)
            ->issuedAt($time)
            ->canOnlyBeUsedAfter($time + 60)
            ->expiresAt($time + $this->ttl);

        $normalizedPayload = $this->serializer->normalize($payload);

        foreach ($normalizedPayload as $key => $value) {
            $builder->withClaim($key, $value);
        }

        return $builder->getToken($signer, $privateKey);
    }

}