<main class="users center">
    <section class="users-first">
        <h1 class="section-title">Пользователи</h1>
        <a href="/users/add" class="section-link">Добавить пользователя</a>
    </section>

    <section class="users-list">
        <table class="users-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>ФИО</th>
                    <th>Почта</th>
                    <th>Группа</th>
                    <th>Дата регистрации</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= $user['id'] ?></td>
                    <td><?= $user['surname'] ?> <?= $user['name'] ?></td>
                    <td><?= $user['mail'] ?></td>
                    <td><?= $user['created_date'] ?></td>
                    <td><?= $user['title'] ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>
</main>