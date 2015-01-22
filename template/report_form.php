<div class="container" id="middle">
    <script>$(function(){$("#report_entrance").addClass('hidden');})</script>

    <form role="form">
        <div class="form-group">
            <div class="row">
                <label class="col-xs-12 control-label text-center" for="report_text">
                    <h3>回報問題或提供意見</h3>
                    <p>courseNTNU目前還是Beta版，有很大的可能性會出錯或是有課程資訊有誤，如果發現問題，請回報給開發人員，謝謝！如果你想要參與或作出貢獻的，也請利用本表格告訴我們！</p>
                </label>
            </div>
            <div class="alert alert-success hidden" id="report_success_message" role="alert">成功送出！</div>
            <div class="alert alert-warning hidden" id="report_blank_message" role="alert">欄位空白</div>
            <div class="row">
                <div class="col-xs-12">
                    <textarea class="form-control" id="report" rows="5"></textarea>
                </div>
            </div>
        </div>
        <div class="row text-center">
            <button type="submit" id="submit_report" class="btn btn-default" disabled="disabled">送出</button>
        </div>
    </form>
    
</div>
