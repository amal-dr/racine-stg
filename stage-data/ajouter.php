<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AJOUTER</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .form-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-group input, .form-group select {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }
        .form-group textarea {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            resize: vertical;
        }
        .form-group button {
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            background-color: #007BFF;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }
        .form-group button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Ajouter un Dossier</h1>
        <form  method="post">
            <!-- General Information -->
            <div class="form-group">
                <label for="num">Numéro:</label>
                <input type="text" id="num" name="num" required>
            </div>
            <div class="form-group">
                <label for="demo">Demo:</label>
                <input type="text" id="demo" name="demo">
            </div>
            <div class="form-group">
                <label for="eng">Enseigne</label>
                <input type="text" id="eng" name="eng">
            </div>
            <div class="form-group">
                <label for="adresse">Address:</label>
                <input type="text" id="adresse" name="adresse">
            </div>

            <!-- Entity Type and Location -->
            <div class="form-group">
                <label for="typeentite">Entity Type:</label>
              <input type="text" name="typeentite" id="">
            </div>
            <div class="form-group">
                <label for="localite">Locality:</label>
                <input type="text" id="localite" name="localite">
            </div>
            <div class="form-group">
                <label for="provinces">Province:</label>
                <input type="text" name="provinces" id="">
            </div>

            <!-- Responsible Persons -->
            <div class="form-group">
                <label for="responsablelegaux">l Representatives LegaUX:</label>
                <textarea id="responsablelegaux" name="responsablelegaux" rows="3"></textarea>
            </div>
            <div class="form-group">
                <label for="responsableactive"> Representatives Active:</label>
                <textarea id="responsableactive" name="responsableactive" rows="3"></textarea>
            </div>

            <!-- Important Dates -->
            <div class="form-group">
                <label for="datedebut"> Date dE debut:</label>
                <input type="date" id="datedebut" name="datedebut">
            </div>
            <div class="form-group">
                <label for="numrc">NumRC :</label>
                <input type="text" id="numrc" name="numrc">
            </div>

            <!-- Submit Button -->
            <div class="form-group">
              <button><input type="submit" value="ajouter" name="ok"></button> 
            </div>
        </form>
    </div>
    <a href="hello.php" class="btn btn-secondary mt-3">Retour à la page d'accueil</a>

</body>
</html>
<?php
require "connection.php"; // Ensure this file exists and contains PDO connection code

if (isset($_POST["ok"])) { // Check if the submit button was pressed
    // Collect form data
    $num = $_POST["num"];
    $demo = $_POST["demo"];
    $eng = $_POST["eng"];
    $adresse = $_POST["adresse"];
    $typeentite = $_POST["typeentite"];
    $localite = $_POST["localite"];
    $provinces = $_POST["provinces"];
    $responsablelegaux = $_POST["responsablelegaux"];
    $responsableactive = $_POST["responsableactive"];
    $datedebut = $_POST["datedebut"];
    $numrc = $_POST["numrc"];

    try {
        // Prepare SQL statement
        $req = "INSERT INTO folders 
                (numi, demo, eng, adresse, typeentite, localite, provinces, responsablelegaux, responsableactive, datedebut, numrc) 
                VALUES 
                (:num, :demo, :eng, :adresse, :typeentite, :localite, :provinces, :responsablelegaux, :responsableactive, :datedebut, :numrc)";
                
        $stmt = $cx->prepare($req);

        // Bind parameters
        $stmt->bindParam(':num', $num);
        $stmt->bindParam(':demo', $demo);
        $stmt->bindParam(':eng', $eng);
        $stmt->bindParam(':adresse', $adresse);
        $stmt->bindParam(':typeentite', $typeentite);
        $stmt->bindParam(':localite', $localite);
        $stmt->bindParam(':provinces', $provinces);
        $stmt->bindParam(':responsablelegaux', $responsablelegaux);
        $stmt->bindParam(':responsableactive', $responsableactive);
        $stmt->bindParam(':datedebut', $datedebut);
        $stmt->bindParam(':numrc', $numrc);

        // Execute the statement
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo "<script>alert('Added Successfully!'); window.location.href='hello.php';</script>";
        } else {
            echo "Error adding record.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
