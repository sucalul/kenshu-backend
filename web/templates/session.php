<?php if(isset($_SESSION['EMAIL'])): ?>
    <p>こんにちは<?= htmlspecialchars($_SESSION['EMAIL'], ENT_QUOTES, "UTF-8") ?>さん</p>
<?php endif; ?>
