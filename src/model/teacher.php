<?php
declare(strict_types=1);

namespace Ipem\Src\Model;

use Ipem\Src\Lib\Database;

class Teacher extends User
{
    use Exam, Module, Year, Study, Group, Level;
}