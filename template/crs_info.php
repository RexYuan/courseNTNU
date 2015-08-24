
                <form role="form">
                    <div class="row">
                        <input id="code" class="hidden" name="code" value="<?= $course['code'] ?>"/>
                        <div class="col-xs-6 form-group">
                            <input id="likebtn" type="submit" class="btn btn-success btn-block" name="rate" value="推" disabled="disabled"/>
                        </div>
                        <div class="col-xs-6 form-group">
                            <input id="dislikebtn" type="submit" class="btn btn-danger btn-block" name="rate" value="不推" disabled="disabled"/>
                        </div>
                    </div>
                </form>

<h1><?= $crecords[0]["ChName"] ?></h1>
<?php foreach ($crecords as $crecord): ?>
  <h2><?= $crecord["CourseId"] ?></h2>
  <h2><?= $crecord["SerialNo"] ?></h2> <!-- 開課序號 -->
  <h2><?= $crecord["CourseCode"] ?></h2> <!-- 課程代碼 -->
  <h2><?= $crecord["AcadmYear"] ?></h2> <!-- 學年 -->
  <h2><?= $crecord["AcadmTerm"] ?></h2> <!-- 學期 -->
  <h2><?= $crecord["ChName"] ?></h2> <!-- 中文課程名稱 -->
  <h2><?= $crecord["EnName"] ?></h2>
  <h2><?= $crecord["TeacherId"] ?></h2>
  <h2><?= $crecord["CourseGroup"] ?></h2>
  <h2><?= $crecord["ClassCode"] ?></h2>
  <h2><?= $crecord["Duration"] ?></h2>
  <h2><?= $crecord["Credit"] ?></h2>
  <h2><?= $crecord["DeptId"] ?></h2>
  <h2><?= $crecord["DeptGroup"] ?></h2>
  <h2><?= $crecord["IsEngTeach"] ?></h2>
  <h2><?= $crecord["Grade"] ?></h2>
  <h2><?= $crecord["GenderRestrict"] ?></h2>
  <h2><?= $crecord["IsMOOC"] ?></h2>
  <h2><?= $crecord["IsElective"] ?></h2>
  <h2><?= $crecord["RestrictInfo"] ?></h2>
  <h2><?= $crecord["RemoteTeach"] ?></h2>
  <h2><?= $crecord["selfTeachName"] ?></h2>
  <h2><?= $crecord["ChLocation"] ?></h2>
  <h2><?= $crecord["EnLocation"] ?></h2>
  <h2><?= $crecord["TimeInfo"] ?></h2>
  <h2><?= $crecord["StatusInfo"] ?></h2>
  <h2><?= $crecord["ChComment"] ?></h2>
  <h2><?= $crecord["EnComment"] ?></h2>
  <h2><?= $crecord["AuthMaxSize"] ?></h2>
  <h2><?= $crecord["AuthRate"] ?></h2>
  <h2><?= $crecord["NTAMaxSize"] ?></h2>
  <h2><?= $crecord["TotalMaxSize"] ?></h2>
  <h2><?= $crecord["Hour"] ?></h2>
  <h2><?= $crecord["Description"] ?></h2>
  <h2><?= $crecord["FmReserve"] ?></h2>
  <h2><?= $crecord["Enrolled"] ?></h2>
  <h2><?= $crecord["Assigned"] ?></h2>
  <h2><?= $crecord["Unassigned"] ?></h2>
  <h2><?= $crecord["AuthAssigned"] ?></h2>
  <h2><?= $crecord["ExAssigned"] ?></h2>
  <h2><?= $crecord["PtAssigned"] ?></h2>
<?php endforeach ?>

<div class="fb-comments" data-href="<?= $urlroot.$_SERVER["REQUEST_URI"] ?>" data-width="100%" data-numposts="5" data-colorscheme="light"></div></div>
