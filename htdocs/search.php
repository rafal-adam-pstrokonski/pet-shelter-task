<?php
$apiUrl = "https://x8ki-letl-twmt.n7.xano.io/api:iPSUkxr_/pet";

// Calculate the date of last week (7 days ago)
$lastWeek = date("Y-m-d", strtotime("-7 days"));

// Fetch pets created from last week
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "$apiUrl?createdFrom=$lastWeek");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);
$pets = json_decode($response, true);
?>

<!DOCTYPE html>
<html lang="pl">
<head>
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
<!-- ######################## -->

<!-- LOAD JavaScript -->
    <script src="./js/fadeIn.js"></script>
    <script>
        <?php echo file_get_contents("./js/search.js"); ?>
    </script>
<!-- ######################## -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schronisko PR</title>
    
</head>
<body>
    <?php echo file_get_contents('components/navbar.php'); ?>

    <div class="container">
        
        <div class="filters fade-in-section">
            <p>Filtruj wyniki</p>
            <div>    
                <select id="status">
                    <option value="">Status</option>
                    <option value=1>Dostępny</option>
                    <option value=2>Zarezerwowany</option>
                    <option value=3>Wydany</option>
                </select>
            </div>
            <div>    
                <select id="species">
                    <option value="">Gatunek</option>
                    <option value="Świnka morska">Świnka morska</option>
                    <option value="Pies">Pies</option>
                    <option value="Kot">Kot</option>
                </select>
            </div>
            <div>
                <input type="text" id="name" placeholder="Imię">
            </div>
            <div>
                <button class="button" onclick="searchPets()">Szukaj</button>
            </div>
        </div>
        

        
        <div id="results">
            <?php foreach ($pets as $pet): ?>
                <div class='pet' onclick="window.location.href='reserve.php?id=<?= htmlspecialchars($pet['id']) ?>'">
                    <img src='<?= htmlspecialchars($pet['image']['url']) ?>' alt='<?= htmlspecialchars($pet['name']) ?>'>
                    <div class='pet-details fade-in-section'>
                        <strong><?= htmlspecialchars($pet['name']) ?></strong>
                        <?php 
                            $statusColor = 'black';
                            if ($pet['petadoptionstatus_id'] === 1) {
                                $statusColor = 'green';
                            } elseif ($pet['petadoptionstatus_id'] === 2) {
                                $statusColor = '#cc6600'; /* orange */
                            } elseif ($pet['petadoptionstatus_id'] === 3) {
                                $statusColor = 'red';
                            }
                        ?>
                        <p style="color: <?= $statusColor ?>">Status: <?= htmlspecialchars($pet['_petadoptionstatus']['displayText'] ?? 'Nieznana') ?></p>
                        Gatunek: <?= htmlspecialchars($pet['species']) ?><br>
                        Wiek: <?= htmlspecialchars($pet['age']) ?> lat(a)<br>
                        Opis: <?= htmlspecialchars(strlen($pet['description']) > 100 ? substr($pet['description'], 0, 100) . '...' : $pet['description']) ?>
                    </div>

                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <?php echo file_get_contents('components/footer.php'); ?>
    
</body>
</html>
