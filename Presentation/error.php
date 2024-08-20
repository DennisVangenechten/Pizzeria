<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Foutmelding</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="content-wrap">
        <h1>Er is een fout opgetreden</h1>
        <p><?php echo htmlspecialchars($errorMessage); ?></p>
        <button onclick="window.location.href='MainController.php?action=index'" class="btn3"><span class="spn3">Terug naar Homepage</span></button>
    </div>
</body>
</html>
