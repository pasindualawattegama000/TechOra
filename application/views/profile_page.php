<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechOra Profile</title>

    
    <!-- Link to external CSS file -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/profilePageStyles.css'); ?>">


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
    <div id="profile-section">
        <div class="profile-header">
            <h1>My Profile</h1>
            <img src="<?php echo base_url('assets/images/defaultProfile.png'); ?>" alt="User Avatar">
            <h5><?php echo $user['first_name'] . ' ' . $user['last_name']; ?></h5>
            <button id="delete-profile" class="btn btn-danger">Delete Profile</button>
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
            if (confirm('Are you sure you want to delete this question? This action cannot be undone.')) {
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
            }
        });

        $(".delete-answer").click(function () {
        if (confirm('Are you sure you want to delete this answer? This action cannot be undone.')) {
            var answerDiv = $(this).closest(".answer");
            var answerId = answerDiv.data("answer-id");
            $.ajax({
                url: "<?php echo site_url('api/profile/deleteAnswer'); ?>/" + answerId,
                type: "DELETE",
                success: function (response) {
                    answerDiv.remove();
                    alert(response.message);
                },
                error: function (xhr) {
                    alert("Failed to delete answer");
                }
            });
        }
    });
});

    $(document).ready(function () {
            $('#delete-profile').click(function() {
                if (confirm('Are you sure you want to delete your profile? This action cannot be undone!')) {
                    $.ajax({
                        url: "<?php echo site_url('api/profile/deleteProfile'); ?>",
                        type: "DELETE",
                        success: function (response) {
                            alert("Profile deleted successfully.");
                            window.location.href = "<?php echo site_url('home'); ?>"; // Redirect to home page after deletion
                        },
                        error: function (xhr) {
                            alert("Failed to delete profile");
                        }
                    });
                }
            });
           
        });


    </script>
</body>
</html>
