<?php
session_start();
require_once('connection.php'); // Assuming this file contains PDO connection code
$d = date('H');
$msg = '';
if ($d < 17) {
    $msg = "Bonjour";
} else {
    $msg = "Bonsoir";
}

// Check if the session variable 'user' is set and is an array
if (isset($_SESSION['user']) && is_array($_SESSION['user'])) {
    $prenom = $_SESSION['user']['prenom'];
    $nom = $_SESSION['user']['nom'];
} else {
    $prenom = "Invité";
    $nom = "";
}

echo "<h1>" . $msg . " " . $prenom . " " . $nom . "</h1>";

try {
    $query = "SELECT * FROM folders";
    $stmt = $cx->prepare($query);
    $stmt->execute();
    $dossiers = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Dossiers</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #ffffff; /* White background */
        }
        .header {
            background-color: #007bff; /* Bootstrap primary blue */
            padding: 10px;
            color: #ffffff; /* White text */
            text-align: center;
        }
        .container {
            margin-top: 20px;
        }
        table {
            width: 100%;
            margin-top: 20px;
        }
        table th, table td {
            padding: 8px;
            text-align: center;
        }
        table th {
            background-color: #007bff; /* Bootstrap primary blue */
            color: #ffffff; /* White text */
        }
        .table-container {
            overflow-x: auto; /* Allow horizontal scrolling */
        }
        .btn-group {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="btn-group">
            <a href="ajouter.php" class="btn btn-primary">Ajouter</a>
            <a href="rechercher.php" class="btn btn-primary">Rechercher</a>
            <a href="logout.php" class="btn btn-danger float-right">Déconnecter</a>
        </div>

        <h2>Liste des Dossiers</h2>
        <div class="table-scroll">
          <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>Numéro</th>
                    <th>Demo</th>
                    <th>Eng</th>
                    <th>Adresse</th>
                    <th>Type Entité</th>
                    <th>Localité</th>
                    <th>Provinces</th>
                    <th>Responsables Légaux</th>
                    <th>Responsable Actif</th>
                    <th>Date de Début</th>
                    <th>Num RC</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($dossiers as $dossier): ?>
                    <tr>
                        <td><?php echo $dossier["numi"]; ?></td>
                        <td><?php echo $dossier["demo"]; ?></td>
                        <td><?php echo $dossier["eng"]; ?></td>
                        <td><?php echo $dossier["adresse"]; ?></td>
                        <td><?php echo $dossier["typeentite"]; ?></td>
                        <td><?php echo $dossier["localite"]; ?></td>
                        <td><?php echo $dossier["provinces"]; ?></td>
                        <td><?php echo $dossier["responsablelegaux"]; ?></td>
                        <td><?php echo $dossier["responsableactive"]; ?></td>
                        <td><?php echo $dossier["datedebut"]; ?></td>
                        <td><?php echo $dossier["numrc"]; ?></td>
                        <td>
                            <a href="edit.php?numi=<?php echo urlencode($dossier["numi"]); ?>" class="btn btn-info btn-sm">Modifier</a>
                            <a href="delete.php?numi=<?php echo urlencode($dossier["numi"]); ?>" class="btn btn-danger btn-sm">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies (jQuery, Popper.js) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function() {
            // Add a fade-in animation to table rows on page load
            $('.table-row').hide().fadeIn(1000);

            // Optional: Add hover effect for table rows
            $('.table-row').hover(
                function() {
                    $(this).css('background-color', '#f8f9fa'); // Light gray background
                },
                function() {
                    $(this).css('background-color', ''); // Reset background
                }
            );
        });
    </script>
</body>
</html>
