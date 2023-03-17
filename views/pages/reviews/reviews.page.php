<main class="reviews center">
    <section class="reviews-first">
        <h1 class="section-title"><?= $user->getGroupSession() === 'ADMIN' ? 'Проверки' : 'Мои проверки' ?></h1>
    </section>

    <section class="reviews-list">
        <table class="table">
            <thead>
            <tr class="table-row">
                <th class="table-head">#</th>
                <th class="table-head">Дата проверки</th>
                <th class="table-head">Пользователь</th>
                <th class="table-head">Спот</th>
                <th class="table-head">Средняя оценка</th>
                <th class="table-head"></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($reviews as $review): ?>
                <tr class="table-row table-row-not-head">
                    <td class="table-cell"><?= $review['id'] ?></td>
                    <td class="table-cell"><?= $pages->normalizeDate($review['created_date']) ?></td>
                    <td class="table-cell"><?= DB::getFullNameUser($review['user_id']) ?></td>
                    <td class="table-cell">Surf Coffee® x <?= $review['name'] ?></td>
                    <td class="table-cell"><?= $pages->normalizeAvg($review['average']) ?></td>
                    <td class="table-cell table-cell-actions">
                        <a href="/reviews/edit/<?= $review['id'] ?>" title="Редактировать" class="table-link-action">✏️</a>
                        <a href="/reviews/show/<?= $review['id'] ?>" target="_blank" title="Посмотреть" class="table-link-action">👁️</a>
                        <a href="/reviews/delete/<?= $review['id'] ?>" title="Удалить" class="table-link-action">🗑️</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </section>
</main>