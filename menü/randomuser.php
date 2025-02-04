<?php
if (isset($_GET['action']) && $_GET['action'] === 'get_test_data') {
    header('Content-Type: application/json');

    $adatok = file_get_contents("https://randomuser.me/api/");
    $adat = json_decode($adatok, true);

    if (!$adat) {
        echo json_encode(['error' => 'Nem sikerült betölteni az adatokat']);
        exit;
    }

    $user = $adat['results'][0];

    $response = [
        'fullname' => $user['name']['title'] . ' ' . $user['name']['first'] . ' ' . $user['name']['last'],
        'gender' => $user['gender'],
        'dob' => date('Y-m-d', strtotime($user['dob']['date'])),
        'country' => $user['location']['country'],
        'city' => $user['location']['city'],
        'email' => $user['email'],
        'phone' => $user['phone'],
        'username' => $user['login']['username'],
        'password' => $user['login']['password']
    ];

    echo json_encode($response);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regisztráció</title>
    <style>
        .registration {
            max-width: 500px;
            height: 800px;
            border-radius: 7px;
            margin: 20px;
            padding: 10px 20px;
            background: linear-gradient(45deg, #DDD, #559923);
        }
        #gender {
            float: right;
            margin-right: 10px;
        }
        input[type="submit"] {
            width: 200px;
            margin-top: 100px;
            margin-left: 200px;
        }
    </style>
    <script>
        function fillTestData() {
            fetch('randomuser.php?action=get_test_data')  // Használj teljes fájlnevet!
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Hálózati hiba történt');
                    }
                    return response.json();
                })
                .then(data => {
                    document.getElementById('fullname').value = data.fullname;
                    document.getElementById('gender').value = data.gender;
                    document.getElementById('dob').value = data.dob;
                    document.getElementById('country').value = data.country;
                    document.getElementById('city').value = data.city;
                    document.getElementById('email').value = data.email;
                    document.getElementById('phone').value = data.phone;
                    document.getElementById('username').value = data.username;
                    document.getElementById('password').value = data.password;
                })
                .catch(error => console.error('Hiba:', error));
        }

    </script>
</head>
<body>

<form class="registration" action="/submit_registration" method="post" enctype="multipart/form-data">
    <h1>Regisztráció</h1>
    <label for="fullname">Teljes név:</label>
    <input type="text" id="fullname" name="fullname" required><br><br>
    
    <label for="gender">Nem:</label>
    <select id="gender" name="gender" required>
        <option value="male">Férfi</option>
        <option value="female">Nő</option>
    </select><br><br>
    
    <label for="dob">Születési dátum:</label>
    <input type="date" id="dob" name="dob" required><br><br>
    
    <label for="country">Ország:</label>
    <input type="text" id="country" name="country" required><br><br>
    
    <label for="city">Város:</label>
    <input type="text" id="city" name="city" required><br><br>
    
    <label for="email">E-mail cím:</label>
    <input type="email" id="email" name="email" required><br><br>
    
    <label for="phone">Telefonszám:</label>
    <input type="tel" id="phone" name="phone" required><br><br>
    
    <label for="username">Felhasználónév:</label>
    <input type="text" id="username" name="username" required><br><br>
    
    <label for="password">Jelszó:</label>
    <input type="password" id="password" name="password" required><br><br>
    
    <label for="profilepic">Profilkép:</label>
    <input type="file" id="profilepic" name="profilepic"><br><br>
    
    <input type="submit" value="Regisztráció">
    <button type="button" onclick="fillTestData()">Tesztadatok betöltése</button>
</form>

</body>
</html>
