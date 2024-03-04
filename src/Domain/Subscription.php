<?php

declare(strict_types=1);

namespace AdamBanaszkiewicz\SaasPlatform\Domain;

/**
 * @author Adam Banaszkiewicz
 */
final class Subscription
{
    private string $id;
    private string $plan;
    private ?string $nextPlan = null;
    private ?\DateTimeImmutable $cancelledAt = null;
    private ?\DateTimeImmutable $prolongationStartedAt = null;

    public function __construct()
    {
    }

    /**
     * @throws CannotProlongateCancelledSubscriptionException
     */
    public function beginProlongation(PlanResolverInterface $planResolver): SubscriptionProlongationStartedEvent
    {
        if ($this->isCancelled()) {
            throw new CannotProlongateCancelledSubscriptionException(
                sprintf('Cannot prolongate %s subscription, because is cancelled.', $this->id)
            );
        }

        $this->nextPlan = $planResolver->resolve($this->plan);
        $this->prolongationStartedAt = new \DateTimeImmutable();

        return new SubscriptionProlongationStartedEvent($this->id);
    }

    private function isCancelled(): bool
    {
        return $this->cancelledAt !== null;
    }
}
