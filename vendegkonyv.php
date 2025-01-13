<?php
session_start();

// Captcha generálása
if (!isset($_SESSION['captcha'])) {
    $_SESSION['captcha'] = [
        'num1' => rand(1, 10),
        'num2' => rand(1, 10),
    ];
}

// Kommentek betöltése a fájlból
$comments = [];
$filePath = 'comments.txt';
if (file_exists($filePath)) {
    $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $comments = array_reverse($lines); // Fordított sorrend
}

// Ha az űrlapot elküldték
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $comment = trim($_POST['comment'] ?? '');
    $captchaResult = intval($_POST['captcha'] ?? 0);

    $expectedCaptcha = $_SESSION['captcha']['num1'] + $_SESSION['captcha']['num2'];
    
    // Ellenőrzés
    if (empty($name) || empty($email) || empty($comment)) {
        $error = "Kérjük, töltse ki az összes mezőt!";
    } elseif ($captchaResult !== $expectedCaptcha) {
        $error = "Helytelen captcha megoldás!";
    } else {
        // Kommentek mentése
        $timestamp = date('Y-m-d H:i:s');
        $commentNumber = count($comments) + 1; // Sorszám meghatározása
        $fileData = "$commentNumber;$timestamp;$name;$comment" . PHP_EOL;
        file_put_contents($filePath, $fileData, FILE_APPEND);
        
        $success = "Az üzenetet sikeresen elküldtük!";
        
        // Input mezők törlése
        $name = $email = $comment = '';
        
        // Kommentek újratöltése
        $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $comments = array_reverse($lines);
        
        // Új captcha generálása
        $_SESSION['captcha'] = [
            'num1' => rand(1, 10),
            'num2' => rand(1, 10),
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
        form, .comments {
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
        .success {
            color: green;
            margin-bottom: 15px;
        }
        .comments {
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
    <?php if (!empty($success)): ?>
        <p class="success"><?= htmlspecialchars($success) ?></p>
    <?php endif; ?>
    
    <form method="POST">
        <label for="name">Név:</label>
        <input type="text" id="name" name="name" value="<?= htmlspecialchars($name ?? '') ?>" required>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($email ?? '') ?>" required>
        
        <label for="comment">Komment:</label>
        <textarea id="comment" name="comment" rows="4" required><?= htmlspecialchars($comment ?? '') ?></textarea>
        
        <label for="file">Fájl feltöltése:</label>
        <input type="file" id="file" name="file">
        
        <label for="captcha">Captcha: Mennyi <?= $_SESSION['captcha']['num1'] ?> + <?= $_SESSION['captcha']['num2'] ?>?</label>
        <input type="number" id="captcha" name="captcha" required>
        
        <button type="submit">Küldés</button>
    </form>
    
    <div class="comments">
        <h2>Kommentek</h2>
        <?php if (empty($comments)): ?>
            <p>Még nincsenek kommentek.</p>
        <?php else: ?>
            <?php foreach ($comments as $line): ?>
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
