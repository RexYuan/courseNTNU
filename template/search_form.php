<div class="container" id="middle">

    <h3>搜尋</h3>
    <div class="alert alert-warning hidden" id="search_blank_message" role="alert">欄位空白</div>
    <form class="form-inline" action="../search.php" method="GET">
        <div class="form-group">
            <input autofocus type="text" class="form-control" placeholder="想找什麼？" name="word">
        </div>
        <button type="submit" class="btn btn-default">搜尋</button>
    </form>
    
    <?php if (empty($results)): ?>
        <h4>沒有結果</h4>
    <?php else: ?>
        <h4>搜尋「<?= $word ?>」結果：</h4>
    <?php endif ?>

    <ul class="list-group">
        <?php foreach ($results as $result): ?>

            <?php if ($result["availability"] === '1'): ?>
                <li class="list-group-item">
                    <h4><span class="label label-success"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></span><a href="<?= $urlroot ?>index.php?dpm=<?= $result['department'] ?>&amp;cod=<?= $result['code'] ?>">
                        <?= $result['chname'] ?>
                    </a></h4>
                </li>
            <?php endif ?>
            
        <?php endforeach ?>
        <?php foreach ($results as $result): ?>

            <?php if ($result["availability"] === '0'): ?>
                <li class="list-group-item">
                    <h4><span class="label label-danger"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></span><a href="<?= $urlroot ?>index.php?dpm=<?= $result['department'] ?>&amp;cod=<?= $result['code'] ?>">
                        <?= $result['chname'] ?>
                    </a></h4>
                </li>
            <?php endif ?>

        <?php endforeach ?>
    </ul>
    
</div>