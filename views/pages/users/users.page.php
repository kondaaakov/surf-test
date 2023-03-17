<main class="users center">
    <section class="users-first">
        <h1 class="section-title">Пользователи</h1>
        <a href="/users/add" class="section-link">Добавить пользователя</a>
    </section>

    <section class="users-list">
        <table class="users-table table">
            <thead>
                <tr class="users-table-row table-row">
                    <th class="users-table-head table-head">#</th>
                    <th class="users-table-head table-head">ФИО</th>
                    <th class="users-table-head table-head">Почта</th>
                    <th class="users-table-head table-head">Группа</th>
                    <th class="users-table-head table-head">Дата регистрации</th>
                    <th class="users-table-head table-head"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                <tr class="users-table-row table-row table-row-not-head">
                    <td class="users-table-cell table-cell"><?= $user['id'] ?></td>
                    <td class="users-table-cell table-cell"><?= $user['surname'] ?> <?= $user['name'] ?></td>
                    <td class="users-table-cell table-cell"><?= $user['mail'] ?></td>
                    <td class="users-table-cell table-cell"><?= $user['title'] ?></td>
                    <td class="users-table-cell table-cell"><?= $user['created_date'] ?></td>
                    <td class="users-table-cell table-cell table-cell-actions">
                        <a href="/users/edit/<?= $user['id'] ?>" title="Редактировать" class="table-link-action">✏️</a>
                        <a href="/users/delete/<?= $user['id'] ?>" title="Удалить" class="table-link-action">🗑️</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>
</main>