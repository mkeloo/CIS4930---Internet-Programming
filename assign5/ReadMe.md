# Assignment 5: Server-Side Programming with PHP

## Assignment Description

For this assignment, I created a web application that quizzes(5 questions) the user about basic PHP knowledge, it then stores the data of the user's responses and their final score in a CSV file on the server, and provides a feedback or the correct answers to the questions.

## Interactive Quiz (index.php)

It's basically form using HTML tags to collect quiz items on basic PHP knowledge. It includes five quiz questions and the following form elements:

- Textboxes to collect free-form information (user's name)
- Radio buttons to collect one option among many
- Checkboxes to collect many options among many
- Dropdown boxes to select one option from many
- Reset and submit buttons

It also uses jQuery to verify user input before submitting it to the server or the next file called process.php.

## Feedback and Storage (process.php)

This is a program in process.php to provide feedback or correct answers to the user and store the responses in a CSV file on the server. The information provides an overall assessment score and item-level feedback. It then saves the user's information in a CSV file with write access on the server. 

## Administration (admin.php)

I also created an admin.php page to show the overall quiz statistics and per question level performace or average of the users. It also contains a table of all the participants that took the quiz and it shows their answer choices and their total score.

## Conclusion

By completing this assignment, I gained experience in server-side programming with PHP and learned how to collect and process user data to store it in a CSV file. Finally, I also learned how to retrieve the data and present it to html page using PHP.

