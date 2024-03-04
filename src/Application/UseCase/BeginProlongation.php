<?php

declare(strict_types=1);

namespace AdamBanaszkiewicz\SaasPlatform\Application\UseCase;

use AdamBanaszkiewicz\SaasPlatform\Domain\CannotProlongateCancelledSubscriptionException;
use AdamBanaszkiewicz\SaasPlatform\Domain\PlanResolverInterface;
use AdamBanaszkiewicz\SaasPlatform\Domain\SubscriptionDoesNotExistException;
use AdamBanaszkiewicz\SaasPlatform\Domain\SubscriptionProlongationStartedEvent;
use AdamBanaszkiewicz\SaasPlatform\Domain\SubscriptionRepositoryInterface;
use Psr\EventDispatcher\EventDispatcherInterface;

/**
 * @author Adam Banaszkiewicz
 */
final class BeginProlongation
{
    public function __construct(
        private readonly SubscriptionRepositoryInterface $repository,
        private readonly PlanResolverInterface $planResolver,
        private readonly EventDispatcherInterface $eventDispatcher,
    ) {
    }

    /**
     * @throws SubscriptionDoesNotExistException
     * @throws CannotProlongateCancelledSubscriptionException
     */
    public function __invoke(string $id): void
    {
        $subscription = $this->repository->get($id);
        $event = $subscription->beginProlongation($this->planResolver);

        $this->repository->save($subscription);

        $this->eventDispatcher->dispatch($event);
    }
}
