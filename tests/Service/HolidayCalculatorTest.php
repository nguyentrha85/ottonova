<?php
/**
 * Created by PhpStorm.
 * User: H
 * Date: 04/12/2018
 * Time: 20:43
 */

namespace App\Tests\Service;

use App\Entity\Employee;
use App\Service\HolidayCalculator;
use PHPUnit\Framework\TestCase;

class CalculatorTest extends TestCase
{
    /**
     * @dataProvider holidayDataProvider
     */
    public function testCalculateHoliday($year, $dob, $startDate, $specialContract, $expectedHoliday)
    {
        $holidayCalculator = new HolidayCalculator();
        $employee = new Employee();
        $employee->setName('Test name');
        $employee->setDob(new \DateTime($dob));
        $employee->setStartDate(new \DateTime($startDate));
        $employee->setSpecialContract($specialContract);
        $holidayCalculator->setEmployee($employee);
        $holidayCalculator->setYear($year);
        $result = $holidayCalculator->calculateHoliday();
        $this->assertEquals($expectedHoliday, $result);
    }

    public function holidayDataProvider()
    {
        return array(
            array(2018, '1950-12-30', '2001-01-01', null, 34),
            array(2018, '1966-06-09', '2001-01-15', null, 31),
            array(2018, '1991-07-12', '2016-05-15', 27, 27),
            array(2016, '1950-12-30', '2001-01-01', null, 34),
            array(2016, '1966-06-09', '2001-01-15', null, 31),
            array(2016, '1991-07-12', '2016-05-15', 27, 15)
        );
    }
}