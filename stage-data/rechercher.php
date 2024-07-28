<?php
session_start();
require_once('connection.php'); // Assuming this file contains PDO connection code

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['folder_number'])) {
    $folder_number = $_POST["folder_number"];

    try {
        // Adjust the query to match the table structure
        $query = "SELECT * FROM folders WHERE numi = :num";
        $stmt = $cx->prepare($query);
        $stmt->bindParam(':num', $folder_number, PDO::PARAM_STR);
        $stmt->execute();
        $dossiers = $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recherche</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #ffffff; /* White background */
        }
        .container {
            margin-top: 20px;
        }
        .header {
            background-color: #007bff; /* Bootstrap primary blue */
            padding: 10px;
            color: #ffffff; /* White text */
            text-align: center;
        }
        .form-container {
            margin-bottom: 20px;
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
        .action-links a {
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Recherche</h1>
        </div>

        <div class="form-container">
            <form method="post">
                <div class="form-row">
                    <div class="col-md-4">
                        <label for="folder_number">Numéro de Dossier:</label>
                        <input type="text" class="form-control" id="folder_number" name="folder_number">
                    </div>
                    <div class="col-md-4">
                        <label>&nbsp;</label><br>
                        <button type="submit" class="btn btn-primary">Rechercher</button>
                    </div>
                </div>
            </form>
        </div>

        <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($dossiers) && !empty($dossiers)): ?>
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>Numéro de Dossier</th>
                        <th>Demo</th>
                        <th>English Name</th>
                        <th>Address</th>
                        <th>Entity Type</th>
                        <th>Locality</th>
                        <th>Province</th>
                        <th>Legal Representatives</th>
                        <th>Active Representatives</th>
                        <th>Start Date</th>
                        <th>Registration Number (NumRC)</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($dossiers as $dossier): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($dossier["numi"]); ?></td>
                            <td><?php echo htmlspecialchars($dossier["demo"]); ?></td>
                            <td><?php echo htmlspecialchars($dossier["eng"]); ?></td>
                            <td><?php echo htmlspecialchars($dossier["adresse"]); ?></td>
                            <td><?php echo htmlspecialchars($dossier["typeentite"]); ?></td>
                            <td><?php echo htmlspecialchars($dossier["localite"]); ?></td>
                            <td><?php echo htmlspecialchars($dossier["provinces"]); ?></td>
                            <td><?php echo htmlspecialchars($dossier["responsablelegaux"]); ?></td>
                            <td><?php echo htmlspecialchars($dossier["responsableactive"]); ?></td>
                            <td><?php echo htmlspecialchars($dossier["datedebut"]); ?></td>
                            <td><?php echo htmlspecialchars($dossier["numrc"]); ?></td>
                            <td class="action-links">
                                <a href="edit.php?numi=<?php echo htmlspecialchars($dossier["numi"]); ?>" class="btn btn-info btn-sm">Modifier</a>
                                <a href="delete.php?numi=<?php echo htmlspecialchars($dossier["numi"]); ?>" class="btn btn-danger btn-sm">Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php elseif ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
            <p>No results found for the given dossier number.</p>
        <?php endif; ?>

        <a href="hello.php" class="btn btn-secondary mt-3">Retour à la page d'accueil</a>
    </div>

    <!-- Bootstrap JS and dependencies (jQuery, Popper.js) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
