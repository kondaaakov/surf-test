<main class="show center">
    <section class="show-header">
        <h1 class="section-title">Просмотр проверки #<?= $review['id'] ?></h1>
    </section>

    <section class="show-data">
        <table class="showData-table">
            <tr class="showData-row">
                <td class="showData-title">
                    ID проверки
                </td>
                <td class="showData-data">
                    <?= $review['id'] ?>
                </td>
            </tr>

            <tr class="showData-row">
                <td class="showData-title">
                    Дата проверки
                </td>
                <td class="showData-data">
                    <?= $pages->normalizeDate($review['created_date']) ?>
                </td>
            </tr>

            <tr class="showData-row">
                <td class="showData-title">
                    Проверяющий
                </td>
                <td class="showData-data">
                    <?= DB::getFullNameUser($review['user_id']) ?>
                </td>
            </tr>

            <tr class="showData-row">
                <td class="showData-title">
                    Спот
                </td>
                <td class="showData-data">
                    Surf Coffee® x <?= $review['name'] ?>
                </td>
            </tr>

            <tr class="showData-row">
                <td class="showData-title">
                    Средняя оценка
                </td>
                <td class="showData-data">
                     <?= $pages->averageElement(0, $review['average']) ?>
                </td>
            </tr>

            <tr class="showData-row">
                <td class="showData-title">
                    Ответы
                </td>
                <td class="showData-data showData-data-answers">
                    <?php foreach (QUESTIONS as $block): ?>
                    <h3 class="inShowData-table-title"><?= $block['title'] ?></h3>
                    <table class="inShowData-table">
                        <?php foreach ($block['questions'] as $field => $title): ?>
                            <tr class="inShowData-row">
                                <td class="inShowData-title"><?= $title ?></td>
                                <td class="inShowData-data"><?= $review[$field] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                    <?php endforeach; ?>
                </td>
            </tr>
        </table>
    </section>
</main>