<?php

declare(strict_types=1);

namespace Ipem\Src\Model;

use Ipem\Src\Lib\Database;

class Rate 
{
    public int $id;
    public string $firstname;
    public string $lastname;
    public string $study;
    public float $french;
    public float $english;
    public float $marketing;
    public float $accounting;
    public float $office;
    public float $statistics;
    public float $business_management;
    public float $admin_management;
    public float $work_legislation;
    public float $financial_math;

    public function getRates(): array
    {
        $connection = new Database;
        $statement = $connection->getConnection()->query(
            'SELECT * FROM rate ORDER BY id ASC'
        );
        $rates = [];
        while($row = $statement->fetch()) {
            $rate = new Self;
            $rate->id = $row['id'];
            $rate->firstname = $row['firstname'];
            $rate->lastname = $row['lastname'];
            $rate->study = $row['study'];
            $rate->french = $row['french'];
            $rate->english = $row['english'];
            $rate->marketing = $row['marketing'];
            $rate->accounting = $row['accounting'];
            $rate->office = $row['office'];
            $rate->statistics = $row['statistics'];
            $rate->business_management = $row['business_management'];
            $rate->admin_management = $row['admin_management'];
            $rate->work_legislation = $row['work_legislation'];
            $rate->financial_math = $row['financial_math'];

            $rates[] = $rate;
        }
        return $rates;
    }

    public function getRate(string $identifier): self
    {
        $connection = new Database;
        $statement = $connection->getConnection()->prepare(
            'SELECT * FROM rate WHERE id = ?'
        );
        $statement->execute([$identifier]);
        $row = $statement->fetch();
        $rate = new Self;
        $rate->id = $row['id'];
        $rate->firstname = $row['firstname'];
        $rate->lastname = $row['lastname'];
        $rate->study = $row['study'];
        $rate->french = $row['french'];
        $rate->english = $row['english'];
        $rate->marketing = $row['marketing'];
        $rate->accounting = $row['accounting'];
        $rate->office = $row['office'];
        $rate->statistics = $row['statistics'];
        $rate->business_management = $row['business_management'];
        $rate->admin_management = $row['admin_management'];
        $rate->work_legislation = $row['work_legislation'];
        $rate->financial_math = $row['financial_math'];

        return $rate;
    }

    public function updateRate(int $identifier, string $module, float $value): bool
    {
        $connection = new Database;
        $statement = $connection->getConnection()->prepare(
            str_replace('module', $module, 'UPDATE rate SET module = ? WHERE id = ?')
        );
        
        $affectedLines = $statement->execute([$value, $identifier]);
        return ($affectedLines > 0);
    }
}