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

            /* Button CSS */
        .btn {
            background-color: #007bff;
            color: white;
            padding: 8px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .vote-btn {
            background-color: #f0ad4e;
            color: white;
        }

        .vote-btn:hover {
            background-color: #ec971f;
        }

        .accept-btn {
            background-color: #5cb85c;
            color: white;
        }

        .accept-btn:hover {
            background-color: #4cae4c;
        }

        .reject-btn {
            background-color: #d9534f;
            color: white;
        }

        .reject-btn:hover {
            background-color: #c9302c;
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

        .accepted-answer {
            background-color: #e0ffe0; /* Light green background */
            border-left: 5px solid #4CAF50; /* Darker green left border */
            padding: 10px;
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
            <button class="vote-btn" onclick="voteOnQuestion(<?= $question['question_id'] ?>, 'up')">Upvote</button>
            <span id="question-vote-count"><?= $question['votes'] ?></span>
            <button class="vote-btn" onclick="voteOnQuestion(<?= $question['question_id'] ?>, 'down')">Downvote</button>
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
        <article class="answer <?= $answer['is_accepted'] ? 'accepted-answer' : '' ?>" id="answer-<?= $answer['answer_id'] ?>">
            <div class="voting">
                <button class="vote-btn" onclick="voteOnAnswer(<?= $answer['answer_id'] ?>, 'up')">Upvote</button>
                <span id="answer-vote-count-<?= $answer['answer_id'] ?>"><?= $answer['votes'] ?></span>
                <button class="vote-btn" onclick="voteOnAnswer(<?= $answer['answer_id'] ?>, 'down')">Downvote</button>
            </div>
            <p>Answered by: <?= htmlspecialchars($answer['first_name'] . ' ' . $answer['last_name'], ENT_QUOTES, 'UTF-8') ?></p>
            <p><?= nl2br(htmlspecialchars($answer['body'], ENT_QUOTES, 'UTF-8')) ?></p>
            <?php if ($this->session->userdata('userId') == $question['user_id']): ?>
                <?php if (!$answer['is_accepted']): ?>
                    <button class="btn accept-btn" onclick="acceptAnswer(<?= $answer['answer_id'] ?>,<?= $question['question_id'] ?>)">Accept Answer</button>
                <?php else: ?>
                    <button class="btn reject-btn" onclick="rejectAnswer(<?= $answer['answer_id'] ?>,<?= $question['question_id'] ?>)">Reject Answer</button>
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

            fetch('<?= site_url('api/answers/postAnswer') ?>', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                successMessage.textContent = data.message; // Display the message from the server
                successMessage.style.display = 'block'; // Make the success message visible
                successMessage.style.color = 'green';
                location.reload();
            })
            .catch(error => {
                console.error('Error:', error);
                successMessage.textContent = 'Error posting answer.';
                successMessage.style.display = 'block';
                successMessage.style.color = 'red';
            });
        };

        function voteOnQuestion(questionId, direction) {
            fetch(`<?= site_url('api/votes/voteOnQuestion/') ?>${questionId}/${direction}`, {
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
                    location.reload();
                    alert(data.message);
                    
                }
            })
            .catch(error => console.error('Error:', error));
        }

        function voteOnAnswer(answerId, direction) {
            fetch(`<?= site_url('api/votes/voteOnAnswer/') ?>${answerId}/${direction}`, {
                method: 'POST',
            })
            .then(response => response.json())
            .then(data => {
                if(data.status === 'success') {
                    // Update the vote count directly
                    const voteCountSpan = document.getElementById(`answer-vote-count-${answerId}`);
                    let currentVoteCount = parseInt(voteCountSpan.innerText);
                    voteCountSpan.innerText = direction === 'up' ? currentVoteCount + 1 : currentVoteCount - 1;
                    
                    console.log('reload here');
                    location.reload();
                    
                } else {
                    console.log('reload here');
                    location.reload();
                    alert(data.message);
                }
            })
            .catch(error => console.error('Error:', error));
        }

        // Answer Acceptance
        
        function acceptAnswer(answerId, questionId) {
            fetch(`<?= site_url('api/answers/acceptAnswer/') ?>${answerId}/${questionId}`, {
                method: 'POST',
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    document.getElementById(`answer-${answerId}`).classList.add('accepted-answer');
                    
                    location.reload();
                    
                } else {
                    location.reload();
                    alert(data.message);
                }
            })
            .catch(error => console.error('Error:', error));
        }

        function rejectAnswer(answerId, questionId) {
            fetch(`<?= site_url('api/answers/rejectAnswer/') ?>${answerId}/${questionId}`, {
                method: 'POST',
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {

                    document.getElementById(`answer-${answerId}`).classList.remove('accepted-answer');
                    location.reload();
                
                } else {
                    location.reload();
                    alert(data.message);
                }
            })
            .catch(error => console.error('Error:', error));
        }



        
    </script>
</body>
</html>
