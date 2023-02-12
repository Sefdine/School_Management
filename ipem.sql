-- Active: 1675950352285@@127.0.0.1@3306@ipem
#       script MySQL
#--------------------------------------------------------
CREATE DATABASE ipem
    DEFAULT CHARACTER SET = 'utf8mb4';

#--------------------------------------------------------
#   Table: users
#--------------------------------------------------------
CREATE TABLE users(
    id INTEGER AUTO_INCREMENT NOT NULL,
    firstname VARCHAR(125) NOT NULL,
    lastname VARCHAR(125) NOT NULL,
    identifier VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    token VARCHAR(255) NOT NULL,
    CONSTRAINT users_PK PRIMARY KEY (id)
)ENGINE=InnoDB;

#--------------------------------------------------------
#   Table: students
#--------------------------------------------------------
CREATE TABLE students(
    id INTEGER AUTO_INCREMENT NOT NULL,
    nationality VARCHAR(125) NOT NULL,
    date_of_birth DATE,
    address VARCHAR(255),
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
    email VARCHAR(255),
    tel VARCHAR(125),
    address VARCHAR(255),
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
    name VARCHAR(125) NOT NULL,
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
    name VARCHAR(125) NOT NULL,
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
    name VARCHAR(125) NOT NULL,
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
    absence INTEGER,
    CONSTRAINT teachs_PK PRIMARY KEY (teacher_id, module_id),
    UNIQUE (teacher_id, module_id),
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
#   Table: levelsModules
#--------------------------------------------------------
CREATE TABLE levelsModules(
    level_id INTEGER NOT NULL,
    module_id INTEGER NOT NULL,
    CONSTRAINT levelsModules_PK PRIMARY KEY (level_id, module_id),
    UNIQUE (level_id, module_id),
    CONSTRAINT levelsModules_levels_FK FOREIGN KEY (level_id) REFERENCES levels(id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT levelsModules_modules_FK FOREIGN KEY (module_id) REFERENCES modules(id) ON DELETE CASCADE ON UPDATE CASCADE
);
INSERT INTO contain (year_id, study_id, group_id, level_id)
VALUES
    (1, 1, 1, 1),
    (1, 1, 1, 2),
    (1, 1, 2, 1),
    (1, 1, 2, 2),
    (1, 1, 3, 1),
    (1, 1, 4, 1);

INSERT INTO exams (number) VALUES (1), (2), (3);

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

ALTER TABLE levelsModules ALTER COLUMN level_id SET DEFAULT 3;

INSERT INTO averages (registration_id, module_id)
VALUES
    (1, 1),
    (1, 2),
    (1, 3),
    (56, 1),
    (56, 2),
    (56, 3);
