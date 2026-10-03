<?php require 'config.php'; need();
$p = $pdo->query('SELECT * FROM profile WHERE id=1')->fetch();
$img = $p['image'];
if (!empty($_FILES['image']['name']) && ($r = saveUpload($_FILES['image'], 'profile', IMG_EXT))) {
    if ($img) @unlink(__DIR__.'/uploads/profile/'.basename($img));
    $img = $r[0];
}
$pdo->prepare('UPDATE profile SET name=?, bio=?, image=? WHERE id=1')
    ->execute([mb_substr(trim($_POST['name'] ?? ''),0,100), trim($_POST['bio'] ?? ''), $img]);
header('Location: index.php');
