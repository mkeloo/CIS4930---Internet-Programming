<?php
// Verify data submission is from index.php for security
// For local 
// if ($_SERVER['HTTP_REFERER'] !== 'http://localhost:3000/assign5/index.php') {
//     die('Invalid submission path!');
// }

// https://www.cise.ufl.edu/~mkeloo/cis4930/assign5/index.php
// For production
if ($_SERVER['HTTP_REFERER'] !== 'http://localhost:3000/assign5/index.php') {
    die('Invalid submission path!');
}

$csvFile = 'data.csv';

$userName = $_POST['userName'];
$phpDefinition = $_POST['phpDefinition'];
$commentSyntax = isset($_POST['commentSyntax']) ? $_POST['commentSyntax'] : [];
$variableDeclaration = $_POST['variableDeclaration'];
$createCookie = $_POST['createCookie'];
$startSession = $_POST['startSession'];

$score = 0;
$totalQuestions = 5;

$feedback = [];


// Question 1
if ($phpDefinition === "PHP: Hypertext Preprocessor") {
    $score++;
    $feedback[] = "Question 1: Correct! PHP is a self-referentially acronym for PHP: Hypertext Preprocessor. ";
} else {
    $feedback[] = "Question 1: Incorrect. The correct answer is 'PHP: Hypertext Preprocessor'.";
}

// Question 2 
$correctCommentSyntax = ['//', '#'];
$commentSyntaxScore = count(array_intersect($correctCommentSyntax, $commentSyntax)) == count($correctCommentSyntax) ? 1 : 0;
$score += $commentSyntaxScore;
$feedback[] = $commentSyntaxScore ? "Question 2: Correct! A one-line comment starts with the # or //." : "Question 2: Incorrect. The correct answers are '//' and '#'.";

// Question 3
if ($variableDeclaration === "dollarSign") {
    $score++;
    $feedback[] = "Question 3: Correct! A variable in PHP is declared with a dollar sign ($).";
} else {
    $feedback[] = "Question 3: Incorrect. The correct way to declare a variable in PHP is with a dollar sign ($).";
}

// Question 4
if ($createCookie === "setcookie()") {
    $score++;
    $feedback[] = "Question 4: Correct! The setcookie() function is used to create a cookie in PHP.";
} else {
    $feedback[] = "Question 4: Incorrect. The correct function to create a cookie in PHP is setcookie().";
}

// Question 5
if ($startSession === "session_start()") {
    $score++;
    $feedback[] = "Question 5: Correct! The session_start() function is used to start a session in PHP.";
} else {
    $feedback[] = "Question 5: Incorrect. The correct method to start a session in PHP is session_start().";
}

$overallScore = ($score / $totalQuestions) * 100;

$csvData = [
    $userName,
    $phpDefinition,
    implode('|', $commentSyntax),
    $variableDeclaration,
    $createCookie,
    $startSession,
    $overallScore
];

if ($handle = fopen($csvFile, 'a')) {
    fputcsv($handle, $csvData);
    fclose($handle);
} else {
    $feedback[] = "Error: Unable to save your responses.";
}


echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Feedback</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-200">
    <div class="container mx-auto p-4">
        <h1 class="text-xl md:text-3xl font-bold text-center mb-6">Feedback for ' . htmlspecialchars($userName) . '</h1>';

foreach ($feedback as $fb) {
    $bgColor = str_contains($fb, "Correct!") ? "bg-green-300" : "bg-red-300";
    echo '<p class="mb-4 ' . $bgColor . ' shadow-md rounded px-6 py-4">' . htmlspecialchars($fb) . '</p>';
}

echo '<p class="text-lg font-bold text-center mt-6">Your overall score: ' . htmlspecialchars($overallScore) . '%</p>
    </div>
</body>

 <div
    class="flex justify-center align-center m-6 mb-4 text-blue-600 underline font-bold text-lg"
  >
    <a href="../index.html" class="link">Return to Home Page</a>
  </div>
</html>';
