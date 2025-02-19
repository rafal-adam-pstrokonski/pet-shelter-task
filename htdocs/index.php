<?php
$apiUrl = "https://x8ki-letl-twmt.n7.xano.io/api:iPSUkxr_/pet"; // Replace with your API endpoint

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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schronisko PR</title>
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
            display: flex; 
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
    <script>
    function searchPets() {
        let species = document.getElementById("species").value;
        let name = document.getElementById("name").value;
        let status = document.getElementById("status").value;
        fetch(`<?php echo $apiUrl; ?>?species=${species}&name=${name}&status=${status}`)
        .then(response => response.json())
        .then(data => {
            let resultsDiv = document.getElementById("results");
            let statusColor = {
                1: 'green',
                2: '#cc6600',
                3: 'red'
            };
            resultsDiv.innerHTML = "";
            data.forEach(pet => {
                resultsDiv.innerHTML += `
                    <div class='pet' onclick="window.location.href='reserve.php?id=${pet.id}'">
                        <img src='${pet.image.url}' alt='${pet.name}'>
                        <div class='pet-details'>
                            <strong>${pet.name}</strong>
                            <p style="color: ${statusColor[pet.petadoptionstatus_id] || 'black'};">
                                Status: ${pet._petadoptionstatus.displayText || 'Nieznana'}
                            </p>
                            Gatunek: ${pet.species}<br>
                            Wiek: ${pet.age} lat(a)<br>
                            Opis: ${pet.description.slice(0,100) + (pet.description.length > 100 ? '...' : '')}
                        </div>
                    </div>`;
            });
        })
        .catch(error => console.error("Błąd pobierania danych:", error));
    }
</script>

</head>
<body>
    <div class="container">
        <!--
        <div class='filters'>
            <p>Logowanie dla opiekunów</p><button onclick="window.location.href='login.php'">Login</button>
        </div>
        -->
        <div class='filters'>
            <h1>Schronisko P & R wita!</h1>
            <p>Kontakt email: pet.shelter.task@outlook.com | <a href="mailto:pet.shelter.task@outlook.com?&subject=#Dostępność&body=Proszę o przesłanie dostępności zwierząt:%0AGatunek: %0AImię: %0A%0APozdrawiam">Zapytaj o dostępność</a></p>
        </div>
        

    
        <div class="filters">
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
                    <div class='pet-details'>
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
</body>
</html>
