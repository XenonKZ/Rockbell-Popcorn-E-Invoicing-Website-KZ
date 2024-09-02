<?php
// Database configuration
$host = 'localhost'; // Change if your database is hosted elsewhere
$dbname = 'e_invoicing';
$username = 'root'; // Change to your MySQL username
$password = ''; // Change to your MySQL password

// Create connection
$conn = new mysqli($host, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database if it doesn't exist
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) !== TRUE) {
    die("Error creating database: " . $conn->error);
}

// Select the database
$conn->select_db($dbname);

// Create table if it doesn't exist
$table_sql = "
    CREATE TABLE IF NOT EXISTS invoices (
        id INT AUTO_INCREMENT PRIMARY KEY,
        restaurant_name VARCHAR(255) NOT NULL,
        date_time DATETIME NOT NULL,
        document_no VARCHAR(50) NOT NULL,
        amount DECIMAL(10, 2) NOT NULL,
        id_type VARCHAR(50) NOT NULL,
        name VARCHAR(255) NOT NULL,
        identity_type VARCHAR(50),
        identity_number VARCHAR(50),
        tin VARCHAR(50),
        sst VARCHAR(50),
        email VARCHAR(255) NOT NULL,
        phone VARCHAR(50) NOT NULL,
        address TEXT NOT NULL,
        postcode VARCHAR(20) NOT NULL,
        city VARCHAR(100) NOT NULL,
        state VARCHAR(100) NOT NULL,
        country VARCHAR(100) NOT NULL
    )";
if ($conn->query($table_sql) !== TRUE) {
    die("Error creating table: " . $conn->error);
}

// Capture system information
$restaurant_name = htmlspecialchars('Rockbell Software SDN BHD');
$date_time = date('Y-m-d H:i:s');
$document_no = uniqid();
$amount = number_format(rand(100, 1000), 2);

// Function to dynamically determine input width
function getInputWidth($maxLength) {
    return $maxLength * 10 . 'px'; // Approx. 10px per character
}

