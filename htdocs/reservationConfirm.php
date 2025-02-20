<?php
$confirmApiUrl = "https://x8ki-letl-twmt.n7.xano.io/api:iPSUkxr_/reservationConfirmation";

// Get reservation ID from URL
$reservationId = isset($_GET['reservationToken']) ? $_GET['reservationToken'] : '';
if (empty($reservationId)) {
    die("Invalid reservation ID.");
}

// Call confirmation API with GET and query parameter
$ch = curl_init($confirmApiUrl . "?reservationToken=" . urlencode($reservationId));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
$response = curl_exec($ch);
curl_close($ch);

$result = json_decode($response, true);
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Potwierdzenie rezerwacji</title>
<!-- LOAD CSS -->
<link rel="stylesheet" href="./style/navbarDark.css">
    <link rel="stylesheet" href="./style/buttons.css">
    <link rel="stylesheet" href="./style/formFields.css">
    <link rel="stylesheet" href="./style/pet.css">
    <link rel="stylesheet" href="./style/formFields.css">
    <link rel="stylesheet" href="./style/general.css">
    <link rel="stylesheet" href="./style/fadeIn.css">
    <style>
    /* Mobile styles */
    <?php echo file_get_contents('style/footer_desktop.css'); ?>
    @media screen and (max-width: 768px) {
        .container {
            width: 100%;
            margin: 0;
        }
        .filters {
            margin: 20px 0;
            border-radius: 10px;
        }
        .pet {
            margin: 20px 0;
            border-radius: 10px;
        }
        <?php echo file_get_contents('style/footer_mobile.css'); ?>
    }
    
    </style>
    <script src="./js/fadeIn.js"></script>
</head>
<body>
    <div class="container fade-in-section">
        <h1>Potwierdzenie rezerwacji</h1>
        
        <?php if ($result['success']): ?>
            <p class="success">Pomyślnie potwierdzono rezerwację! <?= htmlspecialchars($result['reason']) ?></p>
        <?php else: ?>
            <p class="error">Nie można potwierdzić rezerwacji! Powód: <?= htmlspecialchars($result['reason']) ?></p>
        <?php endif; ?>
        
        <button onclick="window.location.href='/'">Wróć na główną</button>
    </div>
</body>
</html>