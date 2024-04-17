<?php
if(isset($_POST['username'], $_POST['password'], $_POST['Gender'], $_POST['email'], $_POST['phonecode'], $_POST['phone'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $gender = $_POST['Gender'];
    $email = $_POST['email'];
    $phonecode = $_POST['phonecode'];
    $phone = $_POST['phone'];

    if (!empty($username) || !empty($password) || !empty($gender) || !empty($phonecode) || !empty($phone)) {
        $host = "localhost";
        $dbUsername = "root";
        $dbPassword = "";
        $dbname = "form";
        $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);
        
        if (mysqli_connect_error()) {
            die('Connect Error('.mysqli_connect_errno().')'.mysqli_connect_error());
        } else {
            $SELECT = "SELECT email FROM register WHERE email = ? LIMIT 1";
            $INSERT = "INSERT INTO register (username, password, gender, email, phonecode, phone) VALUES (?, ?, ?, ?, ?, ?)";

            $stmt = $conn->prepare($SELECT);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->bind_result($email);
            $stmt->store_result();
            $rnum = $stmt->num_rows;

            if ($rnum == 0) {
                $stmt->close();
                $stmt = $conn->prepare($INSERT);
                $stmt->bind_param("ssssii", $username, $password, $gender, $email, $phonecode, $phone);
                $stmt->execute();
                echo "New record inserted successfully";
            } else {
                echo "Someone already registered using this email";
            }

            $stmt->close();
            $conn->close();
        }
    } else {
        echo "All fields are required";
    }
} else {
    echo "Form submission error";
}
?>
