-- Active: 1677485651157@@117.0.0.1@1106@ipem
#       script MySQL
#--------------------------------------------------------
CREATE DATABASE ipem
    DEFAULT CHARACTER SET = 'utf8mb4';

#--------------------------------------------------------
#   Table: users
#--------------------------------------------------------
CREATE TABLE users(
    id INTEGER AUTO_INCREMENT NOT NULL,
    firstname VARCHAR(115) NOT NULL,
    lastname VARCHAR(115) NOT NULL,
    identifier VARCHAR(50) NOT NULL,
    password VARCHAR(155) NOT NULL,
    token VARCHAR(155) NOT NULL,
    CONSTRAINT users_PK PRIMARY KEY (id)
)ENGINE=InnoDB;

#--------------------------------------------------------
#   Table: students
#--------------------------------------------------------
CREATE TABLE students(
    id INTEGER AUTO_INCREMENT NOT NULL,
    nationality VARCHAR(115) NOT NULL,
    date_of_birth DATE,
    address VARCHAR(155),
    cin VARCHAR(50),
    user_id INTEGER NOT NULL, 
    CONSTRAINT students_PK PRIMARY KEY (id),
    CONSTRAINT students_users_FK FOREIGN KEY (user_id) 
        REFERENCES users(id) 
        ON DELETE CASCADE 
        ON UPDATE CASCADE
)ENGINE=InnoDB;

#--------------------------------------------------------
#   Table: teachers
#--------------------------------------------------------
CREATE TABLE teachers(
    id INTEGER AUTO_INCREMENT NOT NULL,
    email VARCHAR(155),
    tel VARCHAR(115),
    address VARCHAR(155),
    cin VARCHAR(50),
    user_id INTEGER NOT NULL, 
    CONSTRAINT teachers_PK PRIMARY KEY (id),
    CONSTRAINT teachers_users_FK FOREIGN KEY (user_id) 
        REFERENCES users(id) 
        ON DELETE CASCADE 
        ON UPDATE CASCADE
)ENGINE=InnoDB;

#--------------------------------------------------------
#   Table: years
#--------------------------------------------------------
CREATE TABLE years(
    id INTEGER AUTO_INCREMENT NOT NULL,
    name VARCHAR(4) NOT NULL,
    CONSTRAINT years_PK PRIMARY KEY (id)
)ENGINE=InnoDB;

