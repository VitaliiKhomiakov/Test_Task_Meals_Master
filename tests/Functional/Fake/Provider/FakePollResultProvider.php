<?php

declare(strict_types=1);

namespace tests\Meals\Functional\Fake\Provider;

use Meals\Application\Component\Provider\PollResultProviderInterface;
use Meals\Domain\Dish\Dish;
use Meals\Domain\Employee\Employee;
use Meals\Domain\Poll\Poll;
use Meals\Domain\Poll\PollResult;

class FakePollResultProvider implements PollResultProviderInterface
{
    private PollResult $pollResult;

    public function createPollResult(Poll $poll, Employee $employee, Dish $dish): PollResult
    {
        $this->setPollResult(new PollResult(0, $poll, $employee, $dish, $employee->getFloor()));
        return $this->getPollResult();
    }

    public function setPollResult(PollResult $pollResult)
    {
        $this->pollResult = $pollResult;
    }

    public function getPollResult(): PollResult
    {
        return $this->pollResult;
    }
}
