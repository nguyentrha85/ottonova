<?php
/**
 * Created by PhpStorm.
 * User: H
 * Date: 04/12/2018
 * Time: 14:50
 */

namespace App\Service;

use App\Entity\Employee;

/**
 * Class HolidayCalculator
 * @package App\Service
 */
class HolidayCalculator
{
    /**
     * Minimum vacation day for employee
     */
    CONST MIN_ANNUAL_ALLOWANCE = 26;

    /**
     * Employee >= 30 years do get one additional vacation day
     */
    CONST MIN_AGE_EXTRA_HOLIDAY = 30;

    /**
     * Get 1 extra day every 5 years
     */
    CONST EXTRA_HOLIDAY_DURATION = 5;

    /**
     * @var Employee
     */
    private $employee;

    /**
     * @var integer
     */
    private $year;

    /**
     * @param Employee $employee
     */
    public function setEmployee(Employee $employee): void
    {
        $this->employee = $employee;
    }

    /**
     * @param int $year
     */
    public function setYear(int $year): void
    {
        $this->year = $year;
    }

    /**
     * Return the number of holiday in a specific year for an employee
     *
     * @return int
     */
    public function calculateHoliday(): int
    {
        $annualAllowance = empty($this->employee->getSpecialContract()) ? $this->getAnnualAllowance() : $this->employee->getSpecialContract();
        if ($this->year === (int)$this->employee->getStartDate()->format('Y')) {
            return floor($annualAllowance * $this->getWorkingMonthInYear($this->employee->getStartDate()) / 12);
        } else {
            return floor($annualAllowance);
        }
    }

    /**
     * Return the allowance for the whole year
     *
     * @return int
     */
    private function getAnnualAllowance(): int
    {
        return $this->getExtraHolidayByAge() + self::MIN_ANNUAL_ALLOWANCE;
    }

    /**
     * Return the working month until end of the year
     * If an employee starts at 1st of the month, we will calculate from that month
     * Otherwise, we calculate from next month
     *
     * @param \DateTime $startDate
     * @return int
     */
    private function getWorkingMonthInYear(\DateTime $startDate): int
    {
        if ($startDate->format('d') === '01') {
            $startMonth = intval($startDate->format('m'));
        } else {
            $startMonth = intval($startDate->format('m')) + 1;
        }
        return 12 - $startMonth + 1;
    }

    /**
     * Employee >= 30 years do get one additional vacation day every 5 years
     * This function returns the extra holidays an employee gets
     *
     * @return int
     */
    private function getExtraHolidayByAge(): int
    {
        $age = $this->year - intval($this->employee->getDob()->format('Y'));
        if ($age >= self::MIN_AGE_EXTRA_HOLIDAY) {
            return floor(($age - self::MIN_AGE_EXTRA_HOLIDAY) / self::EXTRA_HOLIDAY_DURATION) + 1;
        } else {
            return 0;
        }
    }
}