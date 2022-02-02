<?php

declare(strict_types=1);

namespace tests\Meals\Functional\Interactor;

use Meals\Application\Component\Validator\Exception\PollResultIsNotAvailableException;
use Meals\Application\Feature\Poll\UseCase\UserSetsDishToPollResult\Interactor;
use Meals\Domain\Dish\Dish;
use Meals\Domain\Dish\DishList;
use Meals\Domain\Employee\Employee;
use Meals\Domain\Menu\Menu;
use Meals\Domain\Poll\Poll;
use Meals\Domain\Poll\PollResult;
use Meals\Domain\User\Permission\Permission;
use Meals\Domain\User\Permission\PermissionList;
use Meals\Domain\User\User;
use tests\Meals\Constant\ValidatorConstant;
use tests\Meals\Functional\Fake\Provider\FakeDishProvider;
use tests\Meals\Functional\Fake\Provider\FakeEmployeeProvider;
use tests\Meals\Functional\Fake\Provider\FakePollProvider;
use tests\Meals\Functional\FunctionalTestCase;

class UserSetsDishToPollResultTest extends FunctionalTestCase
{
    public function testSuccessful()
    {
        $pollResult = $this->performTestMethod(
          $this->getEmployeeWithPermissions(),
          $this->getPoll(true),
          $this->getDish(),
          new \DateTime(ValidatorConstant::CORRECT_DATETIME, new \DateTimeZone(ValidatorConstant::TIMEZONE))
        );

        verify($pollResult)->equals($pollResult);
    }

    public function testPollResultIsNotAvailable()
    {
        $this->expectException(PollResultIsNotAvailableException::class);

        $pollResult = $this->performTestMethod(
          $this->getEmployeeWithPermissions(),
          $this->getPoll(true),
          $this->getDish(),
          new \DateTime(ValidatorConstant::WRONG_DATETIME, new \DateTimeZone(ValidatorConstant::TIMEZONE))
        );

        verify($pollResult)->equals($pollResult);
    }

    private function performTestMethod(Employee $employee, Poll $poll, Dish $dish, \DateTime $dateTime): PollResult
    {
        $this->getContainer()->get(FakeEmployeeProvider::class)->setEmployee($employee);
        $this->getContainer()->get(FakePollProvider::class)->setPoll($poll);
        $this->getContainer()->get(FakeDishProvider::class)->setDish($dish);

        return $this->getContainer()->get(Interactor::class)->userSetsDishToPollResult(
          $employee->getId(),
          $poll->getId(),
          $dish->getId(),
          $dateTime
        );
    }

    private function getEmployeeWithPermissions(): Employee
    {
        return new Employee(
          1,
          $this->getUserWithPermissions(),
          4,
          'Surname'
        );
    }

    private function getUserWithPermissions(): User
    {
        return new User(
          1,
          new PermissionList(
            [
              new Permission(Permission::VIEW_ACTIVE_POLLS),
            ]
          ),
        );
    }

    private function getDish(): Dish
    {
        return new Dish(
          1,
          'title',
          'description'
        );
    }

    private function getPoll(bool $active): Poll
    {
        return new Poll(
          1,
          $active,
          new Menu(
            1,
            'title',
            new DishList([]),
          )
        );
    }
}
