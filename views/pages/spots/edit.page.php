<main class="spotsForm center">

    <section class="spotsForm-container">
        <h1 class="spotsForm-title">Добавление новой кофейни</h1>
        <form method="post" class="spotsForm-form">
            <input class="spotsForm-input" value="<?= $spot['name'] ?>" required name="name" id="name" type="text" placeholder="Название кофейни">

            <select class="spotsForm-input" required name="city_id" id="city">
                <option value="0" disabled>Выбрать город</option>
                <?php foreach ($cities as $city): ?>
                    <option value="<?= $city['id'] ?>" <?= $spot['city_id'] === $city['id'] ? 'selected' : '' ?> >
                        <?= $city['text'] ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <button type="submit" class="spotsForm-btn">Создать</button>
        </form>
    </section>
</main>