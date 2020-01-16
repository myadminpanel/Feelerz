<div class="content-page">
	<div class="content">
		<div class="container">
			<div class="row">
				<div class="col-sm-8">
					<h4 class="page-title m-t-0">New Updates</h4>			
				</div>			
				<div class="pull-right">
					<button class="btn btn-primary" id="upload"><i class="fa fa-upload m-r-5"></i> Upload</button>	
					<button class="btn btn-danger" id="check"><i class="fa fa-refresh m-r-5"></i> Check Updates</button>	
					<button class="btn btn-success hidden" id="download" ><i class="fa fa-download m-r-5"></i> New updates available</button>	
					<input type="hidden" name="filename" id="filename">
				</div>
			</div>
			<div class="clear-fix"></div><br>	
			<!-- Upload Form here  -->	
			<form id="upload_form" enctype="multipart/form-data"> 
				<input type="file" name="upload_file" id="upload_file" class="hidden">	
			</form>
			<!-- upload form ends  -->
			<!-- Notification  -->
			<div class="notify"></div>
			<?php
			if($this->session->flashdata('message')){
				echo '<div class="alert alert-danger fade in alert-dismissable">
				<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
				<strong>'.$this->session->flashdata('message').'</strong> 
			</div>'; 
		}elseif($this->session->flashdata('success')){
			echo '<div class="alert alert-success fade in alert-dismissable">
			<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
			<strong>Success ! </strong>'.$this->session->flashdata('success').' 
		</div>'; 
	}
	?>
	<!-- Notification  ends -->
	<div class="panel">
		<div class="panel-body">
			<div class="table-responsive">
				<table class="table table-striped table-actions-bar datatable">
					<thead>
						<tr>
							<th>#</th>
							<th>Build</th>                                    
							<th>Version</th>                                    
							<th>Title</th>                                   
							<th>Last Updated On</th>                                    								
						</tr>
					</thead>
					<tbody >	
						<?php 
						$i = 1;
						foreach ($updates as $u):	
							echo '<tr>
						<td>'.$i++.'</td>
						<td>'.$u->build.'</td>
						<td>'.$u->version.'</td>
						<td>'.$u->title.'</td>
						<td>'.date('d-m-Y H:i A',strtotime($u->last_updated)).'</td>								
					</tr>';
					endforeach;
					?>						
				</tbody>
			</table>
		</div>
	</div>
</div>
 <br>
<div class="backups">
	<div class="row">
		<div class="col-sm-8">
			<h4 class="page-title m-b-20 m-t-0">Backup Details</h4>
		</div>
		<div class="col-sm-4 text-right m-b-20">
			<a class="btn btn-success pull-right backup_btn" href="<?php echo  base_url();?>admin/new_updates/backup_db"><i class="fa fa-database m-r-5"></i> Backup Files & DB</a>	
			<button class="btn btn-info pull-right loading" style="display: none"><i class="fa fa-spinner fa-spin fa-fw m-r-5"></i> Please wait backup on process</button>
		</div>
	</div>
</div>
<div class="clearfix"></div>
<div class="panel">
	<div class="panel-body">
		<div class="table-responsive">
			<table class="table table-striped table-actions-bar datatable">
				<thead>
					<tr>
						<th>#</th>
						<th>Backup File name</th>          
						<th>Created On</th>                                    
						<th>Action</th>                                    
					</tr>
				</thead>
				<tbody >	
					<?php 
					$i = 1;
					foreach ($backups as $b):
						echo '<tr>
					<td>'.$i++.'</td>
					<td>'.$b->backup_file_name.'</td>								
					<td>'.date('d-m-Y',strtotime($b->last_updated)).'</td>
					<td><a href="'.base_url().'backup/'.$b->backup_file_name.'" class="btn btn-success btn-xs">Download <i class="fa fa-download"></i></button></td>
				</tr>';
				endforeach;
				?>						
			</tbody>
		</table>
	</div>
</div>
</div>
</div>
</div>
<script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){

		// Check Updates Button 
		$('#check').click(function(){
			$(this).html('Please wait checking  <i class="fa fa-spinner fa-spin fa-fw"></i>').removeClass('btn-danger').addClass('btn-warning');
			$.get('<?php echo base_url(); ?>admin/new_updates/get_updates',function(res){
				var obj = jQuery.parseJSON(res);
				if(obj.build){
					$('#filename').val(obj.filename) // storing new file name in hidden text box 
					$('#check').hide();
					$('#download').removeClass('hidden');
				}else{
					$('#check').html('Already Updated <i class="fa fa-warning"></i>').removeClass('btn-danger').addClass('btn-warning');
				}
			});
		});
		// Download Button click 

		$('#download').click(function(){
			var filename = $('#filename').val();
			if(filename!=''){
				$(this).html('Please wait downloading  <i class="fa fa-spinner fa-spin fa-fw"></i>').removeClass('btn-success').addClass('btn-warning');
				window.open('https://www.dreamguys.co.in/gigs_updates/'+filename,'_self');
				$('#download').html('Download again <i class="fa fa-download">').removeClass('btn-warning').addClass('btn-success');	
			}
			
		});
		// Upload Button click 
		$('#upload').click(function(){
			$('form')[0].reset();
			$('#upload_file').click();
		});
		$('#upload_file').change(function(){
			var formData = new FormData($('#upload_form')[0]);
			$.ajax({
				url: '<?php echo base_url();?>admin/new_updates/upload_updates',
				type: 'POST',
				data: formData,
				async: false,
				success: function(data) {   
					var obj =jQuery.parseJSON(data);
					if(obj.success){
						$('.notify').html('<div class="alert alert-success fade in alert-dismissable">'+
							'<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>'+
							'<strong>Success!</strong> New Version updated successfully !'+
							'</div>');
						setTimeout(function() {
							window.location.reload();
						}, 1000);
					}else if(obj.error){
						$('.notify').html('<div class="alert alert-danger fade in alert-dismissable">'+
							'<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>'+
							'<strong>'+obj.error+'</strong> '+
							'</div>');
					}
				},
				error: function(data){

					$('.notify').html('<div class="alert alert-danger fade in alert-dismissable">'+
						'<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>'+
						'<strong>Sorry! Some problem occcurs try again later !</strong>'+
						'</div>');

				},
				cache: false,
				contentType: false,
				processData: false
			}); 
			$('#upload_form')[0].reset();
			return false; 

		});
		$('.backup_btn').click(function(){
			$(this).hide();
			$('.loading').show();
		
		});

	});
</script>