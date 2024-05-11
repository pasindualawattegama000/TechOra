<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Question Details | TechOra</title>
    <style>
        #question-details, #answers, #post-answer {
            background-color: #fff;
            padding: 20px;
            margin: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        h1, h2 {
            color: #333;
        }

        #question-details img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
            margin-top: 15px;
        }

        .answer {
            border-top: 2px solid #ddd;
            padding-top: 15px;
            margin-top: 15px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
        }

        .form-group textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            resize: vertical;
        }

        .btn {
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        #success-message {
            color: green;
            margin: 10px 20px;
            text-align: center;
            display: none; /* Hidden by default */
        }

        .isAnswered{
            padding-left: 90%
        }

    </style>
</head>
<body>
<div id="question-details">

        <h2>Question</h2>
        <?php if ($question['is_answered']== 1): ?>
            <span class="isAnswered" >✔ Answered</span>
            
        <?php endif; ?>
        <hr>

        <div class="voting">
            <button onclick="voteOnQuestion(<?= $question['question_id'] ?>, 'up')">Upvote</button>
            <span id="question-vote-count"><?= $question['votes'] ?></span>
            <button onclick="voteOnQuestion(<?= $question['question_id'] ?>, 'down')">Downvote</button>
        </div>
        <h1><?= htmlspecialchars($question['title'], ENT_QUOTES, 'UTF-8') ?></h1>
        <p>Asked by: <?= htmlspecialchars($question['first_name'] . ' ' . $question['last_name'], ENT_QUOTES, 'UTF-8') ?></p>


        <p><?= nl2br(htmlspecialchars($question['body'], ENT_QUOTES, 'UTF-8')) ?></p>
        <?php if (!empty($question['image_path'])): ?>
            <img src="<?= base_url($question['image_path']) ?>" alt="Question Image">
        <?php endif; ?>
    </div>

    <section id="answers">
    <h2>Answers</h2>
    <?php foreach ($answers as $answer): ?>
        <article class="answer" id="answer-<?= $answer['answer_id'] ?>">
            <div class="voting">
                <button onclick="voteOnAnswer(<?= $answer['answer_id'] ?>, 'up')">Upvote</button>
                <span id="answer-vote-count-<?= $answer['answer_id'] ?>"><?= $answer['votes'] ?></span>
                <button onclick="voteOnAnswer(<?= $answer['answer_id'] ?>, 'down')">Downvote</button>
            </div>
            <p>Answered by: <?= htmlspecialchars($answer['first_name'] . ' ' . $answer['last_name'], ENT_QUOTES, 'UTF-8') ?></p>
            <p><?= nl2br(htmlspecialchars($answer['body'], ENT_QUOTES, 'UTF-8')) ?></p>
            <?php if ($this->session->userdata('userId') == $question['user_id']): ?>
                <?php if (!$answer['is_accepted']): ?>
                    <button onclick="acceptAnswer(<?= $answer['answer_id'] ?>,<?= $question['question_id'] ?>)">Accept Answer</button>
                <?php else: ?>
                    <button onclick="rejectAnswer(<?= $answer['answer_id'] ?>,<?= $question['question_id'] ?>)">Reject Answer</button>
                <?php endif; ?>
            <?php endif; ?>
        </article>
    <?php endforeach; ?>
</section>

    <!-- Success message -->
    <div id="success-message"></div>

    <section id="post-answer">
        <h2>Your Answer</h2>
        <form id="answerForm">
            <div class="form-group">
                <label for="answer-body">Answer:</label>
                <textarea id="answer-body" name="body" rows="6" required></textarea>
            </div>
            <input type="hidden" name="question_id" value="<?= $question['question_id'] ?>" />
            <button type="submit" class="btn">Post Answer</button>
        </form>
    </section>

    <script>
        document.getElementById('answerForm').onsubmit = function(event) {
            event.preventDefault();
            var form = this;
            var formData = new FormData(form);
            var successMessage = document.getElementById('success-message');

            fetch('<?= site_url('answers/post_answer') ?>', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                successMessage.textContent = data.message; // Display the message from the server
                successMessage.style.display = 'block'; // Make the success message visible
                if (data.status === 'success') {
                    successMessage.style.color = 'green';
                } else {
                    successMessage.style.color = 'red';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                successMessage.textContent = 'Error posting answer.';
                successMessage.style.display = 'block';
                successMessage.style.color = 'red';
            });
        };

        function voteOnQuestion(questionId, direction) {
            fetch(`<?= site_url('questions/voteOnQuestion/') ?>${questionId}/${direction}`, {
                method: 'POST',
            })
            .then(response => response.json())
            .then(data => {
                if(data.status === 'success') {
                    // Update the vote count directly
                    const voteCountSpan = document.getElementById('question-vote-count');
                    let currentVoteCount = parseInt(voteCountSpan.innerText);
                    voteCountSpan.innerText = direction === 'up' ? currentVoteCount + 1 : currentVoteCount - 1;
                } else {
                    alert(data.message);
                }
            })
            .catch(error => console.error('Error:', error));
        }

        function voteOnAnswer(answerId, direction) {
            fetch(`<?= site_url('answers/voteOnAnswer/') ?>${answerId}/${direction}`, {
                method: 'POST',
            })
            .then(response => response.json())
            .then(data => {
                if(data.status === 'success') {
                    // Update the vote count directly
                    const voteCountSpan = document.getElementById(`answer-vote-count-${answerId}`);
                    let currentVoteCount = parseInt(voteCountSpan.innerText);
                    voteCountSpan.innerText = direction === 'up' ? currentVoteCount + 1 : currentVoteCount - 1;
                } else {
                    alert(data.message);
                }
            })
            .catch(error => console.error('Error:', error));
        }

        // Answer Acceptance
        
        function acceptAnswer(answerId, questionId) {
            fetch(`<?= site_url('answers/accept_answer/') ?>${answerId}/${questionId}`, {
                method: 'POST',
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    alert(questionId);
                    // Hide the accept button and show the reject button
                    // document.getElementById(`answer-${answerId}`).querySelector(`button[onclick^='acceptAnswer']`).outerHTML = `<button onclick="rejectAnswer(${answerId})">Reject Answer</button>`;
                } else {
                    alert(data.message);
                }
            })
            .catch(error => console.error('Error:', error));
        }

        function rejectAnswer(answerId, questionId) {
            fetch(`<?= site_url('answers/reject_answer/') ?>${answerId}/${questionId}`, {
                method: 'POST',
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    // Hide the reject button and show the accept button
                    document.getElementById(`answer-${answerId}`).querySelector(`button[onclick^='rejectAnswer']`).outerHTML = `<button onclick="acceptAnswer(${answerId})">Accept Answer</button>`;
                } else {
                    alert(data.message);
                }
            })
            .catch(error => console.error('Error:', error));
        }



        
    </script>
</body>
</html>