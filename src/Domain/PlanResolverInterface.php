<?php

declare(strict_types=1);

namespace AdamBanaszkiewicz\SaasPlatform\Domain;

/**
 * @author Adam Banaszkiewicz
 */
interface PlanResolverInterface
{
    public function resolve(string $oldPlan): string;
}