// Initialize form submission flag
$formSubmitted = false;

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $formSubmitted = true;

    // Escape user inputs
    $id_type = $conn->real_escape_string($_POST['id_type']);
    $name = $conn->real_escape_string($_POST['name']);
    $identity_type = isset($_POST['identity_type']) ? $conn->real_escape_string($_POST['identity_type']) : '';
    $identity_number = isset($_POST['identity_number']) ? $conn->real_escape_string($_POST['identity_number']) : '';
    $tin = isset($_POST['tin']) ? $conn->real_escape_string($_POST['tin']) : '';
    $sst = isset($_POST['sst']) ? $conn->real_escape_string($_POST['sst']) : '';
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $address = $conn->real_escape_string($_POST['address']);
    $postcode = $conn->real_escape_string($_POST['postcode']);
    $city = $conn->real_escape_string($_POST['city']);
    $state = $conn->real_escape_string($_POST['state']);
    $country = $conn->real_escape_string($_POST['country']);

    // Prepare SQL query
    $sql = "INSERT INTO invoices (restaurant_name, date_time, document_no, amount, id_type, name, identity_type, identity_number, tin, sst, email, phone, address, postcode, city, state, country)
    VALUES ('$restaurant_name', '$date_time', '$document_no', '$amount', '$id_type', '$name', '$identity_type', '$identity_number', '$tin', '$sst', '$email', '$phone', '$address', '$postcode', '$city', '$state', '$country')";

    // Execute the query
    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Invoicing Website</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            box-sizing: border-box;
        }
        .container {
            width: 100%;
            max-width: 800px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin: 20px 0;
            box-sizing: border-box;
        }
        .header-logo {
            width: 400px;
            height: auto;
            display: block;
            margin: 0 auto;
        }
        h1 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
            text-align: center;
        }
        .auto-display {
            margin-bottom: 20px;
            font-size: 16px;
            color: #555;
        }
        .auto-display p {
            margin: 5px 0;
        }
        .auto-display .box {
            background-color: #FFDF7B;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 10px;
            margin: 5px 0;
            margin-bottom: 15px;
            box-sizing: border-box;
        }
        .user-entry {
            font-size: 16px;
            color: #333;
        }
        .user-entry label {
            font-weight: bold;
            margin-top: 10px;
        }
        .user-entry input, .user-entry select {
            width: 100%;
            padding: 10px;
            margin: 5px 0 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
        }
        .identity-group {
            display: flex;
            flex-direction: column;
            margin-top: 10px;
        }
        .identity-group .label-row {
            margin-bottom: 5px;
        }
        .identity-group .input-row {
            display: flex;
            align-items: center;
        }
        .identity-group select {
            flex: 1 1 30%; /* Takes up 30% of the space */
            margin-right: 10px; /* Space between select and input */
        }
        .identity-group input {
            flex: 1 1 70%; /* Takes up 70% of the space */
            max-width: 100%;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .hidden {
            display: none;
        }
    </style>

    <script>
        function toggleFields() {
            var idType = document.getElementById('id_type').value;
            var identityGroup = document.querySelector('.identity-group');
            var sstField = document.getElementById('sst_field');
            
            if (idType === 'individual') {
                identityGroup.classList.remove('hidden');
                sstField.classList.add('hidden');
            } else {
                identityGroup.classList.add('hidden');
                sstField.classList.remove('hidden');
            }
        }

        window.onload = function() {
            document.getElementById('id_type').addEventListener('change', toggleFields);
            toggleFields(); // Initial check on page load
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>
            <img src="PopcornLogo.jpg" alt="Logo" class="header-logo">
            E-Invoicing Website
        </h1>

        <!-- Auto-display section -->
        <div class="auto-display">
            <p><strong>Restaurant Name:</strong></p>    
            <div class="box"><?php echo $restaurant_name; ?></div>
            <p><strong>Date Time:</strong></p>
            <div class="box"><?php echo $date_time; ?></div>
            <p><strong>Document No:</strong></p>
            <div class="box"><?php echo $document_no; ?></div>
            <p><strong>Amount:</strong></p>
            <div class="box"><?php echo $amount; ?></div>
        </div>
    </div>
    
    <div class="container">
        <!-- User-entry section -->
        <div class="user-entry">
            <form method="post" action="">
                <label for="id_type">ID Type:</label>
                <select id="id_type" name="id_type">
                    <option value="individual">Individual</option>
                    <option value="business">Business</option>
                    <option value="government">Government</option>
                </select>

                <label for="email">Email Address:</label>
                <input type="email" id="email" name="email">
                
                <label for="name">Name:</label>
                <input type="text" id="name" name="name">

                <div class="identity-group hidden">
                    <div class="label-row">
                        <label for="identity_type">Identity:</label>
                    </div>
                    <div class="input-row">
                        <select id="identity_type" name="identity_type">
                            <option value="mykad">MyKAD</option>
                            <option value="mypr">MyPR</option>
                            <option value="mykas">MyKAS</option>
                            <option value="passport">Passport</option>
                            <option value="mytentera">MyTentera</option>
                        </select>
                        <input type="text" id="identity_number" name="identity_number" placeholder="Identity Number">
                    </div>
                </div>

                <div id="tin_field">
                    <label for="tin">Tax Identification Number (TIN):</label>
                    <input type="text" id="tin" name="tin">
                </div>

                <div id="sst_field">
                    <label for="sst">SST Registration No:</label>
                    <input type="text" id="sst" name="sst">
                </div>
                
                <label for="phone">Mobile Phone No:</label>
                <input type="text" id="phone" name="phone" value="+60">

                <label for="address">Address:</label>
                <input type="text" id="address" name="address">

                <label for="postcode">Postcode:</label>
                <input type="text" id="postcode" name="postcode">

                <label for="city">City:</label>
                <input type="text" id="city" name="city">

                <label for="state">State:</label>
                <select id="state" name="state">
                    <option value="johor">Johor</option>
                    <option value="kedah">Kedah</option>
                    <option value="kelantan">Kelantan</option>
                    <option value="melaka">Melaka</option>
                    <option value="negeri_sembilan">Negeri Sembilan</option>
                    <option value="pahang">Pahang</option>
                    <option value="penang">Penang</option>
                    <option value="perak">Perak</option>
                    <option value="perlis">Perlis</option>
                    <option value="sabah">Sabah</option>
                    <option value="sarawak">Sarawak</option>
                    <option value="selangor">Selangor</option>
                    <option value="terengganu">Terengganu</option>
                    <option value="wilayah_persekutuan">Wilayah Persekutuan</option>
                </select>

                <label for="country">Country:</label>
                <select id="country" name="country">
                    <option value="malaysia">Malaysia</option>
                    <option value="singapore">Singapore</option>
                    <option value="indonesia">Indonesia</option>
                    <option value="thailand">Thailand</option>
                    <option value="philippines">Philippines</option>
                </select>

                <input type="submit" value="Submit">
            </form>
        </div>
    </div>
</body>
</html>
