<?php 

declare(strict_types=1);

namespace Ipem\Src\Controllers;

use Ipem\Src\Model\Rate;
use Ipem\Src\Model\User as ModelUser;

class Student extends User
{
    public function displayHome(string $identifier): void 
    {
        $student = new ModelUser;
        $user = $student->getUser('student', $identifier);
        require_once('templates/student/header.php');
        require_once('templates/student/home.php');
    }

    public function displayRate(string $identifier): void
    {
        $student = new ModelUser;
        $title = 'Consultaion des notes';
        $user = $student->getUser('student', $identifier);
        $rates = new Rate;
        $rate = $rates->getRate($identifier);
        $average = self::getAverage($rate);
        require_once('templates/student/header.php');
        require_once('templates/student/display_rate.php');
    }

    protected static function getAverage(Rate $rate): float
    {
        $total = array_sum([
            $rate->french,
            $rate->english,
            $rate->marketing,
            $rate->accounting,
            $rate->office,
            $rate->statistics,
            $rate->business_management,
            $rate->admin_management,
            $rate->work_legislation,
            $rate->financial_math
        ]);
        
        return $total / 10;
    }
}
