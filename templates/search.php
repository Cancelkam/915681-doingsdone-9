<div class="content__main-col">

    <header class="content__header">
        <h2 class="content__header-text">Результаты поиска</h2>
        <a class="button button--transparent content__header-button" href="/">Назад</a>
    </header>

    <ul>
    <? foreach ($result as $value): ?>
       <li><?= $value['title'] ?>
    <?endforeach?>
    </ul>
    <? if (empty($result)): ?>
    <? print('Ничего не найдено по вашему запросу'); ?>
    <? endif ?>
</div>