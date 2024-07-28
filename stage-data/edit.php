<?php
session_start();
require_once('connection.php'); // Ensure this file contains PDO connection setup

// Check if numi parameter is present
if (!isset($_REQUEST['numi']) || empty($_REQUEST['numi'])) {
    echo "Numéro de dossier non spécifié.";
    exit;
}

$num = $_REQUEST['numi'];

try {
    // Fetch dossier details for editing
    $query = "SELECT * FROM folders WHERE numi = :num";
    $stmt = $cx->prepare($query);
    $stmt->bindParam(':num', $num);
    $stmt->execute();
    $dossier = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$dossier) {
        echo "Dossier non trouvé.";
        exit;
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier</title>
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
        .form-group input, .form-group textarea {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
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
        <h1>Modifier un Dossiern</h1>
        <form method="post">
            <!-- Hidden field to store the numi for update -->
            <input type="hidden" name="numi" value="<?php echo htmlspecialchars($dossier['numi']); ?>">

            <!-- General Information -->
            <div class="form-group">
                <label for="demo">Demo:</label>
                <input type="text" id="demo" name="demo" value="<?php echo htmlspecialchars($dossier['demo']); ?>">
            </div>
            <div class="form-group">
                <label for="eng">Eng:</label>
                <input type="text" id="eng" name="eng" value="<?php echo htmlspecialchars($dossier['eng']); ?>">
            </div>
            <div class="form-group">
                <label for="adresse">Addresse:</label>
                <input type="text" id="adresse" name="adresse" value="<?php echo htmlspecialchars($dossier['adresse']); ?>">
            </div>

            <!-- Entity Type and Location -->
            <div class="form-group">
                <label for="typeentite">type entite:</label>
                <input type="text" id="typeentite" name="typeentite" value="<?php echo htmlspecialchars($dossier['typeentite']); ?>">
            </div>
            <div class="form-group">
                <label for="localite">Localite:</label>
                <input type="text" id="localite" name="localite" value="<?php echo htmlspecialchars($dossier['localite']); ?>">
            </div>
            <div class="form-group">
                <label for="provinces">Province:</label>
                <input type="text" id="provinces" name="provinces" value="<?php echo htmlspecialchars($dossier['provinces']); ?>">
            </div>

            <!-- Responsible Persons -->
            <div class="form-group">
                <label for="responsablelegaux">responsable legaux:</label>
                <textarea id="responsablelegaux" name="responsablelegaux" rows="3"><?php echo htmlspecialchars($dossier['responsablelegaux']); ?></textarea>
            </div>
            <div class="form-group">
                <label for="responsableactive">responsable active:</label>
                <textarea id="responsableactive" name="responsableactive" rows="3"><?php echo htmlspecialchars($dossier['responsableactive']); ?></textarea>
            </div>

            <!-- Important Dates -->
            <div class="form-group">
                <label for="datedebut">date debut:</label>
                <input type="date" id="datedebut" name="datedebut" value="<?php echo htmlspecialchars($dossier['datedebut']); ?>">
            </div>
            <div class="form-group">
                <label for="numrc">Num RC:</label>
                <input type="text" id="numrc" name="numrc" value="<?php echo htmlspecialchars($dossier['numrc']); ?>">
            </div>

            <!-- Submit Button -->
            <div class="form-group">
                <button type="submit" name="ok">Update</button>
            </div>
            <a href="hello.php" class="btn btn-secondary mt-3">Retour à la page d'accueil</a>

        </form>
    </div>
</body>
</html>

<?php
if (isset($_POST['ok'])) {
    $num = $_POST['numi'];
    $demo = $_POST['demo'];
    $eng = $_POST['eng'];
    $adresse = $_POST['adresse'];
    $typeentite = $_POST['typeentite'];
    $localite = $_POST['localite'];
    $provinces = $_POST['provinces'];
    $responsablelegaux = $_POST['responsablelegaux'];
    $responsableactive = $_POST['responsableactive'];
    $datedebut = $_POST['datedebut'];
    $numrc = $_POST['numrc'];

    try {
        // Update dossier record
        $query = "UPDATE folders SET demo = :demo, eng = :eng, adresse = :adresse, typeentite = :typeentite, 
                  localite = :localite, provinces = :provinces, responsablelegaux = :responsablelegaux, 
                  responsableactive = :responsableactive, datedebut = :datedebut, numrc = :numrc WHERE numi = :numi";
        $stmt = $cx->prepare($query);
        $stmt->bindParam(':numi', $num);
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
        $stmt->execute();

        $msg = 'Update Successful!';
        echo "<script>alert('$msg');window.location.href='hello.php';</script>";
        
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
