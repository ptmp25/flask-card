<?php
session_start();
try {
    // Connect to the database using PDO
    $db = new PDO('mysql:host=localhost;dbname=flask_card', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

// Fetch one random word with its meaning
$sql = "SELECT * FROM words ORDER BY RAND() LIMIT 1";
$stmt = $db->prepare($sql);
$stmt->execute();
$word = $stmt->fetch();

// Fetch three other random words
$sql = "SELECT * FROM words WHERE id != :word_id ORDER BY RAND() LIMIT 3";
$stmt = $db->prepare($sql);
$stmt->bindParam(':word_id', $word['id']);
$stmt->execute();
$other_words = $stmt->fetchAll();

// Now you can use $word and $other_words in your HTML
?>

<body>
    <p>Term:
        <?php echo $word['term']; ?>
    </p>
    <?php
    $definitions = array_merge([$word['definition']], array_column($other_words, 'definition'));
    shuffle($definitions);
    ?>

    <?php foreach ($definitions as $definition): ?>
        <button class="definition-btn">
            <?php echo $definition; ?>
        </button><br>
    <?php endforeach; ?>

    <script>
        const buttons = document.querySelectorAll('.definition-btn');
        buttons.forEach(button => {
            button.addEventListener('click', () => {
                const selectedDefinition = button.textContent.trim();
                const correctDefinition = '<?php echo $word['definition']; ?>';
                if (selectedDefinition === correctDefinition) {
                    const resultElement = document.createElement('p');
                    resultElement.textContent = 'Correct!';
                    document.body.appendChild(resultElement);
                } else {
                    const resultElement = document.createElement('p');
                    resultElement.textContent = 'Not correct!';
                    document.body.appendChild(resultElement);
                }
            });
        });
    </script>
</body>