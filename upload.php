<?php require 'config.php'; need();
$cat = $_POST['category'] ?? ''; $title = trim($_POST['title'] ?? '');
if (isset(CATS[$cat]) && $title !== '' && isset($_FILES['file'])) {
    $r = saveUpload($_FILES['file'], 'works', array_merge(IMG_EXT, FILE_EXT));
    if ($r) {
        $type = in_array($r[1], IMG_EXT, true) ? 'image' : 'file';
        $pdo->prepare('INSERT INTO works(category,title,filename,original,type) VALUES(?,?,?,?,?)')
            ->execute([$cat, mb_substr($title,0,150), $r[0], mb_substr(basename($_FILES['file']['name']),0,255), $type]);
    }
}
header("Location: index.php#$cat");
