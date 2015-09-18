<div class="outer">
    <div class="allThisCourse">
        <h2><?= $crecords[0]["ChName"] ?>(<?= $crecords[0]["EnName"] ?>)</h2>
        <ul class="tabs">
            <?php $x=1; foreach ($crecords as $crecord): ?>
            <li class="tab">
            <input type='radio' class='tab-switch' id='tab-<?= $x ?>' name='teacher-tabs' value='' style='<?= ($x==1) ? "checked" : ""; ?>'>
            <label class='tab-label' for='tab-<?= $x ?>'><?= $crecord["TeChName"].(($crecord["TeEnName"] != "") ? "(".$crecord["TeEnName"].")" : "") ?><br><?= $crecord["TimeInfo"] ?></label>
                <div class="course tab-content">
                <h3>
                    開課教師：<?= $crecord["TeChName"] ?>
                    <?= ($crecord["TeEnName"] != "") ? "(".$crecord["TeEnName"].")" : "" ?>
                    , 開課系所：<a href="<?=$urlroot?>index.php?dpm=<?= $_GET["dpm"] ?>"><?= $crecord["DeptChName"] ?></a>
                </h3>
                <div class="appraisal">
                    <h3>課程評價</h3>
                    <ul>
                        <li class="score">
                            <div class="app-info">
                              推薦分數：<span></span> 分
                            </div>
                            <input class="subscribe" type="button" name="name" value="追蹤" data-serial="<?= $crecord["SerialNo"] ?>">
                        </li>
                        <li class="recom">
                            <div class="app-info">
                                <span class="good lk-<?= $crecord["TeacherId"] ?>"><?= $crecord["LikeIt"] ?></span> 人推薦
                            </div>
                            <input class="ratbtn" type="button" name="name" value="推" data-cid="<?= $crecord["CourseId"] ?>" data-rate=1 data-cod="<?= $crecord["CourseCode"] ?>">
                        </li>
                        <li class="unrecom">
                            <div class="app-info">
                                <span class="bad dlk-<?= $crecord["TeacherId"] ?>"><?= $crecord["DislikeIt"] ?></span> 人不推薦
                            </div>
                            <input class="ratbtn" type="button" name="name" value="不推" data-cid="<?= $crecord["CourseId"] ?>" data-rate=0 data-cod="<?= $crecord["CourseCode"] ?>">
                        </li>
                    </ul>
                </div>
                <div class="intro">
                    <h3>課程簡介</h3>
                    <p><?= $crecord["Description"] ?></p>
                </div>
                <div class="details">
                    <div class="info">
                        <h3>基本資訊</h3>
                        <ul>
                            <li><a href="http://courseap.itc.ntnu.edu.tw/acadmOpenCourse/SyllabusCtrl?year=<?=$crecord["AcadmYear"]?>&amp;term=<?=$crecord["AcadmTerm"]?>&amp;courseCode=<?=$crecord["CourseCode"]?>&amp;courseGroup=<?=$crecord["CourseGroup"]?>&amp;deptCode=<?=$crecord["DeptCode"]?>&amp;formS=<?=$crecord["Grade"]?>&amp;classes1=<?=$crecord["ClassCode"]?>&amp;deptGroup=<?=$crecord["DeptGroup"]?>">
                              課程綱要</a></li>
                            <li><?= $crecord["AcadmYear"] ?> 學年 - 第<?= $crecord["AcadmTerm"] ?>學期</li>
                            <li>系必／選修：<?= ($crecord["IsElective"]) ? "必" : "選" ?></li>
                            <li>開課序號：<?= $crecord["SerialNo"] ?></li>
                            <li>課程代碼：<?= $crecord["CourseCode"] ?></li>
                            <li>開課年級：<?= $crecord["Grade"] ?></li>
                            <li>學分數：<?= $crecord["Credit"] ?></li>
                            <li>上課地點：<?= $crecord["ChLocation"] ?></li>
                            <li>上課時間：<?= $crecord["TimeInfo"] ?></li>
                        </ul>
                    </div>
                    <div class="info">
                        <h3>選課資訊</h3>
                        <ul>
                            <li>限修人數：<?= $crecord["TotalMaxSize"] ?></li>
                            <li>選課人數：<?= $crecord["Enrolled"] ?></li>
                            <li>已分發人數：<?= $crecord["Assigned"] ?></li>
                            <li>未分發人數：<?= $crecord["Unassigned"] ?></li>
                            <li>授權碼總數：<?= $crecord["AuthMaxSize"] ?></li>
                            <li>授權碼選課人數：<?= $crecord["AuthAssigned"] ?></li>
                            <li>保留新生人數：<?= $crecord["FmReserve"] ?></li>
                            <li>台大聯盟限修人數：<?= $crecord["NTAMaxSize"] ?></li>
                        </ul>
                    </div>
                    <div class="info">
                        <h3>其他資訊</h3>
                        <ul>
                            <li>一般限制：<?= ($crecord["RestrictInfo"] == "") ? "No" : $crecord["RestrictInfo"] ?>
                            <li>性別限制：<?= ($crecord["GenderRestrict"] == "N") ? "No" : $crecord["GenderRestrict"] ?></li>
                            <li>全英語授課：<?= ($crecord["IsEngTeach"] == "N") ? "No" : "Yes" ?></li>
                            <li>MOOC：<?= ($crecord["IsMOOC"] == "N") ? "No" : "Yes" ?></li>
                            <li>遠距授課：<?= ($crecord["RemoteTeach"] == "N") ? "No" : "Yes" ?></li>
                            <li>備註：<?= ($crecord["ChComment"] == "") ? "No" : $crecord["ChComment"] ?><?= ($crecord["EnComment"] != "") ? $crecord["EnComment"] : "" ?></li>
                        </ul>
                    </div>

                </div>
            </div>
            </li>
        <?php $x++; endforeach ?>
        </ul>
        <div class="fb-comments" data-href="<?= $urlroot.$_SERVER["REQUEST_URI"] ?>" data-width="100%" data-numposts="5" data-colorscheme="light"></div>
    </div>
