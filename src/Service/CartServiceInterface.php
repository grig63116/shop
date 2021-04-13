<?php

namespace App\Service;

/**
 * Interface CartServiceInterface
 * @package App\Service
 */
interface CartServiceInterface
{
    /**
     * @param string $oldSessionId
     * @param string $newSessionId
     * @param int $userId
     */
    public function migrate(string $oldSessionId, string $newSessionId, int $userId): void;

    /**
     * @return array
     */
    public function getContent(): array;

    /**
     * @param string $number
     * @param int $quantity
     */
    public function add(string $number = '', int $quantity = 1): void;

    /**
     * @param int $id
     */
    public function remove(int $id): void;

    /**
     * @return int
     */
    public function getTotalCount(): int;

    /**
     * @param int $id
     * @param int $quantity
     */
    public function changeQuantity(int $id, int $quantity): void;
}