<!-- 為了讓這個檔案簡潔一點，老師跟系所的部分都還沒做連結所以只有id，也不一定每行資料都會用得上 -->
<div class="outer">
    <div class="allThisCourse">
        <h2><?= $crecords[0]["ChName"] ?>(<?= $crecords[0]["EnName"] ?>)</h2>

        <ul class="tabs">
            <?php
                $x=1;
                foreach ($crecords as $crecord):
            ?>
            <li class="tab">
            <?php
                echo "<input type='radio' class='tab-switch' id='tab-".$x."' name='teacher-tabs' value='' style='' ".($x==1?"checked":"").">";//display:none;
                echo "<label class='tab-label' for='tab-".$x."'>".$crecord["TeChName"].($crecord["TeEnName"] != ""? "(".$crecord["TeEnName"].")":"")."</label>";
            ?>
                <div class="course tab-content">
                <h3>
                    開課教師：<?= $crecord["TeChName"] ?>
                    <?
                    if ( $crecord["TeEnName"] != "")
                    {
                        echo "(".$crecord["TeEnName"].")";
                    }
                    ?>
                </h3>
                <div class="intro">
                    <h3>課程簡介</h3>
                    <p><?= $crecord["Description"] ?></p>
                </div>
                <div class="details">
                    <div class="info">
                        <h3>基本資訊</h3>
                        <ul>
                            <li><?= $crecord["AcadmYear"] ?> 學年 第<?= $crecord["AcadmTerm"] ?>學期</li>
                            <li>開課序號：<?= $crecord["SerialNo"] ?></li>
                            <li>課程代碼：<?= $crecord["CourseCode"] ?></li>
                            <li>學分數：<?= $crecord["Credit"] ?></li>
                            <li>上課地點：<?= $crecord["ChLocation"] ?></li>
                            <li>上課時間：<?= $crecord["TimeInfo"] ?></li>
                        </ul>
                    </div>
                    <div class="info">
                        <h3>選課情形</h3>
                        <ul>
                            <li>選課人數：<?= $crecord["Enrolled"] ?></li>
                            <li>已分發人數：<?= $crecord["Assigned"] ?></li>
                            <li>未分發人數：<?= $crecord["Unassigned"] ?></li>
                        </ul>
                    </div>
                    <div class="info">
                        <h3>其他資訊</h3>
                        <ul>
                            <li>全英語授課：<?php echo $crecord["IsEngTeach"] == "N"?"No":"Yes" ?></li>
                            <li>MOOCs：<?php echo $crecord["IsMOOC"] == "N"?"No":"Yes" ?></li>
                            <li>限修人數：<?= $crecord["TotalMaxSize"] ?></li>
                        </ul>
                    </div>

                </div>
            </div>
            </li>
        <?php
            $x++;
            endforeach
        ?>
        </ul>
        <!-- 還要規劃評論跟投票區，以及一個「追蹤（subscribe）」按鈕 -->
        <div class="fb-comments" data-href="<?= $urlroot.$_SERVER["REQUEST_URI"] ?>" data-width="100%" data-numposts="5" data-colorscheme="light"></div>
    </div>
</div>


<!-- <h2><?= $crecord["TeacherId"] ?></h2> 教師識別碼 -->
<!-- <h2><?= $crecord["CourseGroup"] ?></h2> 組別 -->
<!-- <h2><?= $crecord["ClassCode"] ?></h2> 開課班級代碼 -->
<!-- <h2><?= $crecord["Duration"] ?></h2> 全/半學期 -->
<!-- <h2><?= $crecord["DeptId"] ?></h2> 開課系所識別碼 -->
<!-- <h2><?= $crecord["DeptGroup"] ?></h2> 開課組別 -->
<!-- <h2></h2> 全英語授課 -->
<!-- <h2><?= $crecord["Grade"] ?></h2> 開課年級 -->
<!-- <h2><?= $crecord["GenderRestrict"] ?></h2> 性別限制 -->
<!-- <h2><?= $crecord["IsMOOC"] ?></h2> MOOCs -->
<!-- <h2><?= $crecord["IsElective"] ?></h2> 必／選修 -->
<!-- <h2><?= $crecord["RestrictInfo"] ?></h2> 限制 -->
<!-- <h2><?= $crecord["RemoteTeach"] ?></h2> 遠距授課 -->
<!-- <h2><?= $crecord["selfTeachName"] ?></h2> 正課實驗親授 -->
<!-- <h2><?= $crecord["StatusInfo"] ?></h2> 是否停開 -->
<!-- <h2><?= $crecord["ChComment"] ?></h2> 中文註解 -->
<!-- <h2><?= $crecord["EnComment"] ?></h2> 英文註解 -->
<!-- <h2><?= $crecord["AuthMaxSize"] ?></h2> 授權碼名額 -->
<!-- <h2><?= $crecord["AuthRate"] ?></h2> 授權碼比例 -->
<!-- <h2><?= $crecord["NTAMaxSize"] ?></h2> 台大聯盟限修人數 -->
<!-- <h2><?= $crecord["Hour"] ?></h2> 上課時數 -->
<!-- <h2><?= $crecord["FmReserve"] ?></h2> 保留新生人數 -->
<!-- <h2><?= $crecord["AuthAssigned"] ?></h2> 授權碼選課人數 -->
<!-- <h2><?= $crecord["ExAssigned"] ?></h2> 交換生選課人數 -->
<!-- <h2><?= $crecord["PtAssigned"] ?></h2> 不佔名額生人數 -->
<!-- <h2><?= $crecord["Abbr"] ?></h2> 開課代碼前綴 -->
<!-- <h2><?= $crecord["DeptCode"] ?></h2> 系所代碼 -->
<!-- <h2><?= $crecord["DeptChName"] ?></h2> 系所中文名稱 -->
<!-- <h2><?= $crecord["DeptEnName"] ?></h2> 系所英文名稱 -->
<!-- <?= $crecord["TeDescription"] ?></h2> 簡短描述 -->