#--------------------------------------------------------
#   Table: studies
#--------------------------------------------------------
CREATE TABLE studies(
    id INTEGER AUTO_INCREMENT NOT NULL,
    name VARCHAR(115) NOT NULL,
    year_id INTEGER NOT NULL,
    CONSTRAINT studies_PK PRIMARY KEY (id),
    CONSTRAINT studies_years_FK FOREIGN KEY (year_id)
        REFERENCES years(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
)ENGINE=InnoDB;

#--------------------------------------------------------
#   Table: groupes
#--------------------------------------------------------
CREATE TABLE groupes(
    id INTEGER AUTO_INCREMENT NOT NULL,
    name VARCHAR(115) NOT NULL,
    study_id INTEGER NOT NULL,
    CONSTRAINT groupes_PK PRIMARY KEY (id),
    CONSTRAINT groupes_studies_FK FOREIGN KEY (study_id)
        REFERENCES years(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
)ENGINE=InnoDB;

#--------------------------------------------------------
#   Table: levels
#--------------------------------------------------------
CREATE TABLE levels(
    id INTEGER AUTO_INCREMENT NOT NULL,
    level INTEGER NOT NULL,
    group_id INTEGER NOT NULL,
    CONSTRAINT levels_PK PRIMARY KEY (id),
    CONSTRAINT levels_groupes_FK FOREIGN KEY (group_id)
        REFERENCES groupes(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
)ENGINE=InnoDB;

#--------------------------------------------------------
#   Table: modules
#--------------------------------------------------------
CREATE TABLE modules(
    id INTEGER NOT NULL AUTO_INCREMENT,
    name VARCHAR(115) NOT NULL,
    level_id INTEGER NOT NULL,
    CONSTRAINT modules_PK PRIMARY KEY (id),
    CONSTRAINT modules_levels_FK FOREIGN KEY (level_id)
        REFERENCES levels(id) 
        ON DELETE CASCADE
        ON UPDATE CASCADE
)ENGINE=InnoDB;

#--------------------------------------------------------
#   Table: exams
#--------------------------------------------------------
CREATE TABLE exams(
    id INTEGER NOT NULL AUTO_INCREMENT,
    number INTEGER NOT NULL,
    CONSTRAINT exams_PK PRIMARY KEY (id)
)ENGINE=InnoDB;

#--------------------------------------------------------
#   Table: averages
#--------------------------------------------------------
CREATE TABLE averages(
    average DOUBLE NOT NULL,
    exam_id INTEGER NOT NULL,
    module_id INTEGER NOT NULL,
    CONSTRAINT averages_PK PRIMARY KEY (exam_id, module_id),
    UNIQUE(exam_id, module_id),
    CONSTRAINT averages_exams_FK FOREIGN KEY (exam_id)
        REFERENCES exams(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    CONSTRAINT averages_modules_FK FOREIGN KEY (module_id)
        REFERENCES modules(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
)ENGINE=InnoDB;

#--------------------------------------------------------
#   Table: registrations
#--------------------------------------------------------
CREATE TABLE registrations(
    registration_date DATE DEFAULT (CURDATE()),
    student_id INTEGER NOT NULL,
    level_id INTEGER NOT NULL,
    CONSTRAINT registrations_PK PRIMARY KEY (student_id, level_id),
    UNIQUE (student_id, level_id),
    CONSTRAINT registrations_students_FK FOREIGN KEY (student_id)
        REFERENCES students(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    CONSTRAINT registrations_levels_FK FOREIGN KEY (level_id)
        REFERENCES levels(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
)ENGINE=InnoDB;

#--------------------------------------------------------
#   Table: teachs
#--------------------------------------------------------
CREATE TABLE teachs(
    teacher_id INTEGER NOT NULL,
    module_id INTEGER NOT NULL,
    contain_id INTEGER NOT NULL,
    absence INTEGER,
    CONSTRAINT teachs_PK PRIMARY KEY (teacher_id, module_id),
    UNIQUE (teacher_id, module_id, contain_id),
    CONSTRAINT teachs_teachers_FK FOREIGN KEY (teacher_id)
        REFERENCES teachers(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    CONSTRAINT teachs_modules_FK FOREIGN KEY (module_id)
        REFERENCES modules(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
)ENGINE=InnoDB;

#--------------------------------------------------------
#   Table: contain
#--------------------------------------------------------
CREATE TABLE contain(
    id INTEGER AUTO_INCREMENT NOT NULL,
    year_id INTEGER NOT NULL,
    study_id INTEGER NOT NULL,
    group_id INTEGER NOT NULL,
    level_id INTEGER NOT NULL,
    CONSTRAINT contain_PK PRIMARY KEY (id),
    CONSTRAINT contain_years_FK FOREIGN KEY (year_id)
        REFERENCES years(id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT contain_studies_FK FOREIGN KEY (study_id)
        REFERENCES studies(id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT contain_groupes_FK FOREIGN KEY (group_id)
        REFERENCES groupes(id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT contain_levels_FK FOREIGN KEY (level_id)
        REFERENCES levels(id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT contain_modules_FK FOREIGN KEY (module_id)
        REFERENCES modules(id) ON DELETE CASCADE ON UPDATE CASCADE,
    UNIQUE(year_id, study_id, group_id, level_id, module_id)
)ENGINE=InnoDB;

#--------------------------------------------------------
#   Table: containModules
#--------------------------------------------------------
CREATE TABLE contain_modules (
    id INTEGER AUTO_INCREMENT NOT NULL,
    contain_id INTEGER NOT NULL,
    module_id INTEGER NOT NULL, 
    CONSTRAINT contain_modules_PK PRIMARY KEY (id),
    CONSTRAINT cm_contain FOREIGN KEY (contain_id) REFERENCES contain(id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT cm_modules FOREIGN KEY (module_id) REFERENCES modules(id) ON DELETE CASCADE ON UPDATE CASCADE
)ENGINE=InnoDB;

INSERT INTO contain (year_id, study_id, group_id, level_id)
VALUES
    (1, 1, 1, 1),
    (1, 1, 1, 1),
    (1, 1, 1, 1),
    (1, 1, 1, 1),
    (1, 1, 1, 1),
    (1, 1, 4, 1);

INSERT INTO exams (number) VALUES (1), (1), (1);

INSERT INTO modules (name)
VALUES 
    ('Anglais'),
    ('Français'),
    ('Informatique'),
    ('Action commerciale'),
    ('Statistiques'),
    ('Mathématiques financières'),
    ('Comptabilité général'),
    ('Gestion de l\'entreprise'),
    ('Gestion administrative'),
    ('Législation du travail');

INSERT INTO levelsModules(module_id)
SELECT id FROM modules ORDER BY id ASC;

ALTER TABLE levelsModules ALTER COLUMN level_id SET DEFAULT 1;

INSERT INTO averages (registration_id, module_id)
VALUES
    (1, 1),
    (1, 1),
    (1, 1),
    (56, 1),
    (56, 1),
    (56, 1);

INSERT INTO teachs (teacher_id, contain_id, module_id)
VALUES
    (1, 1, 4),
    (1, 1, 8);

SELECT * FROM averages;


SELECT DISTINCT s.name AS study, g.name AS groupe, l.level, u.identifier
    FROM contain c
    JOIN studies s ON c.study_id = s.id
    JOIN groupes g ON c.group_id = g.id
    JOIN levels l ON c.level_id = l.id
    JOIN years y ON c.year_id = y.id
    JOIN registrations r ON c.id = r.contain_id
    JOIN averages a ON r.id = a.registration_id
    JOIN exams e ON e.id = a.exam_id
    JOIN students st ON r.student_id = st.id
    JOIN users u ON st.user_id = u.id
    WHERE y.name = '1011'
    AND e.number = 1
    AND u.id = 65;


SELECT m.name AS module_name, m.slug FROM modules m 
            JOIN contain_modules cm ON m.id = cm.module_id
            JOIN contain c ON c.id = cm.contain_id
            JOIN groupes g ON g.id = c.group_id
            JOIN levels l ON l.id = c.level_id
            JOIN studies s ON s.id = c.study_id
            JOIN years y ON y.id = c.year_id 
            WHERE l.level = 1
            AND g.slug = 'licence'
            AND s.name = 'Gestion des entreprises'
            AND y.name = '1011'; 

SELECT * FROM contain_modules;

INSERT INTO contain_modules(contain_id, module_id)
VALUES (3, 1), (3, 2) , (3, 3), (3, 4), (3, 5), (3, 6), (3, 7), (3, 8), (3, 9), (3, 10);

