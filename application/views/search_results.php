<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <style>
        .search-results-section {
            background-color: #f5f5f5;
            border: 2px solid #bbb;
            padding: 20px;
            margin: 20px;
        }

        .result {
            background-color: #fff;
            border: 1px solid #ccc;
            margin-bottom: 10px;
            padding: 15px;
        }

        .result-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .result-title {
            font-size: 18px;
            color: #333;
        }

        .result-content {
            color: #666;
        }

        .result-footer {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="search-results-section">
        <h2>Search Results for "<?php echo $searchedFor ?>"</h2>

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
