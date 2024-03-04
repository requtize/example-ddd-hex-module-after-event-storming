<?php

declare(strict_types=1);

namespace AdamBanaszkiewicz\SaasPlatform\Domain;

/**
 * @author Adam Banaszkiewicz
 */
interface SubscriptionRepositoryInterface
{
    /**
     * @throws SubscriptionDoesNotExistException
     */
    public function get(string $id): Subscription;

    public function save(Subscription $subscription): void;
}
