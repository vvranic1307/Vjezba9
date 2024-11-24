<?php
// Funkcija za provjeru stanja dućana
function ducan($stanje = "otvoren") {
    echo "Dućan je $stanje";
}

// Popis državnih praznika (u formatu YYYY-MM-DD)
$drzavniPraznici = [
    "2024-01-01", // Nova godina
    "2024-06-25", // Dan državnosti
    "2024-12-25", // Božić
    "2024-12-26", // Sveti Stjepan
    // Dodajte ostale praznike ovdje
];

// Provjera korisničkog unosa
$rezultat = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $datum = isset($_POST['datum']) ? $_POST['datum'] : "";
    $sati = isset($_POST['sati']) ? (int)$_POST['sati'] : 0;

    // Provjera valjanosti unosa
    if (empty($datum) || $sati < 0 || $sati > 23) {
        $rezultat = "Molimo unesite ispravan datum i vrijeme!";
    } else {
        // Određivanje dana u tjednu na temelju datuma
        $dan = date('l', strtotime($datum)); // Pretvaramo datum u dan (Monday, Tuesday, ...)

        // Provjera stanja dućana
        if (in_array($datum, $drzavniPraznici)) {
            $rezultat = "Dućan je zatvoren zbog praznika.";
        } elseif ($dan === "Sunday") {
            $rezultat = "Dućan je zatvoren.";
        } elseif ($dan === "Saturday") {
            if ($sati >= 9 && $sati < 14) {
                $rezultat = "Dućan je otvoren.";
            } else {
                $rezultat = "Dućan je zatvoren.";
            }
        } else {
            if ($sati >= 8 && $sati < 20) {
                $rezultat = "Dućan je otvoren.";
            } else {
                $rezultat = "Dućan je zatvoren.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Provjera stanja dućana</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 20px;
        }
        .container {
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        input, button {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }
        button {
            background-color: #5cb85c;
            color: white;
            cursor: pointer;
        }
        button:hover {
            background-color: #4cae4c;
        }
        .result {
            margin-top: 20px;
            padding: 15px;
            background-color: #dff0d8;
            color: #3c763d;
            border-radius: 5px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Provjera stanja dućana</h1>
        <form method="post" action="">
            <label for="datum">Unesite datum (YYYY-MM-DD):</label>
            <input type="date" id="datum" name="datum" required>

            <label for="sati">Unesite sat (0-23):</label>
            <input type="number" id="sati" name="sati" min="0" max="23" required>

            <button type="submit">Provjeri stanje</button>
        </form>

        <?php if (!empty($rezultat)): ?>
            <div class="result">
                <strong><?php echo $rezultat; ?></strong>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
