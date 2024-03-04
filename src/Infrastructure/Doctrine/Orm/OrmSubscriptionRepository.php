<?php

declare(strict_types=1);

namespace AdamBanaszkiewicz\SaasPlatform\Infrastructure\Doctrine\Orm;

use AdamBanaszkiewicz\SaasPlatform\Domain\Subscription;
use AdamBanaszkiewicz\SaasPlatform\Domain\SubscriptionDoesNotExistException;
use AdamBanaszkiewicz\SaasPlatform\Domain\SubscriptionRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @author Adam Banaszkiewicz
 */
final class OrmSubscriptionRepository extends ServiceEntityRepository implements SubscriptionRepositoryInterface
{
    public function __construct(
        ManagerRegistry $registry,
    ) {
        parent::__construct($registry, Subscription::class);
    }

    public function get(string $id): Subscription
    {
        $subscription = $this->find($id);

        if (!$subscription) {
            throw new SubscriptionDoesNotExistException('Subscription does not exist.');
        }

        return $subscription;
    }

    public function save(Subscription $subscription): void
    {
        $this->_em->persist($subscription);
        $this->_em->flush();
    }
}
