
<h2 class="content__main-heading">Список задач</h2>

<form class="search-form" action="index.php" method="get" autocomplete="off">
    <input class="search-form__input" type="text" name="search" value="" placeholder="Поиск по задачам">

    <input class="search-form__submit" type="submit" name="" value="Искать">
</form>

<div class="tasks-controls">
    <nav class="tasks-switch">
        <a href="<?= $url ?>&filter=all" class="tasks-switch__item <?= ($filter === 'all') ? 'tasks-switch__item--active' : ''; ?>">Все задачи</a>
        <a href="<?= $url ?>&filter=day" class="tasks-switch__item <?= ($filter === 'day') ? 'tasks-switch__item--active' : ''; ?>">Повестка дня</a>
        <a href="<?= $url ?>&filter=tomorrow" class="tasks-switch__item <?= ($filter === 'tomorrow') ? 'tasks-switch__item--active' : ''; ?>">Завтра</a>
        <a href="<?= $url ?>&filter=overdue" class="tasks-switch__item <?= ($filter === 'overdue') ? 'tasks-switch__item--active' : ''; ?>">Просроченные</a>
    </nav>

    <label class="checkbox">
        <input class="checkbox__input visually-hidden show_completed" type="checkbox" <?= $show_complete_tasks === 1 ? 'checked' : "" ?>>
        <span class="checkbox__text">Показывать выполненные</span>
    </label>
</div>
<table class="tasks">
    <?php foreach ($doings as $value):  ?>
        <?php if ($show_complete_tasks === 1 || $value['done'] === '0'): ?>
        <tr class="tasks__item task <?= $value['done'] === '1' ? 'task--completed ': '' ?><?= isImportantTask($value['date'],24) ? 'task--important' : '' ?>">
            <td class="task__select">
                <label class="checkbox task__checkbox">
                    <input class="checkbox__input visually-hidden task__checkbox" type="checkbox"
                    <?= $value['done'] === '1' ? 'checked' : "" ?> value="<?= $value['id'] ?>">
                    <span class="checkbox__text"><?=htmlspecialchars($value['title'],ENT_QUOTES); ?></span>
                </label>
            </td>

            <td class="task__file">
                <?= $value['file_link'] !== "" ? '<a class="download-link" href="/uploads/' . $value['file_link'] . '">File</a>': "" ?>
            </td>

            <td class="task__date"><?=htmlspecialchars($value['date'],ENT_QUOTES); ?> </td>
        </tr>
        <?php endif ?>
    <?php endforeach ?>
</table>