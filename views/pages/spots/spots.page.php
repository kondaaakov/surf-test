<main class="spots center">
    <section class="spots-first">
        <h1 class="section-title">Обзор кофеен</h1>
        <a href="/spots/add" class="section-link">Добавить кофейню</a>
    </section>

    <section class="filter">
        <form method="get" class="filter-form">
            <div class="filter-form-body">
                <select name="by_spot" id="by_spot" class="filter-select">
                    <option value="">Выбрать кофейню</option>
                    <?php foreach ($spots as $spot): ?>
                        <option value="<?= $spot['id'] ?>">Surf Coffee® x <?= $spot['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="filter-form-actions">
                <button class="filter-start">Фильтровать</button>
                <a href="./spots" class="filter-end">Отмена</a>
            </div>

        </form>
    </section>

    <section class="spots-list">
        <?php foreach ($spots as $spot): ?>
            <div class="spot">
                <div class="spot-header">
                    <div class="spot-header-left">
                        <h2 class="spot-title">Surf Coffee® x <?= $spot['name'] ?></h2>
                        <p class="spot-location"><?= $spot['country'] ?>, <?= $spot['city'] ?></p>
                    </div>

                    <a href="/spots/edit/<?= $spot['id'] ?>" class="spot-header-right">✏️</a>
                </div>

                <div class="spot-body">
                    <p class="spot-mark">Средняя оценка спота: <?= $pages->averageElement($spot['id']) ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </section>
</main>