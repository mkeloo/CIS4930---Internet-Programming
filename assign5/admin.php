<?php
$csvFile = 'data.csv';
error_reporting(E_ALL);
ini_set('display_errors', 1);

$scores = [];
$participants = [];
$questionCorrectCounts = [
    'phpDefinition' => 0,
    'commentSyntax' => 0,
    'variableDeclaration' => 0,
    'createCookie' => 0,
    'startSession' => 0,
];
$totalSubmissions = 0;
$numericScores = [];


if (($handle = fopen($csvFile, "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        if (count($data) != 7) continue;

        $participants[] = array_slice($data, 0, 7);

        $totalSubmissions++;

        $cleanData = array_map('trim', $data);
        $cleanData = array_map('strtolower', $cleanData);

        $score = is_numeric($cleanData[6]) ? (float)$cleanData[6] : 0;
        $scores[] = $score;
        $numericScores[] = $score;

        $questionCorrectCounts['phpDefinition'] += $cleanData[1] === "php: hypertext preprocessor" ? 1 : 0;
        $commentSyntaxAnswers = explode('|', $cleanData[2]);
        $questionCorrectCounts['commentSyntax'] += in_array('//', $commentSyntaxAnswers) || in_array('#', $commentSyntaxAnswers) ? 1 : 0;
        $questionCorrectCounts['variableDeclaration'] += $cleanData[3] === "dollarsign" ? 1 : 0;
        $questionCorrectCounts['createCookie'] += $cleanData[4] === "setcookie()" ? 1 : 0;
        $questionCorrectCounts['startSession'] += $cleanData[5] === "session_start()" ? 1 : 0;
    }
    fclose($handle);
}



//  statistics
$averageScore = array_sum($numericScores) / max(count($numericScores), 1);
$minScore = count($numericScores) ? min($numericScores) : 0;
$maxScore = count($numericScores) ? max($numericScores) : 0;

$questionPerformance = array_map(function ($correctCount) use ($totalSubmissions) {
    return $totalSubmissions > 0 ? ($correctCount / $totalSubmissions) * 100 : 0;
}, $questionCorrectCounts);


// $correctAnswers = [
//     1 => "php: hypertext preprocessor",
//     2 => "//|#",
//     3 => "dollarsign",
//     4 => "setcookie()",
//     5 => "session_start()",
// ];

$correctAnswers = [
    "phpDefinition" => "php: hypertext preprocessor",
    "commentSyntax" => ["//", "#"], // Correct answers as an array
    "variableDeclaration" => "dollarsign",
    "createCookie" => "setcookie()",
    "startSession" => "session_start()",
];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Quiz Statistics</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-200">
    <div class="container mx-auto p-4">
        <h1 class="text-2xl md:text-3xl font-bold text-center mb-6">Quiz Statistics</h1>
        <div class="flex flex-wrap justify-center">
            <div class="mb-4 m-4 p-4 bg-white shadow rounded-xl">
                <h2 class="text-lg font-semibold text-center">Overall Performance:</h2>
                <p>Average Score: <?= number_format($averageScore, 2) ?>%</p>
                <p>Minimum Score: <?= $minScore ?>%</p>
                <p>Maximum Score: <?= $maxScore ?>%</p>
            </div>

            <div class="mb-4 m-4 p-4 bg-white shadow rounded-xl">
                <h2 class="text-lg font-semibold text-center">Question-level Performance:</h2>
                <?php foreach ($questionPerformance as $question => $performance) : ?>
                    <p><?= htmlspecialchars($question) ?>: <?= number_format($performance, 2) ?>% correct</p>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Participants Table -->
        <div class="mt-8">
            <h2 class="text-xl font-semibold mb-4 text-center">Participant Answers</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full leading-normal border-black border-2 bg-gray-100 shadow-xl">
                    <thead class="border-black border-2">
                        <tr>
                            <th class="px-4 py-2 border-black border-2">Name</th>
                            <th class="px-4 py-2 border-black border-2">PHP Definition</th>
                            <th class="px-4 py-2 border-black border-2">Comment Syntax</th>
                            <th class="px-4 py-2 border-black border-2">Variable Declaration</th>
                            <th class="px-4 py-2 border-black border-2">Create Cookie</th>
                            <th class="px-4 py-2 border-black border-2">Start Session</th>
                            <th class="px-4 py-2 border-black border-2">Score (%)</th>
                        </tr>
                    </thead>
                    <tbody class="border-black border-2">
                        <?php foreach ($participants as $index => $participant) : ?>
                            <tr class="border-black border-2">
                                <?php foreach ($participant as $key => $value) : ?>
                                    <?php
                                    $bgColor = "bg-red-300";

                                    if ($key == 0) {
                                        $bgColor = "";
                                    } elseif ($key == 1 && strtolower(trim($value)) === strtolower($correctAnswers["phpDefinition"])) {
                                        $bgColor = "bg-green-300";
                                    } elseif ($key == 2) {
                                        $participantAnswers = explode('|', strtolower(trim($value)));
                                        $correct = !array_diff($participantAnswers, $correctAnswers["commentSyntax"]);
                                        if ($correct) {
                                            $bgColor = "bg-green-300";
                                        }
                                    } elseif ($key == 3 && strtolower(trim($value)) === strtolower($correctAnswers["variableDeclaration"])) {
                                        $bgColor = "bg-green-300";
                                    } elseif ($key == 4 && strtolower(trim($value)) === strtolower($correctAnswers["createCookie"])) {
                                        $bgColor = "bg-green-300";
                                    } elseif ($key == 5 && strtolower(trim($value)) === strtolower($correctAnswers["startSession"])) {
                                        $bgColor = "bg-green-300";
                                    } elseif ($key == 6) {
                                        $bgColor = "";
                                    }
                                    ?>
                                    <td class="border px-4 py-2 border-black border-2 <?= $bgColor ?>"><?= htmlspecialchars($value) ?></td>
                                <?php endforeach; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- link back to homepage -->
    <div class="text-center mt-8 mb-10">
        <a href="../index.html" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ">Back to Homepage</a>
    </div>
</body>

</html>