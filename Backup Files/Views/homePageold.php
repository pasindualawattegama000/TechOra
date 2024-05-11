<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        #welcome-section {
    border: 1px solid #ccc; /* Outline for the entire welcome section */
    padding: 20px;
    margin-bottom: 20px; /* Adds space below the welcome section */
    text-align: center;
}

#question-section {
    background-color: #f5f5f5;
    border: 2px solid #bbb; /* Stronger outline for the whole section */
    padding: 20px;
    margin: 20px; /* Space around the question section */
}

.question {
    background-color: #fff;
    border: 1px solid #ccc; /* Outline for each question */
    margin-bottom: 10px; /* Space between questions */
    padding: 15px;
}

.question-header {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px;
}

.question-title {
    font-size: 18px;
    color: #333;
}

.question-content {
    color: #666;
}

.question-footer {
    display: flex;
    justify-content: space-between;
    margin-top: 10px;
    font-size: 14px;
}

.status.answered {
    color: green;
    font-weight: bold;
}

    </style>


</head>
<body>

<div id="welcome-section">
    <h1 class="welcome">Welcome To TechOra</h1>
 </div>


 <div id="question-section">

    <?php foreach ($questions as $question): ?>

        <div class="question">
            <div class="question-header">
                <span class="author">Pasindu_A</span>

                <?php if ($question['is_answered']): ?>
                    <span class="status answered">✔ Answered</span>
                <?php endif; ?>

            </div>
            <h2 class="question-title"><?php echo $question['title']; ?></h2>

            <p class="question-content">
            <?php echo $question['body']; ?>
            </p>

            <div class="question-footer">
                <span class="answers"><?php echo $question['answers']; ?> Answers</span>
                <span class="views"><?php echo $question['views']; ?> Views</span>
                <span class="votes"><?php echo $question['votes']; ?> Votes</span>
                <span class="posted-date">Posted on:  <?php echo date("Y-m-d | H:i:s", strtotime($question['asked_dt'])); ?></span>
            </div>
        </div>
    <?php endforeach; ?>
</div>    

</body>
</html>

