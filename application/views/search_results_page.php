<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>


    <!-- Link to external CSS file -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/searchResultsStyles.css'); ?>">

</head>
<body>
<h2>Search Results for "<?php echo $searchedFor ?>"</h2>
    <div class="search-results-section">
        
        <?php if (empty($results)): ?>
            <p>No results found.</p>
        <?php else: ?>
            <?php foreach ($results as $result): ?>
                <div class="result">
                    <h3 class="result-title">
                        <a href="<?php echo site_url('QuestionDetails/loadQuestionDetails/' . $result['question_id']); ?>">
                            <?php echo $result['title']; ?>
                        </a>
                    </h3>
                    <p class="result-content"><?php echo $result['body']; ?></p>
                    <div class="result-footer">
                        <span class="answers"><?php echo $result['answers']; ?> Answers</span>
                        <span class="views"><?php echo $result['views']; ?> Views</span>
                       
                        <span class="posted-date">Posted on: <?php echo $result['asked_dt']; ?></span>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</body>
</html>
