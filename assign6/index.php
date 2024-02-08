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

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    $sql = "SELECT * FROM Movie";
    $stmt = $pdo->query($sql);

    $movies = [];
    while ($row = $stmt->fetch()) {
        $movies[] = $row;
    }
} catch (\PDOException $e) {
    $error_message = "Connection failed: " . $e->getMessage();
    $movies = [];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assignment 6</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <div class="max-w-6xl mx-auto mt-6">
        <h1 class="text-4xl font-bold text-gray-800 text-center">Assignment 6: CRUD Operations on Movie Database</h1>
    </div>

    <div class='flex items-center justify-center m-4'>
        <div class='max-w-6xl mx-auto'>
            <div class='max-w-6xl mx-auto mt-6 bg-white rounded-lg p-4 m-4 shadow-xl flex align-start justify-between '>
                <h1 class='text-2xl font-bold text-gray-800 text-center m-4'>Create, Update, and Delete Movies</h1>
                <div class='text-center mt-4 mb-4'>
                    <a href='add_movie.php' class='bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded'>
                        Add Movie
                    </a>
                </div>
                <div class='text-center mt-4 mb-4'>
                    <a href='update_movie.php' class='bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded'>
                        Update Movie
                    </a>
                </div>
                <div class='text-center mt-4 mb-4'>
                    <a href='delete_movie.php' class='bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded'>
                        Delete Movie
                    </a>
                </div>
            </div>
            <div class='max-w-6xl mx-auto m-10 flex align-content-start justify-between '>
                <h2 class='text-2xl font-bold text-gray-800 text-center'>Reading From Movie Database</h2>
            </div>
            <?php if (!empty($movies)) : ?>
                <table class='min-w-full table-auto'>
                    <thead class='justify-between'>
                        <tr class='bg-gray-800'>
                            <th class='px-16 py-2'><span class='text-gray-300'>Title</span></th>
                            <th class='px-16 py-2'><span class='text-gray-300'>Director</span></th>
                            <th class='px-16 py-2'><span class='text-gray-300'>Release Year</span></th>
                            <th class='px-16 py-2'><span class='text-gray-300'>Genre</span></th>
                            <th class='px-16 py-2'><span class='text-gray-300'>Rating</span></th>
                        </tr>
                    </thead>
                    <tbody class='bg-gray-200'>
                        <?php foreach ($movies as $movie) : ?>
                            <tr class='bg-white border-4 border-gray-200'>
                                <td class='px-16 py-2 flex flex-row items-center'><?= htmlspecialchars($movie['title']) ?></td>
                                <td><?= htmlspecialchars($movie['director']) ?></td>
                                <td class='px-16 py-2'><?= htmlspecialchars($movie['release_year']) ?></td>
                                <td class='px-16 py-2'><?= htmlspecialchars($movie['genre']) ?></td>
                                <td class='px-16 py-2'><?= htmlspecialchars($movie['rating']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else : ?>
                <p class="text-center text-gray-800">No movies found or database connection error.</p>
            <?php endif; ?>
            <div class="flex justify-center align-center m-6 mb-4 text-blue-600 underline font-bold text-lg">
                <a href="../index.html" class="link">Return to Home Page</a>
            </div>
        </div>
    </div>
</body>

</html>