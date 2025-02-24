<?php
$loginApiUrl = "https://x8ki-letl-twmt.n7.xano.io/api:gTVuShjQ/auth/login";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    if (!$email) {
        echo "<p style='color:red;'>Invalid email address.</p>";
    } else {
        $password = $_POST['password'];
        
        $registrationData = [
            "email" => $email,
            "password" => $password,
        ];

        $ch = curl_init($loginApiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($registrationData));
        $response = curl_exec($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        $result = json_decode($response, true);
        // echo $response;
        // echo $result;
        if (in_array($status_code, [200, 201, 202])) {
            echo "<p class='pet' style='color:green;'>Logged in successfuly!</p>";
            session_start();
            $_SESSION["authToken"] = $result['authToken'];

        } else {
            echo "<p class='pet' style='color:red;'>Could not log in."; 
            echo htmlspecialchars($result['message']); 
            echo "</p>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
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
    
    form {
            display: flex;
            flex-direction: column;
            width: 300px;
            margin: 0 auto;
        }
        label {
            text-align: left;
            margin-bottom: 5px;
        }
        input {
            padding: 8px;
            margin-bottom: 15px;
            width: 100%;
            box-sizing: border-box;
        }
        button {
            padding: 10px;
            background-color: #007BFF;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }

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


    <script src="./js/fadeIn.js"></script>
    <title>Schronisko P&R Logowanie</title>
    
</head>
<body>
    <?php echo file_get_contents('components/navbar.php'); ?>
    <div class="container">
        <?php if ( isset($_SESSION) ): ?>

            <div class='filters fade-in-section'>
                <h1>Witamy! <a href="index.php">Przejdź na główną</a></h1>
            </div>

        <?php else: ?>

            <div class='filters fade-in-section' style="text-align: left">
                <form method='POST'>
                    <div>
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div>
                        <label for="password">Hasło:</label>
                        <input type="password" id="password" name="password" required>    
                    </div>
                    <div>
                        <button class='button' type="submit">Log In</button>
                        
                    </div>
                    
                </form>
                <div style='text-align: center;'>
                    <br>
                    <a href='/signUp.php'>Nie masz jeszcze konta?</a>
                </div>
            </div>

        <?php endif; ?>

        
    </div>
    <?php echo file_get_contents('components/footer.php'); ?>
</body>
</html>