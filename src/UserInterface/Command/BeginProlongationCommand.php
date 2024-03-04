<?php

declare(strict_types=1);

namespace AdamBanaszkiewicz\SaasPlatform\UserInterface\Command;

use AdamBanaszkiewicz\SaasPlatform\Application\UseCase\BeginProlongation;
use AdamBanaszkiewicz\SaasPlatform\Domain\CannotProlongateCancelledSubscriptionException;
use AdamBanaszkiewicz\SaasPlatform\Domain\SubscriptionDoesNotExistException;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Adam Banaszkiewicz
 */
#[AsCommand(name: 'subscription:begin-prolongation')]
final class BeginProlongationCommand extends Command
{
    public function __construct(
        private readonly BeginProlongation $beginProlongation,
        private readonly BeginProlongation $cancelSubscription,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $subscriptions = $this->getEndingSubscriptions();

        foreach ($subscriptions as $subscription) {
            try {
                if ($subscription['is_cancelled']) {
                    ($this->cancelSubscription)($input->getArgument('id'));
                } else {
                    ($this->beginProlongation)($input->getArgument('id'));
                }
            } catch (SubscriptionDoesNotExistException $e) {
                $output->writeln('Subscription does not exist.');
                return Command::FAILURE;
            } catch (CannotProlongateCancelledSubscriptionException $e) {
                $output->writeln($e->getMessage());
                return Command::FAILURE;
            } catch (\Exception $e) {
                $output->writeln('Internal server error.');
                return Command::FAILURE;
            }
        }

        return Command::SUCCESS;
    }

    private function getEndingSubscriptions(): array
    {
        return [];
    }
}
