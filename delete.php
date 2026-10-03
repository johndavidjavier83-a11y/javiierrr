<?php require 'config.php'; need();
$s = $pdo->prepare('SELECT * FROM works WHERE id=?'); $s->execute([(int)($_POST['id'] ?? 0)]);
if ($w = $s->fetch()) {
    @unlink(__DIR__.'/uploads/works/'.basename($w['filename']));
    $pdo->prepare('DELETE FROM works WHERE id=?')->execute([$w['id']]);
}
header('Location: index.php#'.($w['category'] ?? 'works'));
