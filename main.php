<?php
// main.php — simple home page for your varsity assignment
// Changes requested:
// 1) Remove "(Just for Fun)" from the title
// 2) Replace "Friendly (and funny)" with "Suggestion"
// 3) Use easy words
// 4) This file replaces index.php (rename your old index.php to main.php or use this file)

function humanize($filename) {
    $name = preg_replace('/\.php$/i', '', $filename);
    $name = str_replace(['-', '_'], ' ', $name);
    return ucwords($name);
}

$allPhp = glob('*.php') ?: [];
$exclude = ['main.php', 'config.php'];
$pages = array_values(array_filter($allPhp, fn($f) => !in_array($f, $exclude, true)));
sort($pages);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Cloud Assignment</title> <!-- removed "(Just for Fun)" -->
  <style>
    :root { color-scheme: light dark; }
    body { font-family: system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif; margin: 0; padding: 0; }
    header { background: #0e7afe; color: #fff; padding: 24px 16px; }
    main { padding: 20px 16px 40px; max-width: 900px; margin: 0 auto; }
    h1 { margin: 0 0 6px; font-size: 28px; }
    p.lead { margin: 6px 0 0; opacity: .95; }
    .card { background: #fff; border: 1px solid #e6e6e6; border-radius: 12px; padding: 16px; margin: 14px 0; box-shadow: 0 1px 2px rgba(0,0,0,.04); }
    .card h2 { margin: 0 0 8px; font-size: 20px; }
    ul.links { list-style: none; padding: 0; margin: 0; display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 10px; }
    ul.links li a { display: block; padding: 10px 12px; border: 1px solid #e6e6e6; border-radius: 10px; text-decoration: none; color: inherit; background: #fafafa; }
    ul.links li a:hover { border-color: #0e7afe; background: #f0f6ff; }
    .muted { color: #666; font-size: 14px; }
    footer { text-align: center; padding: 24px; color: #666; }
    @media (prefers-color-scheme: dark) {
      .card, ul.links li a { background: #111; border-color: #222; }
      body { background: #000; color: #eee; }
      header { background: #0e63cc; }
      ul.links li a:hover { background: #0b1e35; border-color: #3a86ff; }
      .muted { color: #aaa; }
    }
  </style>
</head>
<body>
  <header>
    <h1>Cloud Assignment</h1>
    <p class="lead">Simple PHP pages for my varsity work.</p>
  </header>

  <main>
    <div class="card">
      <h2>Suggestion</h2> <!-- replaced "Friendly (and funny)" with "Suggestion" -->
      <ul>
        <li>Open a page from the list below.</li>
        <li>Read what it asks. Use simple test data.</li>
        <li>If a page needs a database, set your DB info in the right config file.</li>
        <li>If something breaks, check file paths and error logs.</li>
      </ul>
    </div>

    <div class="card">
      <h2>Pages</h2>
      <?php if (empty($pages)): ?>
        <p class="muted">No other PHP pages found in this folder.</p>
      <?php else: ?>
        <ul class="links">
          <?php foreach ($pages as $file): ?>
            <li><a href="<?= htmlspecialchars($file) ?>"><?= htmlspecialchars(humanize($file)) ?></a></li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>
      <p class="muted" style="margin-top:12px;">Tip: If your old home page was <code>index.php</code>, it’s now <code>main.php</code>. Update any links that still point to <code>index.php</code>.</p>
    </div>

    <div class="card">
      <h2>Notes</h2>
      <p>
        This page uses easy words on purpose. Keep each task clear and short.  
        If your teacher wants a different title, edit the <code>&lt;title&gt;</code> above.
      </p>
      <p class="muted">Last updated: <?= date('Y-m-d H:i') ?></p>
    </div>
  </main>

  <footer>
    <small class="muted">&copy; <?= date('Y') ?> Cloud Assignment</small>
  </footer>
</body>
</html>
