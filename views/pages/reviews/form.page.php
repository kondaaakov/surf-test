<main class="basicForm center">

    <section class="basicForm-container">
        <h1 class="basicForm-title">
            <?= isset($spot) ? "Проверка Surf Coffee® x {$spot['name']}" : "Редактирование проверки #{$review['id']}" ?>
        </h1>
        <form method="post" class="basicForm-form">
            <?php if (!isset($review)): ?>
            <input type="hidden" name="user_id" value="<?= $userId ?>">
            <?php endif; ?>

            <?php if (isset($review)): ?>

                <select name="spot_id" id="spot_id" class="basicForm-input">
                    <option value="" disabled>Выбрать кофейню</option>
                    <?php foreach ($spots as $spotFromList): ?>
                        <option <?= $spotFromList['id'] == $review['spot_id'] ? 'selected' : '' ?> value="<?= $spotFromList['id'] ?>">
                            Surf Coffee® x <?= $spotFromList['name'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>

            <?php else: ?>
                <input type="hidden" name="spot_id" value="<?= isset($spot) ? $spot['id'] : $review['spot_id'] ?>">
            <?php endif ?>

            <?php foreach (QUESTIONS as $block): ?>
                <h3 class="basicForm-form-title"><?= $block['title'] ?></h3>

                <?php foreach ($block['questions'] as $field => $title): ?>
                    <label for="<?= $field ?>" class="basicForm-label"><?= $title ?></label>
                    <input class="basicForm-input" required name="<?= $field ?>" id="<?= $field ?>" value="<?= isset($review) ? $review[$field] : '' ?>" type="number" max="5" min="1" placeholder="Оцените от 1 до 5">
                <?php endforeach; ?>
            <?php endforeach; ?>

            <button type="submit" class="basicForm-btn"><?= isset($spot) ? "Готово" : 'Редактировать' ?></button>
        </form>
    </section>

</main>