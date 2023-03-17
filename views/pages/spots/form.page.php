<main class="spotsForm center">

    <section class="spotsForm-container">
        <h1 class="spotsForm-title">
            <?= isset($spot) ? "Редактировать Surf Coffee® x {$spot['name']}" : 'Добавление новой кофейни' ?>
        </h1>

        <form method="post" class="spotsForm-form">
            <input class="spotsForm-input" value="<?= isset($spot) ? $spot['name'] : '' ?>" required name="name" id="name" type="text" placeholder="Название кофейни">

            <select class="spotsForm-input" required name="city_id" id="city">

                <?php if(isset($spot)): ?>
                    <option value="0" disabled>Выбрать город</option>
                    <?php foreach ($cities as $city): ?>
                        <option value="<?= $city['id'] ?>" <?= $spot['city_id'] === $city['id'] ? 'selected' : '' ?> >
                            <?= $city['text'] ?>
                        </option>
                    <?php endforeach; ?>
                <?php else: ?>
                    <option value="0" disabled selected>Выбрать город</option>
                    <?php foreach ($cities as $city): ?>
                        <option value="<?= $city['id'] ?>">
                            <?= $city['text'] ?>
                        </option>
                    <?php endforeach; ?>
                <?php endif; ?>

            </select>

            <button type="submit" class="spotsForm-btn"><?= isset($spot) ? "Редактировать" : 'Создать' ?></button>
        </form>
    </section>
</main>