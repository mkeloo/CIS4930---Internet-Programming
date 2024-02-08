<?php
// Database connection setup
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

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
        $id = $_POST['id'];
        $title = $_POST['title'];
        $director = $_POST['director'];
        $release_year = $_POST['release_year'];
        $genre = $_POST['genre'];
        $rating = $_POST['rating'];

        $sql = "UPDATE Movie SET title = ?, director = ?, release_year = ?, genre = ?, rating = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute([$title, $director, $release_year, $genre, $rating, $id])) {
            $message = "Movie updated successfully.";
        } else {
            $message = "Error updating movie.";
        }
    }

    $movies = $pdo->query("SELECT * FROM Movie")->fetchAll();
} catch (\PDOException $e) {
    $message = "Database error: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Movies</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        function toggleEditSave(movieId, isEdit) {
            const inputs = document.querySelectorAll(`tr[data-movie-id="${movieId}"] input`);
            inputs.forEach(input => {
                input.readOnly = !isEdit;
            });

            const editBtn = document.querySelector(`#edit-btn-${movieId}`);
            const saveBtn = document.querySelector(`#save-btn-${movieId}`);

            if (isEdit) {
                editBtn.style.display = 'none';
                saveBtn.style.display = 'inline-block';
            } else {
                editBtn.style.display = 'inline-block';
                saveBtn.style.display = 'none';
            }
        }
    </script>
</head>

<body class="bg-gray-100">
    <div class="max-w-6xl mx-auto mt-6">
        <h1 class="text-4xl font-bold text-gray-800 text-center mb-4">Update Movies</h1>

        <?php if ($message) : ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mt-4 text-lg flex align-start justify-center mb-8" role="alert">
                <strong class="font-bold"><?= $message ?></strong>
                <span class="block sm:inline">You can <a href="update_movie.php" class="text-blue-500 hover:text-blue-800 font-bold">update more movies</a> or return to the <a href="index.php" class="text-blue-500 hover:text-blue-800 font-bold">main page</a>.</span>
            </div>
        <?php endif; ?>
        <div class="overflow-x-auto relative shadow-lg sm:rounded-lg my-8">
            <table class="w-full text-md text-left text-gray-800 ">
                <thead class="text-md font-bold text-gray-100 uppercase bg-gray-700">
                    <tr>
                        <th class="py-3 px-6">Title</th>
                        <th class="py-3 px-6">Director</th>
                        <th class="py-3 px-6">Release Year</th>
                        <th class="py-3 px-6">Genre</th>
                        <th class="py-3 px-6">Rating</th>
                        <th class="py-3 px-6">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($movies as $movie) : ?>
                        <tr class="bg-white border-b p-2 font-bold" data-movie-id="<?= $movie['id'] ?>">
                            <form method="POST" class="">
                                <td class="py-4 px-6 "><input type="text" name="title" value="<?= htmlspecialchars($movie['title']) ?>" class="w-full text-sm py-4 px-6" readOnly /></td>
                                <td class="py-4 px-6"><input type="text" name="director" value="<?= htmlspecialchars($movie['director']) ?>" class="w-full text-sm  py-4 px-6" readOnly /></td>
                                <td class="py-4 px-6"><input type="number" name="release_year" value="<?= $movie['release_year'] ?>" class="w-full text-sm  py-4 px-6" readOnly /></td>
                                <td class="py-4 px-6"><input type="text" name="genre" value="<?= htmlspecialchars($movie['genre']) ?>" class="w-full text-sm  py-4 px-6" readOnly /></td>
                                <td class="py-4 px-6"><input type="text" name="rating" value="<?= $movie['rating'] ?>" class="w-full text-sm  py-4 px-6" readOnly /></td>
                                <td class="py-4 px-6 flex justify-around">
                                    <input type="hidden" name="id" value="<?= $movie['id'] ?>" />
                                    <button id="edit-btn-<?= $movie['id'] ?>" onclick="toggleEditSave('<?= $movie['id'] ?>', true)" type="button" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">Edit</button>
                                    <button id="save-btn-<?= $movie['id'] ?>" onclick="toggleEditSave('<?= $movie['id'] ?>', false)" type="submit" name="update" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded" style="display: none;">Save</button>
                                </td>
                            </form>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="flex justify-center align-center m-6 mb-6 text-blue-600 underline font-bold text-lg">
                <a href="index.php" class="link">Return to Main Page</a>
            </div>
        </div>
    </div>

</body>

</html>