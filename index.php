<?php
/*
 * Quiz application entry point.
 *
 * This script displays a multiple-choice quiz to authenticated users.
 * It enforces login via session, validates answers on submission, provides
 * per-question warnings for unanswered questions, and calculates the
 * user's score.  After submission, only the result is shown, with the
 * option to edit answers.
 */

session_start();

// If the user is not logged in, redirect to the login page.
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Define your questions and answers here.  Each question has a text,
// an array of choices, and the index (0-based) of the correct answer.
// You can expand this array to include as many questions as you need.
$questions = [
    [
        'question' => 'What is 2 + 2?',
        'choices'  => ['3', '4', '5', '6'],
        'answer'   => 1
    ],
    [
        'question' => 'What is the capital of France?',
        'choices'  => ['London', 'Berlin', 'Paris', 'Rome'],
        'answer'   => 2
    ],
    [
        'question' => 'Which planet is known as the Red Planet?',
        'choices'  => ['Earth', 'Mars', 'Jupiter', 'Venus'],
        'answer'   => 1
    ],
];

// Determine whether to display the form or the results.
$showForm   = true;
$score      = 0;
$warnings   = [];
// Retrieve previously selected answers from the session, if any.
$userAnswers = $_SESSION['quiz_answers'] ?? [];

// Process the form submission.
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_quiz'])) {
    $userAnswers = [];
    foreach ($questions as $index => $q) {
        if (isset($_POST['q' . $index])) {
            // Cast the submitted value to an integer.
            $userAnswers[$index] = (int)$_POST['q' . $index];
        } else {
            // Remember which questions were unanswered.
            $warnings[$index] = 'Please select an answer.';
        }
    }
    // If there are no unanswered questions, compute the score and hide the form.
    if (empty($warnings)) {
        foreach ($questions as $index => $q) {
            if (isset($userAnswers[$index]) && $userAnswers[$index] === $q['answer']) {
                $score++;
            }
        }
        $showForm = false;
    }
    // Persist the user's answers so we can preselect them on return.
    $_SESSION['quiz_answers'] = $userAnswers;
}

// If the user clicked "Edit Answers", show the form again.
if (isset($_GET['edit'])) {
    $showForm = true;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quiz</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .question { margin-bottom: 20px; }
        .warning { color: red; font-size: 0.9em; margin-top: 4px; }
    </style>
</head>
<body>
    <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
    <p><a href="logout.php">Logout</a></p>

    <?php if ($showForm): ?>
        <!-- Quiz form -->
        <form method="post" action="index.php">
            <?php foreach ($questions as $index => $q): ?>
                <div class="question">
                    <p><?php echo ($index + 1) . '. ' . htmlspecialchars($q['question']); ?></p>
                    <?php if (isset($warnings[$index])): ?>
                        <p class="warning"><?php echo htmlspecialchars($warnings[$index]); ?></p>
                    <?php endif; ?>
                    <?php foreach ($q['choices'] as $choiceIndex => $choice): ?>
                        <label>
                            <input type="radio" name="q<?php echo $index; ?>" value="<?php echo $choiceIndex; ?>"
                                <?php echo (isset($userAnswers[$index]) && $userAnswers[$index] === $choiceIndex) ? 'checked' : ''; ?>>
                            <?php echo htmlspecialchars($choice); ?>
                        </label><br>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
            <button type="submit" name="submit_quiz">Submit Answers</button>
        </form>
    <?php else: ?>
        <!-- Results display -->
        <h3>Your Score: <?php echo $score; ?> / <?php echo count($questions); ?></h3>
        <p><a href="?edit=1">Edit Answers</a></p>
    <?php endif; ?>
</body>
</html>