    	<div class="container" id="foot">
    		<div class="modal fade" id="fbModal" tabindex="-1" role="dialog" aria-labelledby="fbModal" aria-hidden="true">
        		<div class="modal-dialog modal-sm">
            		<div class="modal-content">
                		<div class="modal-header">
                    		<h3 class="modal-title text-center" id="fbModalLabel">請登入以繼續</h3>
                		</div>
                		<div class="modal-body">
                    		<div class="text-center">
                        		<div class="fb-login-button" data-max-rows="1" data-size="xlarge" data-show-faces="false" data-auto-logout-link="true"></div>
                    		</div>
                		</div>
                		<div class="modal-footer">
                    		<div class="text-center">
                        		<button type="button" class="btn btn-default" data-dismiss="modal">關閉</button>
                    		</div>
                		</div>
            		</div>
        		</div>
    		</div>
        <div class="modal fade" id="easterEggModal" tabindex="-2" role="dialog" aria-labelledby="easterEggModal" aria-hidden="true">
        		<div class="modal-dialog modal-lg">
            		<div class="modal-content">
                		<div class="modal-header">
                    		<h3 class="modal-title text-center" id="easterEggModalLabel">驚喜！</h3>
                		</div>
                		<div class="modal-body">
                    		<div class="text-center">
                          <iframe width="420" height="315" src="https://www.youtube.com/embed/ZZ5LpwO-An4" frameborder="0" allowfullscreen></iframe>
                    		</div>
                		</div>
                		<div class="modal-footer">
                    		<div class="text-center">
                        		<button type="button" class="btn btn-default" data-dismiss="modal">關閉</button>
                    		</div>
                		</div>
            		</div>
        		</div>
    		</div>
        	<div class="row">
            	<div class="col-xs-12">
       				<!--<h6 class="text-center" id="report_entrance"><a href="<?= $urlroot ?>report.php">回報問題或提供意見</a></h6>-->
              <h6 class="text-center"><a href="#">關於</a>-
                <a href="<?= $urlroot ?>policy.html">隱私權政策</a>-
                <a href="http://survive.coursentnu.com/">Survive NTNU</a>-
                <a href="https://www.facebook.com/CommunityNTNU">Facebook</a>-
                <a href="<?= $urlroot ?>subs.php?u=<?= $_SESSION["u"] ?>">subscription</h6>
            	</div>
        	</div>
        </div>
    </body>
</html>
