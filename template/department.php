<div class="container-fluid" id="nav">
    <input type="checkbox" id="nav-trigger" />
    <label for="nav-trigger">
        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 8 8">
          <path d="M.5 0c-.28 0-.5.22-.5.5s.22.5.5.5.5-.22.5-.5-.22-.5-.5-.5zm1.5 0v1h6v-1h-6zm-1.5 2c-.28 0-.5.22-.5.5s.22.5.5.5.5-.22.5-.5-.22-.5-.5-.5zm1.5 0v1h6v-1h-6zm-1.5 2c-.28 0-.5.22-.5.5s.22.5.5.5.5-.22.5-.5-.22-.5-.5-.5zm1.5 0v1h6v-1h-6zm-1.5 2c-.28 0-.5.22-.5.5s.22.5.5.5.5-.22.5-.5-.22-.5-.5-.5zm1.5 0v1h6v-1h-6z"
          />
        </svg>
	</label>
    <ul class="row" id="navigation">
        <li class="col-xs-6 col-sm-4 col-md-1 col-md-offset-1">
            <a href="#CGE" class="text-center">通識</a>
        </li>
        <li class="col-xs-6 col-sm-4 col-md-1">
            <a href="#COT" class="text-center">科技</a>
        </li>
        <li class="col-xs-6 col-sm-4 col-md-1">
            <a href="#COE" class="text-center">教育</a>
        </li>
        <li class="col-xs-6 col-sm-4 col-md-1">
            <a href="#CLA" class="text-center">文學</a>
        </li>
        <li class="col-xs-6 col-sm-4 col-md-1">
            <a href="#COS" class="text-center">理學</a>
        </li>
        <li class="col-xs-6 col-sm-4 col-md-1">
            <a href="#COM" class="text-center">音樂</a>
        </li>
        <li class="col-xs-6 col-sm-4 col-md-1">
            <a href="#COB" class="text-center">管理</a>
        </li>
        <li class="col-xs-6 col-sm-4 col-md-1">
            <a href="#COA" class="text-center">藝術</a>
        </li>
        <li class="col-xs-6 col-sm-4 col-md-1">
            <a href="#CIS" class="text-center">國際</a>
        </li>
        <li class="col-xs-6 col-sm-4 col-md-1">
            <a href="#CSR" class="text-center">運動</a>
        </li>
    </ul>
</div>

