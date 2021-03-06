<?php

declare(strict_types=1);

namespace Meals\Application\Feature\Poll\UseCase\UserSetsDishToPollResult;

use Meals\Application\Component\Provider\DishProviderInterface;
use Meals\Application\Component\Provider\EmployeeProviderInterface;
use Meals\Application\Component\Provider\PollProviderInterface;
use Meals\Application\Component\Provider\PollResultProviderInterface;
use Meals\Application\Component\Validator\PollIsActiveValidator;
use Meals\Application\Component\Validator\PollResultIsAvailableValidator;
use Meals\Application\Component\Validator\UserHasAccessToViewPollsValidator;
use Meals\Domain\Poll\PollResult;

class Interactor
{
    public function __construct(
      private EmployeeProviderInterface $employeeProvider,
      private PollProviderInterface $pollProvider,
      private DishProviderInterface $dishProvider,
      private PollResultIsAvailableValidator $pollResultIsAvailableValidator,
      private UserHasAccessToViewPollsValidator $userHasAccessToPollsValidator,
      private PollIsActiveValidator $pollIsActiveValidator,
      private PollResultProviderInterface $pollResultProvider,
    ) {}

    public function userSetsDishToPollResult(int $employeeId, int $pollId, int $dishId, \DateTime $dateTime): PollResult
    {
        $employee = $this->employeeProvider->getEmployee($employeeId);
        $poll = $this->pollProvider->getPoll($pollId);
        $dish = $this->dishProvider->getDish($dishId);

        $this->userHasAccessToPollsValidator->validate($employee->getUser());
        $this->pollIsActiveValidator->validate($poll);
        $this->pollResultIsAvailableValidator->validate($dateTime);

        return $this->pollResultProvider->createPollResult($poll, $employee, $dish);
    }
}
