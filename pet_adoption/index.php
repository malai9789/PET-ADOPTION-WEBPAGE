<?php
include("db.php");

/* =========================================
   ADOPTION PROCESS
========================================= */

$message = "";

if(isset($_POST['adopt_pet']))
{
    $pet_id = $_POST['pet_id'];

    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    mysqli_query($conn,"INSERT INTO adoptions
    (pet_id,adopter_name,adopter_email,adopter_phone)

    VALUES

    ('$pet_id','$name','$email','$phone')");

    mysqli_query($conn,"
    UPDATE pets
    SET status='Adopted'
    WHERE id='$pet_id'
    ");

    $message = "🎉 Pet Adoption Successful!";
}

/* =========================================
   FILTER
========================================= */

$type = isset($_GET['type']) ? $_GET['type'] : '';

$sql = "SELECT * FROM pets";

if($type != '')
{
    $sql .= " WHERE animal_type='$type'";
}

$result = mysqli_query($conn,$sql);

$totalPets = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM pets"));
$adoptedPets = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM pets WHERE status='Adopted'"));
?>

<!DOCTYPE html>
<html>
<head>

    <title>Pet Adoption Center</title>

    <link rel="stylesheet" href="style.css">

    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>

<body>

<!-- Background -->

<div class="bg-animation">

    <span></span>
    <span></span>
    <span></span>
    <span></span>

</div>

<!-- Navbar -->

<nav class="navbar">

    <div class="logo">
        🐾 PET ADOPT
    </div>

    <ul>

        <li><a href="#">Home</a></li>
        <li><a href="#pets">Pets</a></li>
        <li><a href="#adopt">Adopt</a></li>

    </ul>

</nav>

<!-- Hero -->

<section class="hero">

    <div class="hero-content">

        <h1>Find Your Perfect Pet Companion</h1>

        <p>
            Adopt loving pets and give them a forever home.
        </p>

        <a href="#pets">
            <button>Explore Pets</button>
        </a>

    </div>

</section>

<!-- Success Message -->

<?php
if($message != "")
{
?>

<div class="success-box">

    <?php echo $message; ?>

</div>

<?php
}
?>

<!-- Stats -->

<div class="stats-container">

    <div class="stat-box">

        <h2><?php echo $totalPets; ?></h2>
        <p>Total Pets</p>

    </div>

    <div class="stat-box">

        <h2><?php echo $adoptedPets; ?></h2>
        <p>Adopted Pets</p>

    </div>

    <div class="stat-box">

        <h2>100%</h2>
        <p>Happy Adoptions</p>

    </div>

</div>

<!-- Filter -->

<section class="filter-section">

<form method="GET">

<select name="type">

<option value="">All Animals</option>
<option value="Dog">Dog</option>
<option value="Cat">Cat</option>
<option value="Rabbit">Rabbit</option>
<option value="Bird">Bird</option>

</select>

<button type="submit">

<i class="fa fa-search"></i>
Search

</button>

</form>

</section>

<!-- Pet Cards -->

<section class="pets-section" id="pets">

<div class="title">

<h1>Available Pets</h1>

</div>

<div class="pet-container">

<?php
while($row = mysqli_fetch_assoc($result))
{
?>

<div class="pet-card">

    <div class="pet-image">

        <img src="<?php echo $row['image']; ?>">

    </div>

    <div class="pet-details">

        <div class="pet-top">

            <h2>
                <?php echo $row['pet_name']; ?>
            </h2>

            <span class="status">

                <?php echo $row['status']; ?>

            </span>

        </div>

        <div class="tags">

            <span>
                <?php echo $row['animal_type']; ?>
            </span>

            <span>
                <?php echo $row['breed']; ?>
            </span>

            <span>
                ₹<?php echo $row['adoption_fee']; ?>
            </span>

        </div>

        <p>

            <?php echo $row['description']; ?>

        </p>

<?php
if($row['status'] == 'Available')
{
?>

<form method="POST">

<input type="hidden"
name="pet_id"
value="<?php echo $row['id']; ?>">

<input type="text"
name="name"
placeholder="Your Name"
required>

<input type="email"
name="email"
placeholder="Your Email"
required>

<input type="text"
name="phone"
placeholder="Phone Number"
required>

<button type="submit"
name="adopt_pet"
class="adopt-btn">

<i class="fa fa-heart"></i>
Adopt Now

</button>

</form>

<?php
}
else
{
?>

<button class="adopted-btn">

Already Adopted

</button>

<?php
}
?>

    </div>

</div>

<?php
}
?>

</div>

</section>

<!-- Footer -->

<footer>

<h2>🐾 PET ADOPT</h2>

<p>
Give pets a second chance with love.
</p>

</footer>

</body>
</html>