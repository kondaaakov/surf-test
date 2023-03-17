<main class="basicForm center">

    <section class="basicForm-container">
        <h1 class="basicForm-title">
            <?= isset($userDB) ? "Редактирование пользователя {$userDB['name']}" : 'Добавление нового пользователя' ?>
        </h1>
        <form method="post" class="basicForm-form">
            <input class="basicForm-input" required name="name" id="name" type="text" placeholder="Имя" value="<?= $userDB['name'] ?? '' ?>">
            <input class="basicForm-input" required name="surname" id="surname" type="text" value="<?= $userDB['surname'] ?? '' ?>" placeholder="Фамилия">
            <input class="basicForm-input" required name="patronymic" id="patronymic" type="text" value="<?= $userDB['patronymic'] ?? '' ?>" placeholder="Отчество">
            <input class="basicForm-input" required name="mail" id="mail" type="email" value="<?= $userDB['mail'] ?? '' ?>" placeholder="Почта">
            <input class="basicForm-input" <?= !isset($userDB) ? "required" : '' ?> name="password" id="password" type="password" placeholder="Пароль">

            <select class="basicForm-input" required name="group_id" id="group_id">
                <?php if(isset($userDB)): ?>
                    <option value="0" disabled>Группа</option>
                    <?php foreach ($groups as $group): ?>
                        <option value="<?= $group['id'] ?>" <?= $userDB['group_id'] == $group['id'] ? 'selected' : '' ?>>
                            <?= $group['text'] ?>
                        </option>
                    <?php endforeach; ?>
                <?php else: ?>
                    <option value="0" disabled selected>Группа</option>
                    <?php foreach ($groups as $group): ?>
                        <option value="<?= $group['id'] ?>"><?= $group['text'] ?></option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>

            <button type="submit" class="basicForm-btn"><?= isset($userDB) ? "Редактировать" : 'Создать' ?></button>
        </form>
    </section>

</main>