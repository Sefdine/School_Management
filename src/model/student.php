<?php
declare(strict_types=1);

namespace Ipem\Src\Model;

use Ipem\Src\Lib\Database;

class Student extends User
{
    use Inscription;
}