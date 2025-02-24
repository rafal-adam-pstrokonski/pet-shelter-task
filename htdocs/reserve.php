<?php
$apiUrl = "https://x8ki-letl-twmt.n7.xano.io/api:iPSUkxr_/pet";
$reserveApiUrl = "https://x8ki-letl-twmt.n7.xano.io/api:iPSUkxr_/reservation";

// Get pet ID from URL
$petId = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($petId === 0) {
    die("Invalid pet ID.");
}

// Fetch pet details
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "$apiUrl/$petId");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);
$pet = json_decode($response, true);

if (!$pet) {
    die("Pet not found.");
}

// Handle reservation
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    if (!$email) {
        echo "<p style='color:red;'>Invalid email address.</p>";
    } else {
        $reservationData = [
            "reservation_link" => bin2hex(random_bytes(16)),
            "status" => "NEW",
            "expiry_time" => date('c', time() + 900), // ISO 8601 format (e.g. 2024-02-16T15:30:00+00:00)
            "pet_id" => $petId,
            "emailTo" => $email
        ];

        $ch = curl_init($reserveApiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($reservationData));
        $reserveResponse = curl_exec($ch);
        curl_close($ch);

        echo "<p class='pet' style='color:green;'>Reservation successful! Please check your email for confirmation.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zarezerwuj zwierzę</title>
<!-- LOAD CSS -->
    <link rel="stylesheet" href="./style/navbarDark.css">
    <link rel="stylesheet" href="./style/buttons.css">
    <link rel="stylesheet" href="./style/formFields.css">
    <link rel="stylesheet" href="./style/general.css">
    <link rel="stylesheet" href="./style/fadeIn.css">
    <link rel="stylesheet" href="./style/pet.css">
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
    <?php echo file_get_contents('components/navbar.php'); ?>
    <div class="container">
        <div class='filters fade-in-section'>
            <h1><?= htmlspecialchars($pet['name']) ?> - Rezerwacja</h1>
        </div>
        <div>
            <img class='fade-in-section' style="width:97%; border-radius:3%" src="<?= htmlspecialchars($pet['image']['url']) ?>" alt="<?= htmlspecialchars($pet['name']) ?>">
        </div>
        

        <div class='filters fade-in-section'>
            <div class='details'>
                <div><p>GATUNEK: <?= htmlspecialchars($pet['species']) ?></p></div>
                <div><p>STATUS: <?= htmlspecialchars($pet['_petadoptionstatus']['displayText']) ?> [identyfikator: <a href="mailto:pet.shelter.task@outlook.com?subject=#Dostępność%20#pet-id(<?= htmlspecialchars($pet['id']) ?>)&body=Dzień dobry,%20%0A%20Jestem%20zainteresowany%20adopcją%20zwierzątka.">pet-id(<?= htmlspecialchars($pet['id']) ?>)</a>]<br></p></div>
                <div><p>WIEK: <?= htmlspecialchars($pet['age']) ?> lat(a)</p></div>
                <div style="text-align: left;"><p><?= htmlspecialchars($pet['description']) ?></div>
            </div>
        </div>

        <div class='filters fade-in-section'>
            <?php if ($pet['petadoptionstatus_id'] != 1): ?>
                <h3>Zwierzę nie jest dostępne do rezerwacji.</h3>
            <?php else: ?>
                <div class='details'>

                    <div class='details'>
                        <h3>Podaj swój email</h3>
                        <h4>(rezerwację należy potwierdzić linkiem z wiadomości)</h4>
                    </div>
                    <div class='details'>
                        <form method="POST">
                            <input type="email" name="email" required placeholder="example@example.com">
                            <button class="button" type="submit">Zarezerwuj!</button>
                        </form>
                    </div>

                </div>
                
                
            <?php endif; ?>
        </div>

        
    </div>
    <?php echo file_get_contents('components/footer.php'); ?>
</body>
</html>
