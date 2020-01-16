<div class="container">
    <div class="pages-content">				
		<div class="modal-header text-center">
			<h4 class="sign-title"><?php 
			if(!empty($lists[0]['footer_submenu'])) {  echo $lists[0]['footer_submenu']; } ?></h4>
		</div>
		<div class="modal-body">
			<div class="form-group">
				<?php if(!empty($lists[0]['page_desc'])) { echo $lists[0]['page_desc'];  } ?>
			</div>
		</div>	
	</div>
</div>