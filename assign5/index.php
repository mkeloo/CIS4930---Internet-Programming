<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>PHP Knowledge Quiz</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#quizForm').submit(function(e) {
                var isFormValid = true;

                if ($('#userName').val().trim() === '') {
                    alert('Please enter your name.');
                    isFormValid = false;
                }

                var radioGroups = ["phpDefinition", "createCookie", "startSession"];
                $.each(radioGroups, function(index, name) {
                    if ($("input[name='" + name + "']:checked").length == 0) {
                        alert('Please answer all questions.');
                        isFormValid = false;
                        return false;
                    }
                });

                if ($("input[name='commentSyntax[]']:checked").length == 0) {
                    alert('Please select at least one option for question 2.');
                    isFormValid = false;
                }

                if ($("select[name='variableDeclaration']").val() === "") {
                    alert('Please select an option for the variable declaration question.');
                    isFormValid = false;
                }


                if (!isFormValid) {
                    e.preventDefault();
                }
                return isFormValid;
            });
        });
    </script>


</head>

<body class="bg-gray-100">
    <div class="container mx-auto px-4 ">
        <h1 class="text-xl md:text-3xl font-bold text-center my-5">PHP Knowledge Quiz</h1>
        <form id="quizForm" action="process.php" method="post" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <div class="mb-4">
                <label for="userName" class="block text-gray-700 text-sm md:text-lg font-bold mb-2">Your Name:</label>
                <input type="text" id="userName" name="userName" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="mb-4">
                <p class="text-gray-700 text-sm md:text-lg font-bold mb-2">1. What does PHP stand for?</p>
                <div class="ml-4">
                    <input type="radio" id="personalHome" name="phpDefinition" value="Personal Home Page" required class="mr-2">
                    <label for="personalHome" class="text-gray-600">Personal Home Page</label><br>
                    <input type="radio" id="phpHypertext" name="phpDefinition" value="PHP: Hypertext Preprocessor" class="mr-2">
                    <label for="phpHypertext" class="text-gray-600">PHP: Hypertext Preprocessor</label><br>
                    <input type="radio" id="privateHomePage" name="phpDefinition" value="Private Home Page" class="mr-2">
                    <label for="privateHomePage" class="text-gray-600">Private Home Page</label>
                </div>
            </div>

            <div class="mb-4">
                <p class="text-gray-700 text-sm md:text-lg font-bold mb-2">2. Which of the following can be used to comment a single line in PHP?</p>
                <div class="ml-4">
                    <label for="doubleSlash" class="inline-flex items-center">
                        <input type="checkbox" id="doubleSlash" name="commentSyntax[]" value="//" class="form-checkbox text-blue-600">
                        <span class="ml-2">//</span>
                    </label><br>
                    <label for="hash" class="inline-flex items-center">
                        <input type="checkbox" id="hash" name="commentSyntax[]" value="#" class="form-checkbox text-blue-600">
                        <span class="ml-2">#</span>
                    </label><br>
                    <label for="slashAsterisk" class="inline-flex items-center">
                        <input type="checkbox" id="slashAsterisk" name="commentSyntax[]" value="/* */" class="form-checkbox text-blue-600">
                        <span class="ml-2">/* */</span>
                    </label>
                </div>
            </div>

            <div class="mb-4">
                <p class="text-gray-700 text-sm md:text-lg font-bold mb-2">3. How do you declare a variable in PHP?</p>
                <select name="variableDeclaration" required class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                    <option value="">Please select</option>
                    <option value="dollarSign">With a dollar sign ($) followed by the variable name</option>
                    <option value="varKeyword">Using the var keyword</option>
                    <option value="atSymbol">With an at symbol (@) followed by the variable name</option>
                </select>
            </div>

            <div class="mb-4">
                <p class="text-gray-700 text-sm md:text-lg font-bold mb-2">4. How do you create a cookie in PHP?</p>
                <div class="ml-4">
                    <label for="cookieSet" class="inline-flex items-center">
                        <input type="radio" id="cookieSet" name="createCookie" value="setcookie()" required class="form-radio text-blue-600">
                        <span class="ml-2">setcookie()</span>
                    </label><br>
                    <label for="cookieCreate" class="inline-flex items-center">
                        <input type="radio" id="cookieCreate" name="createCookie" value="createCookie()" class="form-radio text-blue-600">
                        <span class="ml-2">createCookie()</span>
                    </label><br>
                    <label for="cookie" class="inline-flex items-center">
                        <input type="radio" id="cookie" name="createCookie" value="cookie()" class="form-radio text-blue-600">
                        <span class="ml-2">cookie()</span>
                    </label>
                </div>
            </div>

            <div class="mb-4">
                <p class="text-gray-700 text-sm md:text-lg font-bold mb-2">5. Which of the following methods is used to start a session in PHP?</p>
                <div class="ml-4">
                    <label for="sessionStart" class="inline-flex items-center">
                        <input type="radio" id="sessionStart" name="startSession" value="session_start()" required class="form-radio text-blue-600">
                        <span class="ml-2">session_start()</span>
                    </label><br>
                    <label for="startSession" class="inline-flex items-center">
                        <input type="radio" id="startSession" name="startSession" value="start_session()" class="form-radio text-blue-600">
                        <span class="ml-2">start_session()</span>
                    </label><br>
                    <label for="beginSession" class="inline-flex items-center">
                        <input type="radio" id="beginSession" name="startSession" value="begin_session()" class="form-radio text-blue-600">
                        <span class="ml-2">begin_session()</span>
                    </label>
                </div>
            </div>

            <div class="flex justify-center align-center mt-4">
                <input type="submit" value="Submit" class="bg-blue-500 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline cursor-pointer m-4">
                <input type="reset" value="Reset" class="bg-gray-300 hover:bg-gray-400 text-black font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline cursor-pointer m-4">
            </div>
        </form>
</body>

</html>