<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <!-- Custom CSS -->
    <style>
        /* Add your custom CSS styles here */
        body {
            padding: 20px;
        }
        form {
            max-width: 400px;
            margin: 0 auto;
            background: #f7f7f7;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
    </style>

    <title>Login Page</title>
</head>
<body>
    <form action="ligin.php" method="post">
        <div class="form-group">
            <label for="cin">CIN:</label>
            <input type="text" class="form-control" id="cin" name="cin">
        </div>
        <div class="form-group">
            <label for="matricule">Matricule:</label>
            <input type="text" class="form-control" id="matricule" name="matricule">
        </div>
        <button type="submit" class="btn btn-primary" name="ok">Connecter</button>
    </form>
    <!-- Bootstrap JS (optional) -->
    <!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8sh+TpOp4uJdo7EbbfjM+nA3ndDh4cCKF7tk+X" crossorigin="anonymous"></script> -->
</body>
</html>

<?php
session_start();
require "connection.php"; // Ensure this file exists and contains PDO connection code

if (isset($_POST["ok"])) {
    $cin = $_POST["cin"];
    $matricule = $_POST["matricule"];

    if (!empty($cin) && !empty($matricule)) {
        $req = $cx->prepare('SELECT * FROM employers WHERE cin = :cin AND matricule = :matricule');
        $req->bindParam(':cin', $cin);
        $req->bindParam(':matricule', $matricule);
        $req->execute();

        if ($req->rowCount() == 1) {
            $_SESSION['user'] = $req->fetch(PDO::FETCH_ASSOC);
            header('Location: hello.php');
            exit();
        } else {
            echo "<div class='alert alert-danger mt-3'>CIN or Matricule incorrect.</div>";
        
        }
    } else {
        echo "<script>alert('Please fill in all fields.')</script>";
     
    }
}
?>
