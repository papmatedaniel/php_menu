<?php
session_start();

// Captcha generálása
if (!isset($_SESSION['captcha'])) {
    $_SESSION['captcha'] = [
        'szam1' => rand(1, 10),
        'szam2' => rand(1, 10),
    ];
}

// Kommentek betöltése a fájlból
$kommentek = [];
$filenev = 'kommentek.txt';
if (file_exists($filenev)) {
    $sorok = file($filenev, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $kommentek = array_reverse($sorok); // Fordított sorrend
}

// Ha az űrlapot elküldték
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nev = trim($_POST['nev'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $komment = trim($_POST['comment'] ?? '');
    $captchaResult = intval($_POST['captcha'] ?? 0);

    $expectedCaptcha = $_SESSION['captcha']['szam1'] + $_SESSION['captcha']['szam2'];
    
    // Ellenőrzés
    if (empty($nev) || empty($email) || empty($komment)) {
        $error = "Kérjük, töltse ki az összes mezőt!";
    } elseif ($captchaResult !== $expectedCaptcha) {
        $error = "Helytelen captcha megoldás!";
    } else {
        // Kommentek mentése
        $timestamp = date('Y-m-d H:i:s');
        $commentNumber = count($kommentek) + 1; // Sorszám meghatározása
        $fileadat = "$commentNumber;$timestamp;$nev;$komment" . PHP_EOL;
        file_put_contents($filenev, $fileadat, FILE_APPEND);
        
        $sikeres = "Az üzenetet sikeresen elküldtük!";
        
        // Input mezők törlése
        $nev = $email = $komment = '';
        
        // Kommentek újratöltése
        $sorok = file($filenev, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $kommentek = array_reverse($sorok);
        
        // Új captcha generálása
        $_SESSION['captcha'] = [
            'szam1' => rand(1, 10),
            'szam2' => rand(1, 10),
        ];
    }
}
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Űrlap Captchával és Kommentekkel</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        form, .kommentek {
            max-width: 400px;
            margin: auto;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input, textarea, button {
            width: 100%;
            margin-bottom: 15px;
            padding: 10px;
            box-sizing: border-box;
        }
        button {
            background-color: #007BFF;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        .error {
            color: red;
            margin-bottom: 15px;
        }
        .sikeres {
            color: green;
            margin-bottom: 15px;
        }
        .kommentek {
            margin-top: 30px;
            border-top: 2px solid #ccc;
            padding-top: 15px;
        }
        .comment {
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background: #f9f9f9;
        }
        .comment h4 {
            margin: 0 0 5px;
        }
        .comment time {
            font-size: 0.9em;
            color: #555;
        }
    </style>
</head>
<body>
    <h1>Kérjük, töltse ki az űrlapot</h1>
    
    <?php if (!empty($error)): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <?php if (!empty($sikeres)): ?>
        <p class="sikeres"><?= htmlspecialchars($sikeres) ?></p>
    <?php endif; ?>
    
    <form method="POST">
        <label for="nev">Név:</label>
        <input type="text" id="nev" name="nev" value="<?= htmlspecialchars($nev ?? '') ?>" required>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($email ?? '') ?>" required>
        
        <label for="comment">Komment:</label>
        <textarea id="comment" name="comment" rows="4" required><?= htmlspecialchars($komment ?? '') ?></textarea>
        
        <label for="file">Fájl feltöltése:</label>
        <input type="file" id="file" name="file">
        
        <label for="captcha">Captcha: Mennyi <?= $_SESSION['captcha']['szam1'] ?> + <?= $_SESSION['captcha']['szam2'] ?>?</label>
        <input type="number" id="captcha" name="captcha" required>
        
        <button type="submit">Küldés</button>
    </form>
    
    <div class="kommentek">
        <h2>Kommentek</h2>
        <?php if (empty($kommentek)): ?>
            <p>Még nincsenek kommentek.</p>
        <?php else: ?>
            <?php foreach ($kommentek as $line): ?>
                <?php
                list($commentNumber, $timestamp, $commentName, $commentText) = explode(';', $line);
                ?>
                <div class="comment">
                    <h4>#<?= htmlspecialchars($commentNumber) ?> : <?= htmlspecialchars($commentName) ?></h4>
                    <time><?= htmlspecialchars($timestamp) ?></time>
                    <p><?= nl2br(htmlspecialchars($commentText)) ?></p>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</body>
</html>