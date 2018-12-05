<?php
/**
 * Created by PhpStorm.
 * User: H
 * Date: 04/12/2018
 * Time: 14:20
 */

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use App\Service\EmployeeService;

class GenerateReport extends Command
{
    protected static $defaultName = 'app:generate-report';
    private $year;
    private $employeeService;

    public function __construct(int $year = 2018, EmployeeService $employeeService)
    {
        $this->year = $year;
        $this->employeeService = $employeeService;
        parent::__construct();
    }
    protected function configure()
    {
        $this->addArgument('year', $this->year ? InputArgument::OPTIONAL : InputArgument::REQUIRED, 'Year to extract report');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $year = $input->getArgument('year');
        $result = $this->employeeService->generateReport($year);
        $output->writeln('Report successfully generated!');
    }
}