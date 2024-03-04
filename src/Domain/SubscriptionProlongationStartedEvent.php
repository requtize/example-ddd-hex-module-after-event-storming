<?php

declare(strict_types=1);

namespace AdamBanaszkiewicz\SaasPlatform\Domain;

/**
 * @author Adam Banaszkiewicz
 */
final class SubscriptionProlongationStartedEvent
{
    public function __construct(
        public readonly string $id,
    ) {
    }
}
