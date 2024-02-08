<?php
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

$message = '';

try {
    $pdo = new PDO($dsn, $user, $pass, $options);

    if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['movie_ids'])) {
        $movie_ids = $_POST['movie_ids'];
        $placeholders = implode(',', array_fill(0, count($movie_ids), '?'));

        $stmt = $pdo->prepare("DELETE FROM Movie WHERE id IN ($placeholders)");
        if ($stmt->execute($movie_ids)) {
            $message = "Selected movies deleted successfully.";
        } else {
            $message = "Error deleting movies.";
        }
    }

    $movies = $pdo->query("SELECT id, title FROM Movie")->fetchAll();
} catch (\PDOException $e) {
    $message = "Database error: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Movies</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <div class="max-w-6xl mx-auto mt-6">
        <h1 class="text-4xl font-bold text-gray-800 text-center">Delete Movies</h1>
        <?php if ($message) : ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mt-4 text-lg flex align-start justify-center" role="alert">
                <strong class="font-bold"><?= $message ?></strong>
                <span class="block sm:inline">You can <a href="delete_movie.php" class="text-blue-500 hover:text-blue-800 font-bold">delete more movies</a> or return to the <a href="index.php" class="text-blue-500 hover:text-blue-800 font-bold">main page</a>.</span>
            </div>
        <?php endif; ?>
        <form action="" method="POST" class="mt-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <?php foreach ($movies as $movie) : ?>
                    <div class="flex items-center mb-4 bg-white p-4 rounded shadow">
                        <input type="checkbox" name="movie_ids[]" value="<?= $movie['id'] ?>" class="form-checkbox h-5 w-5">
                        <span class="ml-2"><?= htmlspecialchars($movie['title']) ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="mt-4 flex align-start justify-center">
                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                    Delete Selected
                </button>
            </div>
        </form>
    </div>
    <div class="flex justify-center align-center m-6 mb-6 text-blue-600 underline font-bold text-lg">
        <a href="index.php" class="link">Return to Main Page</a>
    </div>
</body>

</html>