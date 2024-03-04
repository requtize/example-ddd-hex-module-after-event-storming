<?php

declare(strict_types=1);

namespace AdamBanaszkiewicz\SaasPlatform;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

/**
 * @author Adam Banaszkiewicz
 */
class Kernel extends BaseKernel
{
    use MicroKernelTrait;
}
