<div class="outer">
    <div class="tip">
        小提醒：如果覺得一個個找太累的話，可以善用 <pre>ctrl</pre>/<pre>command</pre> + <pre>f</pre> 的搜尋功能！
    </div>
    <div class="deps">
            <?php
                $count = 0;
                $next = 0;
                $open = true;
                $group = array("通用", 5, "校際", 6, 5, 4, 4, 2, 4, 4, 4, 3, 4, 4, 1, 4, 4, 4, 4, 2, 4, 1, 4, 4, 4, 4, 4, 2, 2, 3, 2, 2, 1, 3, 1, 3, 1, 3, 4, 2, 3, 2, 1, 3, 2, 2, 1, 1, 2, 3, 2, 1, 2, 2, 1, 4, 1 ,2, 2, 2, "學程", 37, "其他", 1);

            foreach ($dpms as $dpm): ?>
                <?php
                    if (gettype($group[$next]) == "string")
                    {
                        echo "<h2>".$group[$next]."</h2>";
                        $next+=1;
                    }
                    if (substr($dpm["ChName"], -3) == "院")
                    {
                        echo "<h2><a href=".$urlroot."index.php?dpm=".$dpm["DeptCode"].">".$dpm["ChName"]."</a></h2>";

                    }
                    else if ($open)
                    {
                        echo "<ul>";
                        $open = false;
                    }

                if (substr($dpm["ChName"], -3) != "院")
                {
                    ?>
                    <li>
                        <a href="<?= $urlroot ?>index.php?dpm=<?= $dpm["DeptCode"] ?>">
                            <?= $dpm["ChName"] ?>
                        </a>
                    </li>
                    <?php
                }
                    if ($count == $group[$next])
                    {
                        echo "</ul>";
                        $next += 1;
                        $open = true;
                        $count = 0;
                    }
                    $count++;
                ?>
            <?php endforeach ?>
    </div>
</div>
