<?php
declare(strict_types=1);

namespace Ipem\Src\Model;

use Ipem\Src\Lib\Database;

class User 
{
    public $id;
    public $identifier;
    public $password;
    public $firstname;
    public $lastname;
    public $token;

    public function getUsers(): array
    {
        $connection = new Database;
        $statement = $connection->getConnection()->query(
            'SELECT id, password, token, identifier
            FROM users 
            ORDER BY id ASC'
        );        
        $users = [];
        while($row = $statement->fetch()) {
            $user = new self;
            $user->id = $row['id'];
            $user->identifier = $row['identifier'];
            $user->password = $row['password'];
            $user->token = $row['token'];
            $users[] = $user;
        }
        return $users;
    }

    public function getUser(string $user_id): self
    {
        $connection = new Database;
        $statement = $connection->getConnection()->prepare(
            'SELECT id, firstname, lastname, password, identifier 
            FROM users
            WHERE id = ?'
        );
        
        $statement->execute([$user_id]);
        $row = $statement->fetch();
        $user = new self;
        $user->id = $row['id'];
        $user->firstname = $row['firstname'];
        $user->lastname = $row['lastname'];
        $user->identifier = $row['identifier'];
        $user->password = $row['password'];

        return $user;
    }

    public function setPassword(string $user_id, string $new_password): bool
    {
        $connection = new Database;
        $statement = $connection->getConnection()->prepare(
            'UPDATE users SET password = ? WHERE id = ?'
        );    

        $affectedLines = $statement->execute([$new_password, (int)$user_id]);
        return ($affectedLines > 0);
    }

    public function getIdUser(string $identifier):int 
    {
        $connection = new Database;
        $statement = $connection->getConnection()->prepare(
            'SELECT id FROM users WHERE identifier = ?'
        );
        $statement->execute([$identifier]);
        return ($row = $statement->fetch()) ? (int)$row['id'] : 0;
    }
    public function getData(string $exam_name, string $module_slug, string $year, string $study, int $group, string $exam_type, int $limit, int $offset): array {
        $connection = new Database;
        $statement = $connection->getConnection()->prepare('
            SELECT firstname, lastname, identifier
            FROM users u 
            JOIN students s ON u.id = s.user_id
            JOIN registrations r ON s.id = r.student_id
            JOIN years y ON y.id = r.year_id
            JOIN studies st ON st.id = r.study_id
            JOIN groupes g ON g.id = r.group_id
            JOIN exams e ON e.exam_name = ?
            JOIN exams_types et ON et.id = e.exam_type_id
            JOIN modules m ON m.id = (SELECT id FROM modules WHERE slug = ?)
            LEFT JOIN averages a ON r.id = a.registration_id AND a.exam_id = e.id AND a.module_id = m.id
            WHERE y.name = ?
            AND st.name = ?
            AND g.group_number = ?
            AND et.exam_type = ?
            AND a.registration_id IS NULL
            ORDER BY u.id ASC 
            LIMIT ?
            OFFSET ?
        ');
        $statement->execute([$exam_name, $module_slug ,$year, $study, $group, $exam_type, $limit, $offset]);
        $data = [];
        while($row = $statement->fetch()) {
            $line = new self;
            $line->firstname = $row['firstname'];
            $line->lastname = $row['lastname'];
            $line->identifier = $row['identifier'];
            $data[] = $line;
        }
        return $data;
    }
    public function getDataCount(string $year, string $study, int $group):int {
        $connection = new Database;
        $statement = $connection->getConnection()->prepare('
            SELECT count(r.id) as count FROM registrations r
            JOIN years y ON y.id = r.year_id
            JOIN studies st ON st.id = r.study_id
            JOIN groupes g ON g.id = r.group_id
            WHERE y.name = ?
            AND st.name = ?
            AND g.group_number = ?
        ');
        $statement->execute([$year, $study, $group]);
        $row = $statement->fetch(\PDO::FETCH_NUM)[0];
        return $row;
    }
}