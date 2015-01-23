<div class="container" id="middle">

    <form class="form-inline" action="../search.php" method="GET">
        <div class="form-group">
            <input type="text" class="form-control" id="yo" placeholder="輸入" name="word">
        </div>
        <button type="submit" class="btn btn-default">搜尋</button>
    </form>
    
    <ul class="list-group">
        <?php foreach($results as $result): ?>

            <?php if ($result["availability"] === '1'): ?>
                <li class="list-group-item">
                    <h4><span class="label label-success"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></span><a href="<?= $urlroot ?>index.php?dpm=<?= $result['department'] ?>&amp;cod=<?= $result['code'] ?>">
                        <?= $result['chname'] ?>
                    </a></h4>
                </li>
            <?php endif ?>
            
        <?php endforeach ?>
        <?php foreach($results as $result): ?>

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