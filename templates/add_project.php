
      <main class="content__main">
        <h2 class="content__main-heading">Добавление проекта</h2>

        <form class="form"  action="add_project.php" method="post" autocomplete="off">
          <div class="form__row">
            <label class="form__label" for="project_name">Название <sup>*</sup></label>
            <?= isset($errors['project']) ? '<p class="form__message"> ' . $errors['project'] . '</p>' : '' ?>
            <input class="form__input <?= isset($errors['project']) ? "form__input--error" : '' ?>" type="text" name="name" id="project_name" value="" placeholder="Введите название проекта">
          </div>

          <div class="form__row form__row--controls">
            <input class="button" type="submit" name="" value="Добавить">
          </div>
        </form>
      </main>
