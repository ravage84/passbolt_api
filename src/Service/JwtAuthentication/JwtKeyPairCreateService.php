<?php
declare(strict_types=1);

/**
 * Passbolt ~ Open source password manager for teams
 * Copyright (c) Passbolt SA (https://www.passbolt.com)
 *
 * Licensed under GNU Affero General Public License version 3 of the or any later version.
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Passbolt SA (https://www.passbolt.com)
 * @license       https://opensource.org/licenses/AGPL-3.0 AGPL License
 * @link          https://www.passbolt.com Passbolt(tm)
 * @since         3.3.0
 */
namespace App\Service\JwtAuthentication;

class JwtKeyPairCreateService
{
    protected $secretService;

    protected $publicService;

    /**
     * CreateJwtKeysService constructor.
     *
     * @param \App\Service\JwtAuthentication\JwtTokenCreateService|null $secretService JWT Secret Service
     * @param \App\Service\JwtAuthentication\JwksGetService|null $publicService JWT Public Service
     */
    public function __construct(
        ?JwtTokenCreateService $secretService = null,
        ?JwksGetService $publicService = null
    ) {
        $this->secretService = $secretService ?? new JwtTokenCreateService();
        $this->publicService = $publicService ?? new JwksGetService();
    }

    /**
     * @param bool $force Force the creation of a new pair.
     * @return bool if a pair was created.
     */
    public function createKeyPair(bool $force = false): bool
    {
        $secretFile = $this->secretService->getKeyPath();
        $publicFile = $this->publicService->getKeyPath();

        $pairIsNotComplete = !is_readable($secretFile) || !is_readable($publicFile);

        if ($pairIsNotComplete || $force) {
            # generate private key
            exec('openssl genrsa -out ' . $secretFile . ' 1024');
            # generate public key
            exec('openssl rsa -in ' . $secretFile . ' -outform PEM -pubout -out ' . $publicFile);

            return true;
        } else {
            return false;
        }
    }
}