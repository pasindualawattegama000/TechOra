<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechOra Profile</title>
    <style>
        #profile-section {
            background-color: #f5f5f5;
            border: 2px solid #bbb;
            padding: 20px;
            margin: 20px;
        }

        .profile-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .profile-header img {
            width: 100px;
            padding-bottom: 10px;
        }

        .profile-header h1 {
            padding-bottom: 10px;
        }

        .questions-answers {
            display: flex;
            justify-content: space-between;
        }

        .questions, .answers {
            width: 48%;
            background-color: #fff;
            border: 1px solid #ccc;
            padding: 10px;
        }

        .question, .answer {
            border: 1px solid #ccc;
            padding: 10px;
            margin-top: 10px;
        }


        .question-title, .answer-content {
            font-size: 18px;
            color: #333;
        }

        .question p, .answer-content {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            max-width: 100%; 
        }

        .status {
            color: green;
            font-weight: bold;
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
    <div id="profile-section">
        <div class="profile-header">
            <h1>My Profile</h1>
            <img src="<?php echo base_url('assets/images/defaultProfile.png'); ?>" alt="User Avatar">
            <h5><?php echo $user['first_name'] . ' ' . $user['last_name']; ?></h5>
        </div>

        <div class="questions-answers">
            <div class="questions">
                <h3>My Questions</h3>
                <?php foreach ($questions as $question): ?>
                    <div class="question" data-question-id="<?php echo $question['question_id']; ?>">
                        <h4 class="question-title">   <a href="http://localhost/TechOra/index.php/QuestionDetails/loadQuestionDetails/<?php echo $question['question_id']; ?>" >  <?php echo $question['title']; ?> </a>  </h4> 
                        <p><?php echo $question['body']; ?></p>
                        <p><?php echo $question['answer_count']; ?> Answers |<?php echo $question['views']; ?> Views | Posted on <?php echo $question['asked_dt']; ?></p>
                        <button class="delete-question">Delete</button>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="answers">
                <h3>My Answers</h3>
                <?php foreach ($answers as $answer): ?>

                   
                    <div class="answer" data-answer-id="<?php echo $answer['answer_id']; ?>">
                        <a href="http://localhost/TechOra/index.php/QuestionDetails/loadQuestionDetails/<?php echo $answer['question_id']; ?>" > View Question  </a>
                    
                        <p class="answer-content"><?php echo $answer['body']; ?></p>
                        <p>Answered on <?php echo $answer['answered_dt']; ?></p>
                        <button class="delete-answer">Delete</button>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <script>
       $(document).ready(function () {
        $(".delete-question").click(function () {
            var questionDiv = $(this).closest(".question");
            var questionId = questionDiv.data("question-id");
            $.ajax({
                url: "<?php echo site_url('api/profile/deleteQuestion'); ?>/" + questionId,
                type: "DELETE",
                success: function (response) {
                    questionDiv.remove();
                    alert(response.message);
                },
                error: function (xhr) {
                    alert("Failed to delete question");
                }
            });
        });

        $(".delete-answer").click(function () {
            var answerDiv = $(this).closest(".answer");
            var answerId = answerDiv.data("answer-id");
            $.ajax({
                url: "<?php echo site_url('api/profile/deleteAnswer'); ?>/" + answerId,
                type: "DELETE",
                success: function (response) {
                    console.log("success");
                    answerDiv.remove();
                    alert(response.message);
                },
                error: function (xhr) {
    
                    alert("Failed to delete answer");
                }
            });
        });
    });

    </script>
</body>
</html>
