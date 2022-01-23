<?php

declare(strict_types=1);

namespace Meals\Application\Component\Validator;

use Meals\Application\Component\Validator\Exception\PollResultIsNotAvailableException;
use Meals\Application\Constant\ValidatorConstant;

class PollResultIsAvailableValidator
{
    public function validate(\DateTime $dateTime): void
    {
        if (!$this->isAvailableDateTime($dateTime)) {
            throw new PollResultIsNotAvailableException();
        }
    }

    private function isAvailableDateTime(\DateTime $dateTime): bool
    {
        $currentDay = $dateTime->format('l');
        $currentTime = strtotime($dateTime->format('H:i:s'));

        return ValidatorConstant::AVAILABLE_POLL_DAY === $currentDay &&
          $currentTime >= strtotime(ValidatorConstant::POLL_START_TIME) &&
          $currentTime < strtotime(ValidatorConstant::POLL_END_TIME);
    }
}
