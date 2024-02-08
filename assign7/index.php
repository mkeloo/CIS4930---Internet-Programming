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

    if (isset($_GET['genre']) || isset($_GET['searchText'])) {
        $genre = $_GET['genre'] ?? '';
        $searchText = $_GET['searchText'] ?? '';

        $sql = "SELECT * FROM Movie WHERE 1=1";
        $params = [];

        if ($genre) {
            $sql .= " AND genre LIKE ?";
            $params[] = "%" . $genre . "%";
        }

        if ($searchText) {
            $sql .= " AND (title LIKE ? OR director LIKE ?)";
            $params[] = "%$searchText%";
            $params[] = "%$searchText%";
        }

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $movies = $stmt->fetchAll();

        echo json_encode($movies);
        exit;
    } else {
        $sql = "SELECT * FROM Movie";
        $stmt = $pdo->query($sql);
        $movies = [];
        while ($row = $stmt->fetch()) {
            $movies[] = $row;
        }
    }
} catch (\PDOException $e) {
    $error_message = "Connection failed: " . $e->getMessage();
    $movies = [];
    if (isset($_GET['genre']) || isset($_GET['searchText'])) {
        echo json_encode(['error' => $error_message]);
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assignment 7</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        function filterMovies() {
            const genre = document.getElementById('genreFilter').value;
            const searchText = document.getElementById('textFilter').value;
            const xhr = new XMLHttpRequest();

            xhr.open('GET', `index.php?genre=${encodeURIComponent(genre)}&searchText=${encodeURIComponent(searchText)}`, true);
            xhr.onload = function() {
                if (this.status === 200 && this.responseText) {
                    const movies = JSON.parse(this.responseText);
                    let output = '';
                    movies.forEach(movie => {
                        output += `<tr class='bg-white border-gray-200 border-2'>
                        <td class='px-16 py-2 border-2'>${movie.title}</td>
                        <td class='px-16 py-2 border-2'>${movie.director}</td>
                        <td class='px-16 py-2 border-2'>${movie.release_year}</td>
                        <td class='px-16 py-2 border-2'>${movie.genre}</td>
                        <td class='px-16 py-2 border-2'>${movie.rating}</td>
                    </tr>`;
                    });
                    document.querySelector('table > tbody').innerHTML = output;
                } else {
                    document.querySelector('table > tbody').innerHTML = '<tr><td colspan="5" class="text-center text-gray-800">No movies found.</td></tr>';
                }
            };
            xhr.send();
        }

        document.addEventListener('DOMContentLoaded', filterMovies);
    </script>



</head>

<body class="bg-gray-100 max-w-6xl mx-auto">
    <div class="max-w-6xl mx-auto mt-6">
        <h1 class="text-4xl font-bold text-gray-800 text-center">Assignment 7: AJAX: Asynchronous JavaScript and XML</h1>
    </div>

    <div class='flex items-center justify-center m-4'>
        <div class='max-w-6xl mx-auto'>
            <div class='max-w-6xl mx-auto mt-6 bg-white rounded-lg shadow-xl'>
                <div class='p-6'>
                    <h1 class='text-2xl font-bold text-gray-800 text-center mb-6'>Filter Functionalities</h1>
                    <p class="flex align-center justify-center text-md font-medium text-gray-600">Note: Filter out movies either based on movies genre or movie title/director, or both movie genre and title/director. </p>
                    <div class="flex flex-col sm:flex-row justify-center items-center gap-4">

                        <div class="flex flex-col sm:flex-row items-center gap-4">
                            <div class="">
                                <label for="genreFilter" class="block text-lg font-bold text-gray-800 m-4">Filter by Genre:</label>
                                <select id="genreFilter" class="mt-1 block w-full pl-3 pr-10 py-2 text-3xl border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                    <option value="" class="text-lg">All Genres</option>
                                    <option value="Action">Action</option>
                                    <option value="Comedy">Comedy</option>
                                    <option value="Drama">Drama</option>
                                    <option value="Fantasy">Fantasy</option>
                                    <option value="Horror">Horror</option>
                                    <option value="Mystery">Mystery</option>
                                    <option value="Romance">Romance</option>
                                    <option value="Sci-Fi">Sci-Fi</option>
                                    <option value="Thriller">Thriller</option>
                                </select>
                            </div>
                            <div>
                                <label for="textFilter" class="block text-lg font-bold text-gray-800 m-4">Search by Title/Director:</label>
                                <input type="text" id="textFilter" placeholder="Type to search..." class="mt-1 block w-full pl-3 pr-10 py-2 text-lg border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            </div>
                        </div>
                        <button onclick="filterMovies()" class="mt-4 sm:mt-0 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Submit
                        </button>
                    </div>
                </div>
            </div>




            <div class='max-w-6xl mx-auto m-10'>
                <h2 class='text-3xl font-bold text-gray-800 text-center m-4'> Movie Database</h2>
                <table class='min-w-full table-auto '>
                    <thead class='bg-gray-800 '>
                        <tr class="">
                            <th class='px-16 py-2 border-2'><span class='text-gray-300'>Title</span></th>
                            <th class='px-16 py-2 border-2'><span class='text-gray-300'>Director</span></th>
                            <th class='px-16 py-2 border-2'><span class='text-gray-300'>Release Year</span></th>
                            <th class='px-16 py-2 border-2'><span class='text-gray-300'>Genre</span></th>
                            <th class='px-16 py-2 border-2'><span class='text-gray-300'>Rating</span></th>
                        </tr>
                    </thead>
                    <tbody class='bg-gray-200'>
                        <?php foreach ($movies as $movie) : ?>
                            <tr class='bg-white border-2 border-gray-200'>
                                <td class='px-16 py-2 flex flex-row items-center'><?= htmlspecialchars($movie['title']) ?></td>
                                <td><?= htmlspecialchars($movie['director']) ?></td>
                                <td class='px-16 py-2'><?= htmlspecialchars($movie['release_year']) ?></td>
                                <td class='px-16 py-2'><?= htmlspecialchars($movie['genre']) ?></td>
                                <td class='px-16 py-2'><?= htmlspecialchars($movie['rating']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

            </div>
            <div class="flex justify-center align-center m-6 mb-4 text-blue-600 underline font-bold text-lg">
                <a href="../index.html" class="link">Return to Home Page</a>
            </div>
        </div>
    </div>
</body>

</html>