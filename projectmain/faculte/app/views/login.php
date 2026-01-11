<?php
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login - Gestion Faculté</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="container">
        <div class="login-box">
            <h1>Connexion</h1>
            
            <?php if ($error): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" required>
                </div>
                <div class="form-group">
                    <label>Mot de passe</label>
                    <input type="password" name="password" required>
                </div>
                <button type="submit" class="btn">Connexion</button>
            </form>
            
            <p>Pas encore inscrit? <a href="?page=register">S'inscrire</a></p>
        </div>
    </div>
</body>
</html>
