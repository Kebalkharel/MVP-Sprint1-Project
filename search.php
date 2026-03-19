<?php
require 'auth.php';
include 'header.php';
?>

<?php
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

$items = [
    [
        "title" => "Events",
        "description" => "Check latest campus events and activities.",
        "link" => "events.php"
    ],
    [
        "title" => "Transport",
        "description" => "See bus schedules and campus transport updates.",
        "link" => "transport.php"
    ],
    [
        "title" => "Clubs",
        "description" => "Connect with student clubs and societies.",
        "link" => "clubs.php"
    ],
    [
        "title" => "Library",
        "description" => "Access library timings and resources.",
        "link" => "library.php"
    ],
    [
        "title" => "Rewards",
        "description" => "Track your points and student engagement rewards.",
        "link" => "rewards.php"
    ],
    [
        "title" => "Login",
        "description" => "Student login page for portal access.",
        "link" => "login.php"
    ]
];

$results = [];

if ($search !== '') {
    foreach ($items as $item) {
        if (
            stripos($item['title'], $search) !== false ||
            stripos($item['description'], $search) !== false
        ) {
            $results[] = $item;
        }
    }
}
?>

<h1 class="page-title">Search Results</h1>

<div class="card">
    <h3>Search for: "<?php echo htmlspecialchars($search); ?>"</h3>

    <?php if ($search === ''): ?>
        <p style="margin-top: 12px;">Please enter a keyword in the search box.</p>

    <?php elseif (!empty($results)): ?>
        <ul class="result-list">
            <?php foreach ($results as $result): ?>
                <li>
                    <strong><?php echo htmlspecialchars($result['title']); ?></strong><br>
                    <?php echo htmlspecialchars($result['description']); ?><br><br>
                    <a href="<?php echo htmlspecialchars($result['link']); ?>">Open Page</a>
                </li>
            <?php endforeach; ?>
        </ul>

    <?php else: ?>
        <p style="margin-top: 12px;">No matching results found.</p>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
