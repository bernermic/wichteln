<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weihnachtswichteln</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: black;
            color: #ddd;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        #content {
            display: none;
            max-width: 90%;
            box-sizing: border-box;
        }
        #loading {
            margin-top: 20px;
            max-width: 90%;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        #loading p {
            margin-top: 20px;
            font-size: 1.5em;
            background: linear-gradient(90deg, #ff0000, #ff7300, #ffeb00, #47ff00, #00ffee, #2b65ff, #8000ff);
            background-size: 400% 400%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: gradientAnimation 6s ease infinite;
            padding: 10px;
            border-radius: 5px;
        }
        @keyframes gradientAnimation {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        #giftImage {
            margin-top: 20px;
            max-width: 100%;
            height: auto;
        }
        #result {
            font-size: 2em;
            margin-top: 30px;
            max-width: 90%;
            word-wrap: break-word;
        }
    </style>
    <script>
        // JavaScript function to manage loading animation and content display
        window.onload = function () {
            // Show the loading animation for 5 seconds
            setTimeout(function () {
                document.getElementById('loading').style.display = 'none';
                document.getElementById('content').style.display = 'block';
            }, 5000); // 5,000 milliseconds = 5 seconds
        };
    </script>
</head>
<body>
    <!-- Loading Animation -->
    <div id="loading">
        <img src="https://cdn.pixabay.com/animation/2022/10/08/10/56/10-56-39-150_512.gif" alt="Loading..." style="max-height: 50vh; width: auto;" />
        <p>Ziehe ein Los für dich...</p>
    </div>

    <!-- Actual Content -->
    <div id="content">
        <?php
        // Paths to the data files
        $dataFile = 'data.txt';
        $drawFile = 'draw.txt';

        // Get the 'key' parameter from the query string
        $queryKey = isset($_GET['key']) ? strtolower(trim(htmlspecialchars($_GET['key']))) : null;

        if ($queryKey) {
            // Check if the draw file exists and if the key is already there
            $usedKeys = [];
            if (file_exists($drawFile)) {
                $drawLines = file($drawFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
                $drawData = [];
                foreach ($drawLines as $line) {
                    list($key, $value) = explode('=', $line, 2);
                    $drawData[strtolower(trim($key))] = trim($value);
                    $usedKeys[] = trim($value); // Track used random keys
                }

                // If the key is already in draw.txt, fetch the corresponding value from data.txt
                if (array_key_exists($queryKey, $drawData)) {
                    $randomKey = $drawData[$queryKey];
                    if (file_exists($dataFile)) {
                        $lines = file($dataFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
                        $data = [];
                        foreach ($lines as $line) {
                            list($key, $value) = explode('=', $line, 2);
                            $data[strtolower(trim($key))] = trim($value);
                        }
                        if (array_key_exists($randomKey, $data)) {
                            echo "<p id='result'>Du darfst beschenken: <strong>{$data[$randomKey]}</strong></p>";
                            echo '<img id="giftImage" src="https://cdn.pixabay.com/animation/2023/11/28/15/39/15-39-31-812_512.gif" alt="Gift Image" style="max-height: 50vh; width: auto;" />';
                            exit; // Stop further processing
                        }
                    }
                }
            }

            // Continue if the key is not in draw.txt
            if (file_exists($dataFile)) {
                // Read lines from the data file
                $lines = file($dataFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

                // Parse the data file into a key-value array
                $data = [];
                foreach ($lines as $line) {
                    list($key, $value) = explode('=', $line, 2);
                    $data[strtolower(trim($key))] = trim($value);
                }

                if (array_key_exists($queryKey, $data)) {
                    // Create a new array excluding the query key and already used keys
                    $remainingData = array_diff_key($data, array_flip($usedKeys));
                    unset($remainingData[$queryKey]);
                } else {
                    echo "<p>Fehler: Der Schlüssel '<strong>{$queryKey}</strong>' wurde nicht in der Datenbank gefunden.</p>";
                    exit; // Stop further processing
                }

                // Fetch a random key from the remaining data
                if (!empty($remainingData)) {
                    $randomKey = array_rand($remainingData);
                    $randomValue = $remainingData[$randomKey];

                    // Print the value with the prefix and add the image
                    echo "<p id='result'>Du darfst beschenken: <strong>{$randomValue}</strong></p>";
                    echo '<img id="giftImage" src="https://cdn.pixabay.com/animation/2023/11/28/15/39/15-39-31-812_512.gif" alt="Gift Image" />';

                    // Write the query key and random key to the draw file (data.txt remains untouched)
                    $drawEntry = "{$queryKey}={$randomKey}" . PHP_EOL;
                    file_put_contents($drawFile, $drawEntry, FILE_APPEND);
                } else {
                    echo "<p>Fehler: Keine Schlüssel mehr verfügbar nach der Ausschließung.</p>";
                }
            } else {
                echo "<p>Fehler: Die Datei 'data.txt' existiert nicht.</p>";
            }
        } else {
            echo "<p>Fehler: Kein Schlüssel angegeben.</p>";
        }
        ?>
    </div>
</body>
</html>
