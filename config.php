<?php
session_start();
$pdo = new PDO('mysql:host=localhost;dbname=jd_portfolio;charset=utf8mb4', 'root', '', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
]);
const CATS = ['quiz'=>['Quiz','📝'],'longquiz'=>['Long Quiz','📚'],'midterms'=>['Midterms','🎯'],
              'finals'=>['Finals','🏆'],'activity'=>['Activity','⚡'],'project'=>['Project','🚀']];
const IMG_EXT = ['jpg','jpeg','png','gif','webp'];
const FILE_EXT = ['pdf','doc','docx','ppt','pptx','xls','xlsx','zip','txt'];
function h($s){ return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
function isAdmin(){ return !empty($_SESSION['admin']); }
function csrf(){ return $_SESSION['t'] ??= bin2hex(random_bytes(16)); }
function need(){
    if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isAdmin() || !hash_equals(csrf(), $_POST['t'] ?? '')) {
        http_response_code(403); exit('Forbidden');
    }
}
function saveUpload($f, $dir, $allowed){
    if ($f['error'] !== UPLOAD_ERR_OK || $f['size'] > 20*1024*1024) return null;
    $ext = strtolower(pathinfo($f['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowed, true)) return null;
    $name = bin2hex(random_bytes(12)) . '.' . $ext;
    return move_uploaded_file($f['tmp_name'], __DIR__."/uploads/$dir/$name") ? [$name, $ext] : null;
}
