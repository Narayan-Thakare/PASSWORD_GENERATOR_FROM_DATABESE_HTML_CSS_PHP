<!DOCTYPE html>
<html>
<head>
    <title>Password Generator</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
        }
        .container {
            width: 50%;
            margin: 0 auto;
            padding: 20px;
        }
        h1 {
            color: #333;
        }
        form {
            background: #f2f2f2;
            padding: 20px;
            border-radius: 5px;
        }
        label {
            display: block;
            font-weight: bold;
            margin-top: 10px;
        }
        input[type="submit"] {
            background: #0074cc;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background: #0056a7;
        }
        .password-list {
            margin-top: 20px;
            text-align: left;
        }
    </style>
</head>
<body>

<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = '';
$dbname = "asteriscstudents";

if (isset($_POST['name'])) {
    $name = $_POST['name'];

    try {
        // Connect to the database
        $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Retrieve data for the provided name
        $query = $pdo->prepare('SELECT full_name,pin_code FROM student_admission WHERE full_name = :name');
        $query->bindParam(':name', $name);
        $query->execute();
        $data = $query->fetchAll(PDO::FETCH_ASSOC);

        // Function to generate passwords
        function generatePassword($data) {
          //  $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
           // $characters = '0123456789';
            $pinData = $data['pin_code'];

            $randomData = $data['full_name'];
            $passwords = array();

            //-----------------------------------------------------


           //if do you want to suffel or way by way
            
            // for ($i = 0; $i < 10; $i++) {
            //     $passwords[] = substr(str_shuffle($pinData), 0, 3) . $randomData .$pinData;
            // }
 ////////////////////////////============

            for ($i = 0; $i < 10; $i++) {
                $passwords[] = substr(str_shuffle($pinData), 0, 4) .substr($randomData, 0, 3) . $pinData;


//you will give the multyple type of data

             //   $passwords[] = substr(str_shuffle($pinData), 0, 4) .substr($randomData, 0, 5) . $pinData;

            }
            
            return $passwords;
        }

        $passwords = generatePassword($data[0]);
    } catch (PDOException $e) {
        die("Database connection failed: " . $e->getMessage());
    }
}
?>

<div class="container">
    <h1>Password Generator</h1>
    <form action="#" method="post">
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" required>
        <input type="submit" value="Generate Passwords">
    </form>

    <div class="password-list">
        <?php
        if (isset($passwords)) {
            echo "<h2>Generated Passwords:</h2>";
            foreach ($passwords as $password) {
                echo "<p>$password</p>";
            }
        }
        ?>
    </div>
</div>
</body>
</html>
