<?php
require_once '../config/database.php';
require_once '../includes/header.php';

// Get category ID from URL
$categoryId = $_GET['id'] ?? 0;

// Get category information
$stmt = $conn->prepare("SELECT name FROM category WHERE id = ?");
$stmt->bind_param("i", $categoryId);
$stmt->execute();
$categoryResult = $stmt->get_result();
$category = $categoryResult->fetch_assoc();

if (!$category) {
    die("Kategori tidak ditemukan");
}

// Get articles in this category
$stmt = $conn->prepare("
    SELECT DISTINCT a.* 
    FROM article a 
    JOIN article_category ac ON a.id = ac.article_id 
    WHERE ac.category_id = ? AND a.status = 'published' 
    ORDER BY a.created_at DESC
");
$stmt->bind_param("i", $categoryId);
$stmt->execute();
$result = $stmt->get_result();
$articles = $result->fetch_all(MYSQLI_ASSOC);

function getAuthors($conn, $articleId)
{
    $authors = [];
    $auth = $conn->query("SELECT a.nickname FROM article_author aa JOIN author a ON aa.author_id = a.id WHERE aa.article_id = $articleId");
    while ($a = $auth->fetch_assoc()) $authors[] = $a['nickname'];
    return $authors;
}

function getCategories($conn, $articleId)
{
    $categories = [];
    $cat = $conn->query("SELECT c.name FROM article_category ac JOIN category c ON ac.category_id = c.id WHERE ac.article_id = $articleId");
    while ($c = $cat->fetch_assoc()) $categories[] = $c['name'];
    return $categories;
}
?>

<style>
    .category-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    .category-header {
        margin-bottom: 32px;
        padding-bottom: 16px;
        border-bottom: 2px solid #e6e6e6;
    }

    .category-title {
        font-size: 2rem;
        font-weight: bold;
        color: #000000;
        margin-bottom: 8px;
    }

    .category-name {
        color: #002B5B;
        font-weight: bold;
    }

    .category-info {
        font-size: 0.875rem;
        color: #666666;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .articles-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 24px;
        margin-bottom: 32px;
    }

    .article-card {
        background-color: #ffffff;
        border: 1px solid #e6e6e6;
        padding: 20px;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .article-card:hover {
        border-color: #cccccc;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .article-title {
        font-size: 1.25rem;
        font-weight: bold;
        color: #000000;
        line-height: 1.3;
        margin-bottom: 12px;
        text-decoration: none;
        display: block;
    }

    .article-title:hover {
        color: #002B5B;
        text-decoration: none;
    }

    .article-meta {
        font-size: 0.75rem;
        color: #666666;
        margin-bottom: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .article-excerpt {
        font-size: 0.875rem;
        color: #333333;
        line-height: 1.5;
        margin-bottom: 12px;
    }

    .no-articles {
        text-align: center;
        padding: 48px;
        background-color: #f8f9fa;
        border: 1px solid #e6e6e6;
        margin-bottom: 32px;
    }

    .no-articles-icon {
        font-size: 3rem;
        color: #cccccc;
        margin-bottom: 16px;
    }

    .no-articles-title {
        font-size: 1.5rem;
        font-weight: bold;
        color: #333333;
        margin-bottom: 8px;
    }

    .no-articles-text {
        color: #666666;
        font-size: 1rem;
    }

    .category-navigation {
        padding: 24px 0;
        border-top: 1px solid #e6e6e6;
        margin-top: 32px;
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        color: #EA5455;
        text-decoration: none;
        font-weight: 500;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: color 0.2s ease;
    }

    .back-link:hover {
        color: #EA5455;
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
        <div class="category-container">
            <header class="category-header">
                <h1 class="category-title">
                    Kategori: <span class="category-name"><?= htmlspecialchars($category['name']) ?></span>
                </h1>
                <div class="category-info">
                    <?= count($articles) ?> artikel ditemukan
                </div>
            </header>

            <?php if (empty($articles)): ?>
                <div class="no-articles">
                    <h2 class="no-articles-title">Belum ada artikel</h2>
                    <p class="no-articles-text">
                        Belum ada artikel yang tersedia dalam kategori "<strong><?= htmlspecialchars($category['name']) ?></strong>".
                    </p>
                </div>
            <?php else: ?>
                <div class="articles-grid">
                    <?php foreach ($articles as $article): ?>
                        <article class="article-card">
                            <h2>
                                <a href="artikel.php?id=<?= $article['id'] ?>" class="article-title">
                                    <?= htmlspecialchars($article['title']) ?>
                                </a>
                            </h2>

                            <div class="article-meta">
                                <span><?= date('d F Y', strtotime($article['created_at'])) ?></span>
                                <?php
                                $articleAuthors = getAuthors($conn, $article['id']);
                                if (!empty($articleAuthors)):
                                ?>
                                    <span> • <?= implode(', ', $articleAuthors) ?></span>
                                <?php endif; ?>
                            </div>

                            <div class="article-excerpt">
                                <?= substr(strip_tags($article['content']), 0, 180) ?>...
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <nav class="category-navigation">
                <a href="index.php" class="back-link">Kembali ke Beranda</a>
            </nav>
        </div>
    </div>

    <div class="sidebar-container">
        <?php require_once '../includes/sidebar.php'; ?>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>