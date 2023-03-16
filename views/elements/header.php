<header class="header center">
    <a href="/" class="logo">Surf Coffee Panel</a>

    <nav class="header-nav">
        <?php if($user->getGroupSession() === 'ADMIN'): ?>
            <a href="/spots" class="header-link">Кофейни</a>
            <a href="/users" class="header-link">Пользователи</a>
        <?php endif; ?>

        <a href="/logout" class="header-link">Выход</a>
    </nav>
</header>
