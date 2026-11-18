CREATE DATABASE IF NOT EXISTS db_kampus CHARACTER SET utf8mb4;
USE db_kampus;

-- Hapus tabel anak dulu agar tidak terhalang foreign key
DROP TABLE IF EXISTS courses;
DROP TABLE IF EXISTS lecturers;
DROP TABLE IF EXISTS departments;

-- Tabel baru: departemen
CREATE TABLE departments (
  id   INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL UNIQUE
) ENGINE=InnoDB;

-- Tabel lama + atribut baru (email, department_id)
CREATE TABLE lecturers (
  id            INT AUTO_INCREMENT PRIMARY KEY,
  name          VARCHAR(100) NOT NULL,
  nidn          VARCHAR(20),
  phone         VARCHAR(20),
  join_date     DATE,
  email         VARCHAR(100),
  department_id INT NULL,
  -- departemen dihapus -> dosen tetap ada, department_id jadi NULL
  FOREIGN KEY (department_id) REFERENCES departments(id)
    ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB;

-- Tabel baru: mata kuliah
CREATE TABLE courses (
  id          INT AUTO_INCREMENT PRIMARY KEY,
  code        VARCHAR(10)  NOT NULL UNIQUE,
  name        VARCHAR(100) NOT NULL,
  credits     TINYINT NOT NULL DEFAULT 3,
  semester    TINYINT NOT NULL DEFAULT 1,
  lecturer_id INT NOT NULL,
  -- dosen dihapus -> mata kuliahnya ikut terhapus
  FOREIGN KEY (lecturer_id) REFERENCES lecturers(id)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

-- Data contoh
INSERT INTO departments (name) VALUES ('Teknik Informatika'), ('Sistem Informasi');
INSERT INTO lecturers (name,nidn,phone,join_date,email,department_id) VALUES
 ('Budi Santoso','0411018801','081234567890','2015-08-01','budi@kampus.ac.id',1),
 ('Siti Aminah','0422028502','081298765432','2018-02-15','siti@kampus.ac.id',2);
INSERT INTO courses (code,name,credits,semester,lecturer_id) VALUES
 ('IF101','Pemrograman Web',3,3,1),
 ('SI201','Basis Data',3,2,2);
