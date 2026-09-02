<?php

$host = "localhost";
$user = "root";
$password = "";
$database = "pet_adoption";

$conn = mysqli_connect($host, $user, $password);

if(!$conn)
{
    die("Database Connection Failed");
}

mysqli_query($conn,"CREATE DATABASE IF NOT EXISTS $database");

mysqli_select_db($conn,$database);

/* =========================================
   PETS TABLE
========================================= */

$petTable = "

CREATE TABLE IF NOT EXISTS pets(

    id INT PRIMARY KEY AUTO_INCREMENT,

    pet_name VARCHAR(100),

    animal_type VARCHAR(50),

    breed VARCHAR(100),

    gender VARCHAR(20),

    age_group VARCHAR(50),

    color VARCHAR(50),

    vaccinated VARCHAR(20),

    adoption_fee INT,

    location_city VARCHAR(100),

    description TEXT,

    image VARCHAR(255),

    status VARCHAR(50) DEFAULT 'Available',

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP

)

";

mysqli_query($conn,$petTable);

/* =========================================
   ADOPTION TABLE
========================================= */

$adoptionTable = "

CREATE TABLE IF NOT EXISTS adoptions(

    id INT PRIMARY KEY AUTO_INCREMENT,

    pet_id INT,

    adopter_name VARCHAR(100),

    adopter_email VARCHAR(100),

    adopter_phone VARCHAR(20),

    adoption_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP

)

";

mysqli_query($conn,$adoptionTable);

/* =========================================
   INSERT SAMPLE DATA
========================================= */

$check = mysqli_query($conn,"SELECT * FROM pets");

if(mysqli_num_rows($check) == 0)
{

mysqli_query($conn,"INSERT INTO pets
(pet_name,animal_type,breed,gender,age_group,color,vaccinated,adoption_fee,location_city,description,image)

VALUES

('Max','Dog','Golden Retriever','Male','Young','Golden','Yes',5000,'Chennai',
'Friendly and energetic family dog.',
'https://images.unsplash.com/photo-1517849845537-4d257902454a'),

('Luna','Cat','Persian','Female','Adult','White','Yes',3500,'Bangalore',
'Cute calm indoor cat.',
'https://images.unsplash.com/photo-1519052537078-e6302a4968d4'),

('Snow','Rabbit','Mini Lop','Male','Baby','White','No',2000,'Hyderabad',
'Soft and playful rabbit.',
'https://images.unsplash.com/photo-1585110396000-c9ffd4e4b308'),

('Rio','Bird','Macaw','Female','Young','Blue','Yes',4500,'Mumbai',
'Interactive colorful bird.',
'https://images.unsplash.com/photo-1444464666168-49d633b86797')

");

}

?>