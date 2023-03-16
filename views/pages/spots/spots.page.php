<main class="spots center">
    <section class="spots-first">
        <h1 class="section-title">Обзор кофеен</h1>
        <a href="/spots/add" class="section-link">Добавить кофейню</a>
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
                    <p class="spot-mark">Средняя оценка спота: <span class="spot-int">8.3</span></p>
                </div>
            </div>
        <?php endforeach; ?>
    </section>
</main>