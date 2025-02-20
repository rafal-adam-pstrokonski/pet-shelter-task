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
<!-- LOAD CSS -->
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
    <script src="./js/search.js"></script>
    <script src="./js/fadeIn.js"></script>
<!-- ######################## -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schronisko PR</title>
    
</head>
<body>
    <?php echo file_get_contents('components/navbar.php'); ?>

    <div class="container">
        
        <div class='filters fade-in-section'>
            <h1>Schronisko P & R wita!</h1>
            <p>Kontakt email: pet.shelter.task@outlook.com | <a href="mailto:pet.shelter.task@outlook.com?&subject=#Dostępność&body=Proszę o przesłanie dostępności zwierząt:%0AGatunek: %0AImię: %0A%0APozdrawiam">Zapytaj o dostępność</a></p>
        </div>
        

    
        
    </div>

    <?php echo file_get_contents('components/footer.php'); ?>
    
</body>
</html>
