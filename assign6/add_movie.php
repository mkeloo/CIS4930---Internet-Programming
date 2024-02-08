<?php
$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST['title']);
    $director = trim($_POST['director']);
    $release_year = filter_input(INPUT_POST, 'release_year', FILTER_SANITIZE_NUMBER_INT);
    $rating = filter_input(INPUT_POST, 'rating', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $genre = isset($_POST['genres']) ? implode(', ', $_POST['genres']) : '';


    $host = 'sql5.freemysqlhosting.net';
    $db   = 'sql5682635';
    $user = 'sql5682635';
    $pass = 'pN8AumsS7F';
    $charset = 'utf8mb4';

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    try {
        $pdo = new PDO($dsn, $user, $pass, $options);

        $stmt = $pdo->prepare("INSERT INTO Movie (title, director, release_year, genre, rating) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$title, $director, $release_year, $genre, $rating]);

        $message = "Movie added successfully!";
    } catch (\PDOException $e) {
        $message = "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Movie</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <div class="max-w-4xl mx-auto mt-6">
        <h1 class="text-4xl font-bold text-gray-800 text-center my-8">Add a New Movie</h1>
        <?php if (!empty($message)) : ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mt-4 text-lg flex align-start justify-center" role="alert">
                <strong class="font-bold"><?= $message ?></strong>
                <span class="block sm:inline">You can <a href="add_movie.php" class="text-blue-500 hover:text-blue-800 font-bold">Add another Movie</a> or Return to the <a href="index.php" class="text-blue-500 hover:text-blue-800 font-bold">Main Page</a>.</span>
            </div>
        <?php endif; ?>
        <div class="mt-8 mb-4">
            <form action="" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                <div class="mb-4">
                    <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Movie Title:</label>
                    <input type="text" name="title" id="title" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div class="mb-4">
                    <label for="director" class="block text-gray-700 text-sm font-bold mb-2">Director:</label>
                    <input type="text" name="director" id="director" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div class="mb-4">
                    <label for="release_year" class="block text-gray-700 text-sm font-bold mb-2">Release Year:</label>
                    <select name="release_year" id="release_year" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                        <?php for ($year = 1800; $year <= 2024; $year++) : ?>
                            <option value="<?= $year ?>"><?= $year ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="mb-4">
                    <span class="block text-gray-700 text-sm font-bold mb-2">Genre:</span>
                    <?php $genres = ['Action', 'Comedy', 'Drama', 'Fantasy', 'Horror', 'Mystery', 'Romance', 'Sci-Fi', 'Thriller']; ?>
                    <?php foreach ($genres as $genre) : ?>
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="genres[]" value="<?= $genre ?>" class="form-checkbox">
                            <span class="ml-2"><?= $genre ?></span>
                        </label><br>
                    <?php endforeach; ?>
                </div>
                <div class="mb-4">
                    <label for="rating" class="block text-gray-700 text-sm font-bold mb-2">Rating:</label>
                    <select name="rating" id="rating" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                        <?php for ($rating = 1.0; $rating <= 10.0; $rating += 0.1) : ?>
                            <option value="<?= number_format($rating, 1) ?>"><?= number_format($rating, 1) ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="mb-4">
                    <span class="block text-gray-700 text-sm font-bold mb-2">Available for Streaming:</span>
                    <label class="inline-flex items-center">
                        <input type="radio" name="streaming" value="Yes" class="form-radio">
                        <span class="ml-2">Yes</span>
                    </label>
                    <label class="inline-flex items-center ml-6">
                        <input type="radio" name="streaming" value="No" class="form-radio">
                        <span class="ml-2">No</span>
                    </label>
                </div>
                <div class="flex items-center justify-between">
                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">Submit</button>
                </div>
            </form>
        </div>
        <div class="flex justify-center align-center m-6 mb-6 text-blue-600 underline font-bold text-lg">
            <a href="index.php" class="link">Return to Main Page</a>
        </div>
    </div>
</body>

</html>