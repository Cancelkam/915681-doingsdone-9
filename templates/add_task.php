
      <main class="content__main">
        <h2 class="content__main-heading">Добавление задачи</h2>

        <form class="form"  action="add_task.php" method="post" autocomplete="off" enctype="multipart/form-data">
          <div class="form__row">
            <label class="form__label  " for="name" >Название <sup>*</sup></label>
            <?= isset($errors['name']) ? '<p class="form__message"> ' . $errors['name'] . '</p>' : '' ?>
            <input class="form__input <?= isset($errors['name']) ? 'form__input--error' : '' ?>" type="text" maxlength="1000" name="name" id="name" value="<?= $task['name'] ?>" placeholder="Введите название">
          </div>

          <div class="form__row">
            <label class="form__label" for="project">Проект <sup>*</sup></label>
            <?= isset($errors['project']) ? '<p class="form__message"> ' . $errors['project'] . '</p>' : '' ?>
            <select class="form__input <?= isset($errors['project']) ? 'form__input--error' : '' ?> form__input--select" name="project" id="project">
                <?php foreach ($projects as $value): ?>
                <option value="<?= $value['project_id']; ?>"><?= $value['name']; ?></option>
                <?php endforeach; ?>
            </select>
          </div>

          <div class="form__row">
            <label class="form__label" for="date">Дата выполнения</label>
            <?= isset($errors['date']) ? '<p class="form__message"> ' . $errors['date'] . '</p>' : '' ?>


            <input class="form__input form__input--date <?= isset($errors['date']) ? 'form__input--error' : '' ?> " type="text" name="date" id="date" value="<?= $task['date'] ?>" placeholder="Введите дату в формате ГГГГ-ММ-ДД">
          </div>

          <div class="form__row">
            <label class="form__label" for="file">Файл</label>

            <div class="form__input-file">
              <input class="visually-hidden" type="file" name="file" id="file" value="">

              <label class="button button--transparent" for="file">
                <span>Выберите файл</span>
              </label>
            </div>
          </div>

          <div class="form__row form__row--controls">
            <input class="button" type="submit" name="" value="Добавить">
          </div>
        </form>
      </main>
