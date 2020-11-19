<?php

namespace Laravel\Passport\Bridge;

use Laravel\Passport\Passport;
use League\OAuth2\Server\Entities\AuthCodeEntityInterface;
use League\OAuth2\Server\Repositories\AuthCodeRepositoryInterface;

class AuthCodeRepository implements AuthCodeRepositoryInterface
{
    use FormatsScopesForStorage;

    /**
     * {@inheritdoc}
     */
    public function getNewAuthCode()
    {
        return new AuthCode;
    }

    /**
     * {@inheritdoc}
     */
    public function persistNewAuthCode(AuthCodeEntityInterface $authCodeEntity)
    {
        $attributes = [
            'ID' => $authCodeEntity->getIdentifier(),
            'USER_ID' => $authCodeEntity->getUserIdentifier(),
            'CLIENT_ID' => $authCodeEntity->getClient()->getIdentifier(),
            'SCOPES' => $this->formatScopesForStorage($authCodeEntity->getScopes()),
            'REVOKED' => false,
            'EXPIRES_AT' => $authCodeEntity->getExpiryDateTime(),
        ];

        Passport::authCode()->setRawAttributes($attributes)->save();
    }

    /**
     * {@inheritdoc}
     */
    public function revokeAuthCode($codeId)
    {
        Passport::authCode()->where('ID', $codeId)->update(['REVOKED' => true]);
    }

    /**
     * {@inheritdoc}
     */
    public function isAuthCodeRevoked($codeId)
    {
        return Passport::authCode()->where('ID', $codeId)->where('REVOKED', 1)->exists();
    }
}
