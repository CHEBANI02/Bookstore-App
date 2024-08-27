<?php
$host = 'localhost';
$db = 'product_reviews';
$user = 'nebula';
$password = 'cool';

$conn = pg_connect("host=$host dbname=$db user=$user password=$password");

if (!$conn) {
    die("Database connection failed: " . pg_last_error());
}

$email = isset($_POST['email']) ? trim($_POST['email']) : null;
$productName = isset($_POST['productName']) ? trim($_POST['productName']) : null;
$question1 = isset($_POST['question1']) ? trim($_POST['question1']) : null;
$question2 = isset($_POST['question2']) ? trim($_POST['question2']) : null;
$question3 = isset($_POST['question3']) ? trim($_POST['question3']) : null;
$question4 = isset($_POST['question4']) ? trim($_POST['question4']) : null;
$question5 = isset($_POST['question5']) ? trim($_POST['question5']) : null;
$question6 = isset($_POST['question6']) && trim($_POST['question6']) !== '' ? (int)trim($_POST['question6']) : null;
$question7 = isset($_POST['question7']) && trim($_POST['question7']) !== '' ? (int)trim($_POST['question7']) : null;
$question8 = isset($_POST['question8']) && trim($_POST['question8']) !== '' ? (int)trim($_POST['question8']) : null;
$question9 = isset($_POST['question9']) && trim($_POST['question9']) !== '' ? (int)trim($_POST['question9']) : null;
$question10 = isset($_POST['question10']) && trim($_POST['question10']) !== '' ? (int)trim($_POST['question10']) : null;
$question11 = isset($_POST['question11']) ? trim($_POST['question11']) : null;

error_log("Email: $email");
error_log("Product Name: $productName");
error_log("Question 1: $question1");
error_log("Question 2: $question2");
error_log("Question 3: $question3");
error_log("Question 4: $question4");
error_log("Question 5: $question5");
error_log("Question 6: $question6");
error_log("Question 7: $question7");
error_log("Question 8: $question8");
error_log("Question 9: $question9");
error_log("Question 10: $question10");
error_log("Question 11: $question11");

$missingFields = [];
if (!$email) $missingFields[] = 'Email Address';
if (!$productName) $missingFields[] = 'Product Name';
if (!$question1) $missingFields[] = 'Question 1';
if (!$question2) $missingFields[] = 'Question 2';
if (!$question3) $missingFields[] = 'Question 3';
if (!$question4) $missingFields[] = 'Question 4';
if (!$question5) $missingFields[] = 'Question 5';
if ($question6 === null) $missingFields[] = 'Question 6';
if ($question7 === null) $missingFields[] = 'Question 7';
if (!$question11) $missingFields[] = 'Question 11';

if (count($missingFields) > 0) {
    die("Mandatory fields are missing: " . implode(', ', $missingFields));
}

$query = 'INSERT INTO reviews (email, product_name, question1, question2, question3, question4, question5, question6, question7, question8, question9, question10, question11, created_at) VALUES ($1, $2, $3, $4, $5, $6, $7, $8, $9, $10, $11, $12, $13, NOW())';
$params = array($email, $productName, $question1, $question2, $question3, $question4, $question5, $question6, $question7, $question8, $question9, $question10, $question11);

$result = pg_query_params($conn, $query, $params);

if (!$result) {
    echo "Error: " . pg_last_error($conn);
} else {
    echo "Form submitted successfully!";
}

pg_close($conn);
?>
