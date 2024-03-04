<?php

declare(strict_types=1);

namespace AdamBanaszkiewicz\SaasPlatform\UserInterface\Controller;

use AdamBanaszkiewicz\SaasPlatform\Application\UseCase\BeginProlongation;
use AdamBanaszkiewicz\SaasPlatform\Domain\CannotProlongateCancelledSubscriptionException;
use AdamBanaszkiewicz\SaasPlatform\Domain\SubscriptionDoesNotExistException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;

/**
 * @author Adam Banaszkiewicz
 */
#[AsController]
final class SubscriptionController
{
    public function __invoke(string $id, BeginProlongation $beginProlongation): Response
    {
        try {
            ($beginProlongation)($id);
        } catch (SubscriptionDoesNotExistException $e) {
            return new Response('', Response::HTTP_NOT_FOUND);
        } catch (CannotProlongateCancelledSubscriptionException $e) {
            return new Response('', Response::HTTP_NOT_IMPLEMENTED);
        } catch (\Exception $e) {
            return new Response('', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return new Response();
    }
}