<div class="container" id="middle">
    <form action="http://localhost/index.php" method="get" role="form">
        <div class="col-md-4 col-sm-6 col-xs-12">
        <h3 id="CGE">通識</h3>
        <ul class="list-group">
            <li>
                <a href="<?= $urlroot ?>index.php?dpm=0GU" class="list-group-item">
                    一般通識
                </a>
            </li>
            <li>
                <a href="<?= $urlroot ?>index.php?dpm=01U" class="list-group-item">
                    藝術與美感
                </a>
            </li>
            <li>
                <a href="<?= $urlroot ?>index.php?dpm=02U" class="list-group-item">
                    哲學思維與道德推理
                </a>
            </li>
            <li>
                <a href="<?= $urlroot ?>index.php?dpm=03U" class="list-group-item">
                    公民素養與社會探究
                </a>
            </li>
            <li>
                <a href="<?= $urlroot ?>index.php?dpm=04U" class="list-group-item">
                    歷史與文化
                </a>
            </li>
            <li>
                <a href="<?= $urlroot ?>index.php?dpm=05U" class="list-group-item">
                    數學與科學思維
                </a>
            </li>
            <li>
                <a href="<?= $urlroot ?>index.php?dpm=06U" class="list-group-item">
                    科學與生命
                </a>
            </li>
        </ul>
      </div>
        <div class="col-md-4 col-sm-6 col-xs-12">
        <h3 id="COT">科技學院</h3>
        <ul class="list-group">
            <li>
                <a href="<?= $urlroot ?>index.php?dpm=IEU" class="list-group-item">工業教育學系</a>
            </li>
            <li>
                <a href="<?= $urlroot ?>index.php?dpm=ITU" class="list-group-item">科技應用與人力資源發展學系</a>
            </li>
            <li>
                <a href="<?= $urlroot ?>index.php?dpm=GCU" class="list-group-item">圖文傳播學系</a>
            </li>
            <li>
                <a href="<?= $urlroot ?>index.php?dpm=MTU" class="list-group-item">機電工程學系</a>
            </li>
            <li>
                <a href="<?= $urlroot ?>index.php?dpm=AEU" class="list-group-item">電機工程學系</a>
            </li>
        </ul>
      </div>
        <div class="col-md-4 col-sm-6 col-xs-12">
        <h3 id="COE">教育學院</h3>
        <ul class="list-group">
            <li><a href="<?= $urlroot ?>index.php?dpm=EDU" class="list-group-item">教育學系</a></li>
            <li><a href="<?= $urlroot ?>index.php?dpm=PCU" class="list-group-item">教育心理與輔導學系</a></li>
            <li><a href="<?= $urlroot ?>index.php?dpm=SOU" class="list-group-item">社會教育學系</a></li>
            <li><a href="<?= $urlroot ?>index.php?dpm=HEU" class="list-group-item">健康促進與衛生教育學系</a></li>
            <li><a href="<?= $urlroot ?>index.php?dpm=HGU" class="list-group-item">人類發展與家庭學系</a></li>
            <li><a href="<?= $urlroot ?>index.php?dpm=CEU" class="list-group-item">公民教育與活動領導學系</a></li>
            <li><a href="<?= $urlroot ?>index.php?dpm=SPU" class="list-group-item">特殊教育學系</a></li>
        </ul>
      </div>
        <div class="col-md-4 col-sm-6 col-xs-12">
        <h3 id="CLA">文學院</h3>
        <ul class="list-group">
            <li><a href="<?= $urlroot ?>index.php?dpm=CHU" class="list-group-item">國文學系</a></li>
            <li><a href="<?= $urlroot ?>index.php?dpm=ENU" class="list-group-item">英語學系</a></li>
            <li><a href="<?= $urlroot ?>index.php?dpm=HIU" class="list-group-item">歷史學系</a></li>
            <li><a href="<?= $urlroot ?>index.php?dpm=GEU" class="list-group-item">地理學系</a></li>
            <li><a href="<?= $urlroot ?>index.php?dpm=TCU" class="list-group-item">臺灣語文學系</a></li>
        </ul>
      </div>
        <div class="col-md-4 col-sm-6 col-xs-12">
        <h3 id="COS">理學院</h3>
        <ul class="list-group">
            <li><a href="<?= $urlroot ?>index.php?dpm=MAU" class="list-group-item">數學系</a></li>
            <li><a href="<?= $urlroot ?>index.php?dpm=PHU" class="list-group-item">物理學系</a></li>
            <li><a href="<?= $urlroot ?>index.php?dpm=CMU" class="list-group-item">化學系</a></li>
            <li><a href="<?= $urlroot ?>index.php?dpm=BIU" class="list-group-item">生命科學系</a></li>
            <li><a href="<?= $urlroot ?>index.php?dpm=ESU" class="list-group-item">地球科學系</a></li>
            <li><a href="<?= $urlroot ?>index.php?dpm=CSU" class="list-group-item">資訊工程學系</a></li>
        </ul>
      </div>
        <div class="col-md-4 col-sm-6 col-xs-12">
        <h3 id="COM">音樂學院</h3>
        <ul class="list-group">
            <li><a href="<?= $urlroot ?>index.php?dpm=MUU" class="list-group-item">音樂學系</a></li>
        </ul>
      </div>
        <div class="col-md-4 col-sm-6 col-xs-12">
        <h3 id="COB">管理學院</h3>
        <ul class="list-group">
            <li><a href="<?= $urlroot ?>index.php?dpm=BAU" class="list-group-item">企業管理學士學位學程</a></li>
        </ul>
      </div>
        <div class="col-md-4 col-sm-6 col-xs-12">
        <h3 id="COA">藝術學院</h3>
        <ul class="list-group">
            <li><a href="<?= $urlroot ?>index.php?dpm=ATU" class="list-group-item">美術學系</a></li>
            <li><a href="<?= $urlroot ?>index.php?dpm=VDU" class="list-group-item">設計學系</a></li>
        </ul>
      </div>
        <div class="col-md-4 col-sm-6 col-xs-12">
        <h3 id="CIS">國際與社會科學學院</h3>
        <ul class="list-group">
            <li><a href="<?= $urlroot ?>index.php?dpm=EAU" class="list-group-item">東亞學系</a></li>
            <li><a href="<?= $urlroot ?>index.php?dpm=CLU" class="list-group-item">華語文教學系</a></li>
            <li><a href="<?= $urlroot ?>index.php?dpm=TSU" class="list-group-item">應用華語文學系</a></li>
        </ul>
      </div>
        <div class="col-md-4 col-sm-6 col-xs-12">
        <h3 id="CSR">運動與休閒學院</h3>
        <ul class="list-group">
            <li><a href="<?= $urlroot ?>index.php?dpm=PEU" class="list-group-item">體育學系</a></li>
            <li><a href="<?= $urlroot ?>index.php?dpm=FPU" class="list-group-item">運動競技學系</a></li>
        </ul>
      </div>
    </form>
</div>
