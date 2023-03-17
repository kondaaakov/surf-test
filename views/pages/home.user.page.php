<main class="userHome center">
    <section class="userHome-first">
        <?= $pages->welcomeMessageInspector() ?>
    </section>

    <section class="userHome-second">
        <h3 class="section-title">Выбери кофейню</h3>

        <div class="userHome-second-spots">
            <?php foreach ($spots as $spot): ?>
                <a href="/reviews/add/<?= $spot['id'] ?>" class="userHome-second-spot">Surf Coffee® x <?= $spot['name'] ?></a>
            <?php endforeach; ?>
        </div>
    </section>
</main>