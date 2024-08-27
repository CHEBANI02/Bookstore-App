<?php
include 'db.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

try {
    $query = 'SELECT * FROM reviews';
    $result = pg_query($conn, $query);

    if (!$result) {
        throw new Exception('Database error: ' . pg_last_error());
    }

    $reviews = [];
    while ($row = pg_fetch_assoc($result)) {
        $reviews[] = $row;
    }

    function calculateAverage($reviews, $field) {
        $total = array_sum(array_column($reviews, $field));
        $count = count($reviews);
        return $count > 0 ? $total / $count : 0;
    }

    $averageRatings = [
        'question6' => calculateAverage($reviews, 'question6'),
        'question7' => calculateAverage($reviews, 'question7'),
        'question8' => calculateAverage($reviews, 'question8'),
        'question9' => calculateAverage($reviews, 'question9'),
        'question10' => calculateAverage($reviews, 'question10')
    ];

    pg_close($conn);

} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            background-color: #f0f4f7; 
            font-family: Arial, sans-serif;
        }
        .dashboard-container {
            width: 90%;
            margin: 0 auto;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            overflow-x: auto;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .chart-container {
            width: 50%;
            margin: 20px auto;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="dashboard-container">
        <h1>Admin Dashboard</h1>

        <h2>All Submissions</h2>
        <div style="overflow-x:auto;">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Email</th>
                        <th>Product Name</th>
                        <th>Question 1</th>
                        <th>Question 2</th>
                        <th>Question 3</th>
                        <th>Question 4</th>
                        <th>Question 5</th>
                        <th>Question 6</th>
                        <th>Question 7</th>
                        <th>Question 8</th>
                        <th>Question 9</th>
                        <th>Question 10</th>
                        <th>Question 11</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($reviews)) : ?>
                        <?php foreach ($reviews as $review) : ?>
                            <tr>
                                <td><?= htmlspecialchars($review['id']); ?></td>
                                <td><?= htmlspecialchars($review['email']); ?></td>
                                <td><?= htmlspecialchars($review['product_name']); ?></td>
                                <td><?= htmlspecialchars($review['question1']); ?></td>
                                <td><?= htmlspecialchars($review['question2']); ?></td>
                                <td><?= htmlspecialchars($review['question3']); ?></td>
                                <td><?= htmlspecialchars($review['question4']); ?></td>
                                <td><?= htmlspecialchars($review['question5']); ?></td>
                                <td><?= htmlspecialchars($review['question6']); ?></td>
                                <td><?= htmlspecialchars($review['question7']); ?></td>
                                <td><?= htmlspecialchars($review['question8'] ?? 'N/A'); ?></td>
                                <td><?= htmlspecialchars($review['question9'] ?? 'N/A'); ?></td>
                                <td><?= htmlspecialchars($review['question10'] ?? 'N/A'); ?></td>
                                <td><?= htmlspecialchars($review['question11']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="14">No reviews available</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <h2>Average Ratings Visualization</h2>
        <div class="chart-container">
            <canvas id="averageRatingsChart"></canvas>
        </div>
    </div>

    <script>
        const averageRatings = <?= json_encode($averageRatings); ?>;
        const ctx = document.getElementById('averageRatingsChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Ease of Use', 'Durability', 'Design', 'Performance', 'Overall Satisfaction'],
                datasets: [{
                    label: 'Average Ratings',
                    data: [
                        averageRatings.question6.toFixed(2),
                        averageRatings.question7.toFixed(2),
                        averageRatings.question8.toFixed(2),
                        averageRatings.question9.toFixed(2),
                        averageRatings.question10.toFixed(2)
                    ],
                    backgroundColor: [
                        '#4CAF50',
                        '#FFC107',
                        '#2196F3',
                        '#FF5722',
                        '#9C27B0'
                    ],
                    borderColor: [
                        '#388E3C',
                        '#FFA000',
                        '#1976D2',
                        '#D84315',
                        '#7B1FA2'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>
