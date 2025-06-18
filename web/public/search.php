<?php
require_once '../config/database.php';
require_once '../includes/header.php';

$q = $_GET['q'] ?? '';
$safe = "%$q%";

$stmt = $conn->prepare("SELECT * FROM article WHERE status='published' AND title LIKE ? ORDER BY created_at DESC");
$stmt->bind_param("s", $safe);
$stmt->execute();
$result = $stmt->get_result();
$articles = $result->fetch_all(MYSQLI_ASSOC);

function getAuthors($conn, $articleId) {
    $authors = [];
    $auth = $conn->query("SELECT a.nickname FROM article_author aa JOIN author a ON aa.author_id = a.id WHERE aa.article_id = $articleId");
    while ($a = $auth->fetch_assoc()) $authors[] = $a['nickname'];
    return $authors;
}

function getCategories($conn, $articleId) {
    $categories = [];
    $cat = $conn->query("SELECT c.name FROM article_category ac JOIN category c ON ac.category_id = c.id WHERE ac.article_id = $articleId");
    while ($c = $cat->fetch_assoc()) $categories[] = $c['name'];
    return $categories;
}
?>

<style>
.search-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

.search-header {
    margin-bottom: 32px;
    padding-bottom: 16px;
    border-bottom: 2px solid #e6e6e6;
}

.search-title {
    font-size: 2rem;
    font-weight: bold;
    color: #000000;
    margin-bottom: 8px;
}

.search-query {
    color: #0066cc;
    font-weight: bold;
}

.search-info {
    font-size: 0.875rem;
    color: #666666;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.search-results {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 24px;
    margin-bottom: 32px;
}

.search-result-item {
    background-color: #ffffff;
    border: 1px solid #e6e6e6;
    padding: 20px;
    transition: border-color 0.2s ease, box-shadow 0.2s ease;
}

.search-result-item:hover {
    border-color: #cccccc;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.result-title {
    font-size: 1.25rem;
    font-weight: bold;
    color: #000000;
    line-height: 1.3;
    margin-bottom: 12px;
    text-decoration: none;
    display: block;
}

.result-title:hover {
    color: #0066cc;
    text-decoration: none;
}

.result-meta {
    font-size: 0.75rem;
    color: #666666;
    margin-bottom: 12px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.result-excerpt {
    font-size: 0.875rem;
    color: #333333;
    line-height: 1.5;
    margin-bottom: 12px;
}

.no-results {
    text-align: center;
    padding: 48px;
    background-color: #f8f9fa;
    border: 1px solid #e6e6e6;
    margin-bottom: 32px;
}

.no-results-icon {
    font-size: 3rem;
    color: #cccccc;
    margin-bottom: 16px;
}

.no-results-title {
    font-size: 1.5rem;
    font-weight: bold;
    color: #333333;
    margin-bottom: 8px;
}

.no-results-text {
    color: #666666;
    font-size: 1rem;
    margin-bottom: 16px;
}

.search-suggestions {
    background-color: #f8f9fa;
    border: 1px solid #e6e6e6;
    padding: 20px;
    margin-bottom: 32px;
}

.suggestions-title {
    font-size: 1.125rem;
    font-weight: bold;
    color: #000000;
    margin-bottom: 12px;
}

.suggestions-list {
    font-size: 0.875rem;
    color: #333333;
    line-height: 1.6;
}

.search-navigation {
    padding: 24px 0;
    border-top: 1px solid #e6e6e6;
    margin-top: 32px;
}

.back-link {
    display: inline-flex;
    align-items: center;
    color: #0066cc;
    text-decoration: none;
    font-weight: 500;
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    transition: color 0.2s ease;
}

.back-link:hover {
    color: #004499;
    text-decoration: none;
}

.back-link::before {
    content: "←";
    margin-right: 8px;
    font-size: 1rem;
}

.main-container {
    display: flex;
    max-width: 1200px;
    margin: 0 auto;
    gap: 32px;
    padding: 20px;
}

.main-content {
    flex: 2;
}

.sidebar-container {
    flex: 1;
    min-width: 300px;
}
</style>

<div class="main-container">
    <div class="main-content">
        <div class="search-container">
            <header class="search-header">
                <h1 class="search-title">
                    Hasil Pencarian: "<span class="search-query"><?= htmlspecialchars($q) ?></span>"
                </h1>
                <div class="search-info">
                    <?= count($articles) ?> artikel ditemukan
                </div>
            </header>

            <?php if (empty($articles)): ?>
                <div class="no-results">
                    <div class="no-results-icon">🔍</div>
                    <h2 class="no-results-title">Tidak ada hasil ditemukan</h2>
                    <p class="no-results-text">
                        Maaf, tidak ada artikel yang cocok dengan pencarian "<strong><?= htmlspecialchars($q) ?></strong>".
                    </p>
                </div>
                
                <div class="search-suggestions">
                    <h3 class="suggestions-title">Saran Pencarian:</h3>
                    <div class="suggestions-list">
                        • Periksa ejaan kata kunci<br>
                        • Gunakan kata kunci yang lebih umum<br>
                        • Coba gunakan sinonim atau kata yang berbeda<br>
                        • Kurangi jumlah kata kunci
                    </div>
                </div>
            <?php else: ?>
                <div class="search-results">
                    <?php foreach ($articles as $article): ?>
                        <article class="search-result-item">
                            <h2>
                                <a href="artikel.php?id=<?= $article['id'] ?>" class="result-title">
                                    <?= htmlspecialchars($article['title']) ?>
                                </a>
                            </h2>
                            
                            <div class="result-meta">
                                <span><?= date('d F Y', strtotime($article['created_at'])) ?></span>
                                <?php 
                                $articleAuthors = getAuthors($conn, $article['id']);
                                if (!empty($articleAuthors)): 
                                ?>
                                    <span> • <?= implode(', ', $articleAuthors) ?></span>
                                <?php endif; ?>
                                <?php 
                                $articleCategories = getCategories($conn, $article['id']);
                                if (!empty($articleCategories)): 
                                ?>
                                    <span> • <?= implode(', ', $articleCategories) ?></span>
                                <?php endif; ?>
                            </div>
                            
                            <div class="result-excerpt">
                                <?= substr(strip_tags($article['content']), 0, 180) ?>...
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <nav class="search-navigation">
                <a href="index.php" class="back-link">Kembali ke Beranda</a>
            </nav>
        </div>
    </div>

    <div class="sidebar-container">
        <?php require_once '../includes/sidebar.php'; ?>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>