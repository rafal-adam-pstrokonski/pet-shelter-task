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
    <style>
        /* Buttons */
        .button {
            background: linear-gradient(135deg, #4caf50, #2e7d32);
            color: white;
            font-size: 16px;
            font-weight: bold;
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        }

        .button:hover {
            background: linear-gradient(135deg, #43a047, #1b5e20);
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.3);
        }

        .button:active {
            transform: scale(0.98);
        }

        .button:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.5);
        }

        /* Inputs and Dropdowns */
        input, select {
            width: 90%;
            max-width: 400px;
            padding: 10px;
            margin: 10px 0;
            font-size: 16px;
            color: #ffffff;
            background: rgba(0, 0, 0, 0.5);
            border: 2px solid #4caf50;
            border-radius: 5px;
            outline: none;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        input::placeholder {
            color: #cfcfcf;
        }

        input:focus, select:focus {
            border-color: #81c784;
            box-shadow: 0 0 10px rgba(76, 175, 80, 0.5);
        }

        /* Dropdown */
        select {
            appearance: none;
            cursor: pointer;
        }

        /* Style dropdown arrow */
        select::-ms-expand {
            display: none;
        }

        body { 
            font-family: Arial, sans-serif; 
            text-align: center; 
            background-image: url('https://tapetuj.pl/userdata/public/gfx/17906/Fototapeta-LAS-O-WSCHODZIE-SLONCA-576.jpg');
            background-size: cover;
            background-position: center;
        }
        .container { 
            width: 60%; 
            margin: auto; 
        }
        .filters { 
            margin-bottom: 20px; 
            align-items: center; 
            border: 1px solid #ddd; 
            padding: 15px; 
            margin: 10px; 
            border-radius: 10px; 
            background: rgba(170,170,170,0.85); 
        }
        .pet { 
            /**display: flex; */
            align-items: center; 
            border: 1px solid #ddd; 
            padding: 15px; 
            margin: 10px; 
            border-radius: 10px; 
            background: rgba(210,210,210,0.85); 
            cursor: pointer; 
        }
        .pet img { 
            width: 80px; 
            height: 80px; 
            border-radius: 50%; 
            margin-right: 15px; 
        }
        .pet-details { 
            text-align: left; 
        }
        .pet strong { 
            font-size: 1.2em; 
        }

        /* Mobile styles */
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
        }
    </style>
</head>
<body>
    <div class="container">
        <div class='filters'>
            <h1><?= htmlspecialchars($pet['name']) ?> - Rezerwacja</h1>
        </div>
        <div class='pet'>
            <button class="button" onclick="window.location.href='/'">Wróć na główną</button>
        </div>
        
        <img src="<?= htmlspecialchars($pet['image']['url']) ?>" alt="<?= htmlspecialchars($pet['name']) ?>">

        <div class='pet'>
            <div><p>Gatunek: <?= htmlspecialchars($pet['species']) ?></p></div>
            <div><p>Status: <?= htmlspecialchars($pet['_petadoptionstatus']['displayText']) ?> [identyfikator: <a href="mailto:pet.shelter.task@outlook.com?subject=#Dostępność%20#pet-id(<?= htmlspecialchars($pet['id']) ?>)&body=Dzień dobry,%20%0A%20Jestem%20zainteresowany%20adopcją%20zwierzątka.">pet-id(<?= htmlspecialchars($pet['id']) ?>)</a>]<br></p></div>
            <div><p>Wiek: <?= htmlspecialchars($pet['age']) ?> lat(a)</p></div>
            <div><p><?= htmlspecialchars($pet['description']) ?></div>
        </div>

        <div class='pet'>
            <?php if ($pet['petadoptionstatus_id'] != 1): ?>
                <h3>Zwierzę nie jest dostępne do rezerwacji.</h3>
            <?php else: ?>
                <h3>Podaj swój email</h3>
                <h4>(rezerwację należy potwierdzić linkiem z wiadomości)</h4>
                <form method="POST">
                    <input type="email" name="email" required placeholder="example@example.com">
                    <button class="button" type="submit">Zarezerwuj!</button>
                </form>
            <?php endif; ?>
        </div>

        
    </div>
</body>
</html>
