<?php
/**
 * Created by PhpStorm.
 * User: H
 * Date: 04/12/2018
 * Time: 14:24
 */

namespace App\Service;

use App\Repository\EmployeeRepository;
use App\Service\HolidayCalculator;
use App\Entity\Employee;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

/**
 * Class EmployeeService
 * @package App\Service
 */
class EmployeeService
{
    /**
     * @var EmployeeRepository
     */
    private $employeeRepository;

    /**
     * @var \App\Service\HolidayCalculator
     */
    private $holidayCalculator;

    /**
     * EmployeeService constructor.
     * @param EmployeeRepository $employeeRepository
     * @param \App\Service\HolidayCalculator $holidayCalculator
     */
    public function __construct(EmployeeRepository $employeeRepository, HolidayCalculator $holidayCalculator)
    {
        $this->employeeRepository = $employeeRepository;
        $this->holidayCalculator = $holidayCalculator;
    }

    /**
     * Generate the csv file which contains name and holiday
     *
     * @param $year
     * @return bool|int
     */
    public function generateReport($year)
    {
        $result = array();
        $allEmployees = $this->employeeRepository->findByYear($year);
        foreach ($allEmployees as $employee) {
            $this->holidayCalculator->setEmployee($employee);
            $this->holidayCalculator->setYear($year);
            $holiday = $this->holidayCalculator->calculateHoliday();
            $result[] = array($employee->getName(), $holiday);
        }
        return $this->writeDataCSV($result);
    }

    /**
     * Export data to CSV file
     *
     * @param $data
     * @return bool|int
     */
    private function writeDataCSV($data)
    {
        $encoders = array(new CsvEncoder());
        $normalizers = array(new ObjectNormalizer());
        $serializer = new Serializer($normalizers, $encoders);
        $content = $serializer->serialize($data, 'csv');
        return file_put_contents("data.csv", $content);
    }
}