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
    <style>
        body { 
            font-family: Arial, sans-serif; 
            text-align: center; 
        }
        .container { 
            width: 50%; 
            margin: auto; 
            padding: 20px; 
            border: 1px solid #ddd; 
            border-radius: 10px; 
            background: #f9f9f9; 
        }
        .success { 
            color: green; 
            font-size: 1.2em; 
        }
        .error { 
            color: red; 
            font-size: 1.2em; 
        }
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
            background: rgba(170,170,170,0.8); 
        }
        .pet { 
            display: flex; 
            align-items: center; 
            border: 1px solid #ddd; 
            padding: 15px; 
            margin: 10px; 
            border-radius: 10px; 
            background: rgba(210,210,210,0.8); 
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