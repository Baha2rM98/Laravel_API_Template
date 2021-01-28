<?php

namespace App\Components\Tool;

use Illuminate\Support\Str;
use InvalidArgumentException;

class HmacHash
{
    /**
     * @var string The HmacHash algorithm.
     */
    private $algorithm;

    /**
     * @var bool Indicate if algorithm should return raw output.
     */
    private $rawOutput;

    /**
     * Create an instance of HmacHash.
     *
     * @param array $config
     * @return void
     *
     * @throws InvalidArgumentException
     */
    public function __construct(array $config = ['algorithm' => 'sha3-512', 'raw_output' => false])
    {
        list('raw_output' => $this->rawOutput, 'algorithm' => $this->algorithm) = $config;

        if (!$this->validateAlgorithm($this->algorithm) || !is_bool($this->rawOutput)) {
            throw new InvalidArgumentException("Invalid Hmac config: {$this->algorithm} or {$this->rawOutput} is unacceptable.", -1);
        }
    }

    /**
     * Sign the payload with the given key.
     *
     * @param mixed $payload
     * @param string $key
     * @return string
     */
    public function sign($payload, string $key): string
    {
        return hash_hmac($this->algorithm, is_string($payload) ? $payload : serialize($payload), $this->addSaltToKey($key), $this->rawOutput);
    }

    /**
     * Determine if the signature is invalid.
     *
     * @param mixed $payload
     * @param string $key
     * @param string $signature
     * @return bool
     */
    public function isSignatureInvalid($payload, string $key, string $signature): bool
    {
        return !hash_equals($signature, $this->sign($payload, $key));
    }

    /**
     * Validates the hash algorithm.
     *
     * @param string $algorithm
     * @return bool
     */
    private function validateAlgorithm(string $algorithm): bool
    {
        return in_array($algorithm, hash_hmac_algos(), true);
    }

    /**
     * Add a salt to the hash secret key.
     *
     * @param string $key
     * @return string
     */
    private function addSaltToKey(string &$key): string
    {
        if (!Str::startsWith($key, 'aE/%\0?~Bm')) {
            $key = 'aE/%\0?~Bm' . $key;
        }
        if (!Str::endsWith($key, 'Ae/%\0?~bM')) {
            $key = $key . 'Ae/%\0?~bM';
        }

        return $key;
    }
}
