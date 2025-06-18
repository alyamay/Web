<?php
require_once '../config/database.php';
require_once '../includes/header.php';

$stmt = $conn->prepare("SELECT * FROM article WHERE status = 'published' ORDER BY created_at DESC");
$stmt->execute();
$result = $stmt->get_result();
$articles = $result->fetch_all(MYSQLI_ASSOC);

$headline = array_shift($articles);
$otherArticles = $articles;

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
    .headline-article {
        background-color: #EA5455;
        border: 1px solid #e6e6e6;
        margin-bottom: 32px;
        overflow: hidden;
    }

    .headline-article img {
        width: 100%;
        height: 300px;
        object-fit: cover;
        display: block;
    }

    .headline-content {
        padding: 24px;
    }

    .headline-title {
        font-size: 2rem;
        font-weight: bold;
        color: #002B5B;
        line-height: 1.2;
        margin-bottom: 12px;
        text-decoration: none;
    }

    .headline-title:hover {
        color: #002B5B;
        text-decoration: none;
    }

    .headline-meta {
        font-size: 0.75rem;
        color: #F9F5EB;
        margin-bottom: 16px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .headline-excerpt {
        font-size: 1rem;
        color: #F9F5EB;
        line-height: 1.6;
        margin-bottom: 16px;
    }

    .article-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
        margin-top: 32px;
    }

    .article-card {
        background-color: #F5E9CF;
        border: 1px solid #e6e6e6;
        overflow: hidden;
        transition: border-color 0.2s ease;
    }

    .article-card:hover {
        border-color: #cccccc;
    }

    .article-card img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        display: block;
    }

    .article-card-content {
        padding: 16px;
    }

    .article-title {
        font-size: 1.125rem;
        font-weight: bold;
        color: #000000;
        line-height: 1.3;
        margin-bottom: 8px;
        text-decoration: none;
        display: block;
    }

    .article-title:hover {
        color: #0066cc;
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
    }

    .no-articles {
        text-align: center;
        padding: 48px;
        color: #666666;
        font-size: 1.125rem;
    }
</style>

<div class="main-container">
    <div class="main-content">
        <?php if (empty($articles) && !$headline): ?>
            <div class="no-articles">
                <p>Belum ada artikel yang tersedia.</p>
            </div>
        <?php else: ?>

            <?php if ($headline): ?>
                <article class="headline-article">
                    <?php if ($headline['picture']): ?>
                        <img src="../assets/images/<?= htmlspecialchars($headline['picture']) ?>" alt="<?= htmlspecialchars($headline['title']) ?>">
                    <?php endif; ?>

                    <div class="headline-content">
                        <h1><a href="artikel.php?id=<?= $headline['id'] ?>" class="headline-title">
                                <?= htmlspecialchars($headline['title']) ?>
                            </a></h1>

                        <div class="headline-meta">
                            <span><?= date('d F Y', strtotime($headline['created_at'])) ?></span>
                            <?php
                            $headlineAuthors = getAuthors($conn, $headline['id']);
                            if (!empty($headlineAuthors)):
                            ?>
                                <span> • <?= implode(', ', $headlineAuthors) ?></span>
                            <?php endif; ?>
                            <?php
                            $headlineCategories = getCategories($conn, $headline['id']);
                            if (!empty($headlineCategories)):
                            ?>
                                <span> • <?= implode(', ', $headlineCategories) ?></span>
                            <?php endif; ?>
                        </div>

                        <div class="headline-excerpt">
                            <?= substr(strip_tags($headline['content']), 0, 200) ?>...
                        </div>
                    </div>
                </article>
            <?php endif; ?>

            <?php if (!empty($otherArticles)): ?>
                <div class="article-grid">
                    <?php foreach ($otherArticles as $article): ?>
                        <article class="article-card">
                            <?php if ($article['picture']): ?>
                                <img src="../assets/images/<?= htmlspecialchars($article['picture']) ?>" alt="<?= htmlspecialchars($article['title']) ?>">
                            <?php endif; ?>

                            <div class="article-card-content">
                                <h2><a href="artikel.php?id=<?= $article['id'] ?>" class="article-title">
                                        <?= htmlspecialchars($article['title']) ?>
                                    </a></h2>

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
                                    <?= substr(strip_tags($article['content']), 0, 150) ?>...
                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

        <?php endif; ?>
    </div>

    <div class="sidebar-container">
        <?php require_once '../includes/sidebar.php'; ?>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>