</div>

<script type="text/javascript">
	/*
    var re = document.querySelector(".recom span") && document.querySelector(".recom span").innerHTML;
    var unre = document.querySelector(".unrecom span") && document.querySelector(".unrecom span").innerHTML;
    if (document.querySelector(".score span")) {
        document.querySelector(".score span").innerHTML = Math.round(100 * Number(re) / (Number(re) + Number(unre)))
        if (re - unre > 0) {
            document.querySelector(".score span").classList.add("good");
        }
        else {
            document.querySelector(".score span").classList.add("bad");
        }
    }*/
    var re = document.querySelector(".recom span") && document.querySelector(".recom span").innerHTML;
    var unre = document.querySelector(".unrecom span") && document.querySelector(".unrecom span").innerHTML;
    if (re > 0 || unre > 0)
    {
        var rat = Math.round(100 * Number(re) / (Number(re) + Number(unre)))
        if (document.querySelector(".score span")) {
            document.querySelector(".score span").innerHTML = rat;
            if (rat >= 50) {
                document.querySelector(".score span").classList.add("good");
            }
            else {
                document.querySelector(".score span").classList.add("bad");
            }
        }
    }
    else {
        alert(re);
        document.querySelector(".score span").innerHTML = "N/A";
    }
</script>
<!-- <h2><?= $crecord["TeacherId"] ?></h2> 教師識別碼 -->
<!-- <h2><?= $crecord["CourseGroup"] ?></h2> 組別 -->
<!-- <h2><?= $crecord["ClassCode"] ?></h2> 開課班級代碼 -->
<!-- <h2><?= $crecord["Duration"] ?></h2> 全/半學期 -->
<!-- <h2><?= $crecord["DeptId"] ?></h2> 開課系所識別碼 -->
<!-- <h2><?= $crecord["DeptGroup"] ?></h2> 開課組別 -->
<!-- <h2><?= $crecord["selfTeachName"] ?></h2> 正課實驗親授 -->
<!-- <h2><?= $crecord["StatusInfo"] ?></h2> 是否停開 -->
<!-- <h2><?= $crecord["AuthRate"] ?></h2> 授權碼比例 -->
<!-- <h2><?= $crecord["Hour"] ?></h2> 上課時數 -->
<!-- <h2><?= $crecord["ExAssigned"] ?></h2> 交換生選課人數 -->
<!-- <h2><?= $crecord["PtAssigned"] ?></h2> 不佔名額生人數 -->
<!-- <h2><?= $crecord["Abbr"] ?></h2> 開課代碼前綴 -->
<!-- <h2><?= $crecord["DeptCode"] ?></h2> 系所代碼 -->
<!-- <h2><?= $crecord["DeptChName"] ?></h2> 系所中文名稱 -->
<!-- <h2><?= $crecord["DeptEnName"] ?></h2> 系所英文名稱 -->
<!-- <?= $crecord["TeDescription"] ?></h2> 教師簡短描述 -->
