<?php require 'config.php';
$p = $pdo->query('SELECT * FROM profile WHERE id=1')->fetch();
$works = []; foreach ($pdo->query('SELECT * FROM works ORDER BY id DESC') as $w) $works[$w['category']][] = $w;
$admin = isAdmin(); $avatar = $p['image'] ? 'uploads/profile/'.h($p['image']) : 'data:image/svg+xml,'.rawurlencode('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 10 10"><rect width="10" height="10" fill="#0b111c"/><text x="5" y="6.6" font-size="4.5" text-anchor="middle" fill="#168cff">JD</text></svg>');
?><!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title><?= h($p['name']) ?> | Academic Portfolio</title><link rel="stylesheet" href="assets/style.css"></head><body>
<div id="loader"><div class="loader-circle"></div><h2>LOADING</h2></div>
<header class="navbar"><div class="logo"><?= h($p['name']) ?><span>.</span></div>
<button class="menu-btn" id="menuBtn">☰</button>
<nav id="nav"><a href="#home">Home</a><a href="#works">Works</a>
<?php if ($admin): ?><a href="#" id="editProfileBtn">Edit Profile</a><a href="logout.php">Logout</a><?php else: ?><a href="login.php">Admin</a><?php endif ?></nav></header>

<section class="hero" id="home"><div class="hero-content">
<div class="hero-text"><p class="small-title">ACADEMIC PORTFOLIO</p>
<h1>Hi, I'm <span><?= h($p['name']) ?></span></h1>
<p class="hero-description"><?= nl2br(h($p['bio'])) ?></p>
<div class="hero-buttons"><a href="#works" class="primary-btn">View My Works</a></div></div>
<div class="profile-container"><div class="profile-glow"></div><img class="profile-image" src="<?= $avatar ?>" alt="Profile"></div>
</div></section>

<?php if ($admin): ?>
<div class="modal" id="profileModal"><form class="modal-box" method="post" action="profile.php" enctype="multipart/form-data">
<h3>Edit Profile</h3><input type="hidden" name="t" value="<?= csrf() ?>">
<input name="name" value="<?= h($p['name']) ?>" placeholder="Name" required>
<textarea name="bio" rows="4" placeholder="Bio"><?= h($p['bio']) ?></textarea>
<label class="file-pick">Change photo<input type="file" name="image" accept="image/*"></label>
<div class="row"><button class="primary-btn">Save</button><button type="button" class="secondary-btn" id="closeModal">Cancel</button></div></form></div>
<?php endif ?>

<section class="section" id="works"><div class="section-title"><p>MY WORKS</p><h2>Academic <span>Records</span></h2>
<small><?= $admin ? 'Admin mode: you can upload and delete.' : 'View only' ?></small></div>
<div class="category-grid">
<?php foreach (CATS as $key => [$label, $icon]): $items = $works[$key] ?? []; ?>
<article class="category-card reveal" id="<?= $key ?>">
<div class="category-icon"><?= $icon ?></div><h3><?= $label ?></h3><p><?= count($items) ?> item(s)</p>
<?php if ($admin): ?>
<form class="upload-form" method="post" action="upload.php" enctype="multipart/form-data">
<input type="hidden" name="t" value="<?= csrf() ?>"><input type="hidden" name="category" value="<?= $key ?>">
<input name="title" placeholder="Title" required>
<label class="file-pick"><span>Choose image / file</span><input type="file" name="file" required></label>
<button class="primary-btn">Upload</button></form>
<?php endif ?>
<div class="file-list">
<?php foreach ($items as $w): $url = 'uploads/works/'.h($w['filename']); ?>
<div class="file-item">
<?php if ($w['type'] === 'image'): ?><img class="thumb zoom" src="<?= $url ?>" alt="<?= h($w['title']) ?>"><?php else: ?><div class="thumb doc">📄</div><?php endif ?>
<div class="file-info"><strong><?= h($w['title']) ?></strong><small><?= h($w['original']) ?></small></div>
<a class="file-btn" href="<?= $url ?>" <?= $w['type']==='image' ? 'target="_blank"' : 'download="'.h($w['original']).'"' ?>><?= $w['type']==='image' ? 'View' : 'Download' ?></a>
<?php if ($admin): ?><form method="post" action="delete.php" class="del"><input type="hidden" name="t" value="<?= csrf() ?>"><input type="hidden" name="id" value="<?= $w['id'] ?>"><button class="file-btn red">✕</button></form><?php endif ?>
</div>
<?php endforeach; if (!$items): ?><p class="empty">Nothing uploaded yet.</p><?php endif ?>
</div></article>
<?php endforeach ?>
</div></section>
<footer><div class="footer-logo"><?= h($p['name']) ?></div><p>Academic Portfolio</p></footer>
<div class="lightbox" id="lightbox"><img alt=""></div>
<script src="assets/script.js"></script></body></html>
