<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Question Details | TechOra</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- <script src="https://kit.fontawesome.com/e587f2d61a.js" crossorigin="anonymous"></script> -->
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
            border: none;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
        }

        .vote-btnQ {
            border: none;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
        }

        .vote-btn img{
            margin-bottom: 0px;
        }

        .vote-btnQ img{
            margin-bottom: 10px;
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
            display: none; 
        }

        .isAnswered{
            padding-left: 90%
        }

        .accepted-answer {
            background-color: #e0ffe0; 
            border-left: 5px solid #4CAF50; 
            padding: 10px;
        }

        .question-footer span{
            padding-right: 20px;
            font-size: 14px;
        }

        h6 {
            font-weight: normal; 
        }

   

    </style>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.13.1/underscore-min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/backbone.js/1.4.0/backbone-min.js"></script>


</head>
<body>

    <div id="question-details">

        <p>Asked by: <?= $question['first_name'] . ' ' . $question['last_name'] ?></p>

       
        <div class="voting">
            <button class="vote-btnQ" onclick="voteOnQuestion(<?= $question['question_id'] ?>, 'up')"> <img src="<?= base_url('assets/images/up.png'); ?>" alt="Click Me" style="width: 20px; height: 20px;"></button>
            <span id="question-vote-count"><?= $question['votes'] ?></span>
            <button class="vote-btnQ" onclick="voteOnQuestion(<?= $question['question_id'] ?>, 'down')"><img src="<?= base_url('assets/images/down.png'); ?>" alt="Click Me" style="width: 20px; height: 20px;"></button>
        </div>

        <h1><?= $question['title'] ?></h1>
        <br>
        <div class="question-footer">
            <span class="answers"><?= $question['answer_count'] ?> Answers</span>
            <span class="views"><?= $question['views'] ?> Views</span>
            <span class="votes"><?= $question['votes'] ?> Votes</span>
            <span class="posted-date">Posted on: <?= $question['asked_dt'] ?></span>

            <span class="is-answered">
                <?php if ($question['is_answered']== 1): ?>
                    ✔ Answered
                <?php endif; ?>
            </span>
        </div>

        <hr>

        <h6><?= $question['body']?></h6>
        
        <?php if (!empty($question['image_path'])): ?>
            <img src="<?= base_url($question['image_path']) ?>" alt="Question Image">
        <?php endif; ?>
        
    </div>



    <section id="answers">
    <h2>Answers</h2>
    <?php foreach ($answers as $index => $answer): ?>
        <article class="answer <?= $answer['is_accepted'] ? 'accepted-answer' : '' ?>" id="answer-<?= $answer['answer_id'] ?>">
            <h5>Answer <?= $index + 1 ?></h5> <!-- Display answer count -->
            <?php if ($answer['is_accepted']): ?>
                <p><strong>✔ Accepted Answer</strong></p>
            <?php endif; ?>
            <div class="voting">
                <button class="vote-btn" onclick="voteOnAnswer(<?= $answer['answer_id'] ?>, 'up')"><img src="<?= base_url('assets/images/up.png'); ?>" alt="Upvote" style="width: 20px; height: 20px;"></button>
                <span id="answer-vote-count-<?= $answer['answer_id'] ?>"><?= $answer['votes'] ?></span>
                <button class="vote-btn" onclick="voteOnAnswer(<?= $answer['answer_id'] ?>, 'down')"><img src="<?= base_url('assets/images/down.png'); ?>" alt="Downvote" style="width: 20px; height: 20px;"></button>
            </div>
            <p>Answered by: <?= $answer['first_name'] . ' ' . $answer['last_name']?></p>
            <p><?= $answer['body']?></p>
            <?php if ($this->session->userdata('userId') == $question['user_id']): ?>
                <?php if (!$answer['is_accepted']): ?>
                    <button class="btn accept-btn" onclick="acceptAnswer(<?= $answer['answer_id'] ?>, <?= $question['question_id'] ?>)">Accept Answer</button>
                <?php else: ?>
                    <button class="btn reject-btn" onclick="rejectAnswer(<?= $answer['answer_id'] ?>, <?= $question['question_id'] ?>)">Reject Answer</button>
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
                // successMessage.textContent = data.message; 
                // successMessage.style.display = 'block'; 
                // successMessage.style.color = 'green';
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
            .catch(error => {
                // console.log('fked');
                location.reload();
                alert(error.message);
                
            });
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
            .catch(error => {
                // console.log('fked');
                location.reload();
                alert(error.message);
                
            });
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
