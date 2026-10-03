<?php require 'config.php';
$first = $pdo->query('SELECT COUNT(*) c FROM admins')->fetch()['c'] == 0;
$err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $u = trim($_POST['username'] ?? ''); $p = $_POST['password'] ?? '';
    if ($first) {
        if ($u !== '' && strlen($p) >= 8) {
            $pdo->prepare('INSERT INTO admins(username,password) VALUES(?,?)')->execute([$u, password_hash($p, PASSWORD_DEFAULT)]);
            session_regenerate_id(true); $_SESSION['admin'] = 1; header('Location: index.php'); exit;
        }
        $err = 'Username required, password at least 8 characters.';
    } else {
        $s = $pdo->prepare('SELECT * FROM admins WHERE username=?'); $s->execute([$u]); $a = $s->fetch();
        if ($a && password_verify($p, $a['password'])) {
            session_regenerate_id(true); $_SESSION['admin'] = 1; header('Location: index.php'); exit;
        }
        $err = 'Wrong username or password.';
    }
}?>
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Admin Login</title><link rel="stylesheet" href="assets/style.css"></head>
<body class="login-body"><form method="post" class="login-card reveal show">
<h2><?= $first ? 'Create Admin Account' : 'Admin Login' ?></h2>
<?php if ($err): ?><p class="err"><?= h($err) ?></p><?php endif ?>
<input name="username" placeholder="Username" required><input name="password" type="password" placeholder="Password" required>
<button class="primary-btn"><?= $first ? 'Create' : 'Login' ?></button><a href="index.php" class="back">← Back to portfolio</a></form></body></html>
