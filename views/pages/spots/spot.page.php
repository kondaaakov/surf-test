<main class="spots center">
    <section class="spots-first">
        <h1 class="section-title">Обзор Surf Coffee® x  <?= $spot['name'] ?></h1>
    </section>

    <section class="filter">
        <form method="get" class="filter-form">
            <div class="filter-form-body">
                <select name="by_spot" id="by_spot" class="filter-select">
                    <option value="">Выбрать кофейню</option>
                    <?php foreach ($spots as $spotFromList): ?>
                        <option <?= isset($_GET['by_spot']) && $_GET['by_spot'] == $spotFromList['id'] ? 'selected' : '' ?> value="<?= $spotFromList['id'] ?>">
                            Surf Coffee® x <?= $spotFromList['name'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="filter-form-actions">
                <button class="filter-start">Фильтровать</button>
                <a href="./spots" class="filter-end">Отмена</a>
            </div>
        </form>
    </section>



    <?php if (isset($reviews) && !empty($reviews)): ?>

        <section class="spot-avg">
            <h3 class="section-title">Средняя оценка спота</h3>
            <div class="spot-avg-container">
                <?= $pages->averageElement($spot['id']) ?>
            </div>
        </section>

        <section class="spot-reviews">
            <h3 class="section-title">Проверки спота</h3>

            <table class="table">
                <thead>
                <tr class="table-row">
                    <th class="table-head">#</th>
                    <th class="table-head">Дата проверки</th>
                    <th class="table-head">Пользователь</th>
                    <th class="table-head">Спот</th>
                    <th class="table-head">Средняя оценка</th>
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
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </section>

        <section class="spot-chart">
            <canvas id="chart"></canvas>
        </section>

    <?php else: ?>
        <section class="spot-noData">
            <h2 class="section-title">Нет данных о проверках спота</h2>
        </section>
    <?php endif; ?>
</main>

<?php

if (isset($reviews) && !empty($reviews)) {
    $dates = [];
    $points = [];
    foreach ($reviews as $review) {
        $date = new DateTime($review['created_date']);

        $dates[] = $date->format("d.m.Y");
        $points[] = $review['average'];
    }

    $dates = json_encode($dates);
    $points = json_encode($points);
}

?>

<?php if (isset($reviews) && !empty($reviews)): ?>
    <script>
        const ctx = document.getElementById('chart');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?= $dates ?>,
                datasets: [{
                    label: 'Оценка',
                    data: <?= $points ?>,
                    borderWidth: 3,
                    borderColor: 'rgb(0, 0, 0)',
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
<?php endif; ?>
