<?php
	$query = $this->db->query("select * from system_settings WHERE status = 1");
	$result = $query->result_array();
	$this->website_name = '';
	 $fav=base_url().'assets/images/feelerz.png';
	if(!empty($result))
	{
	foreach($result as $data){
	if($data['key'] == 'website_name'){
	$this->website_name = $data['value'];
	}
		if($data['key'] == 'favicon'){
			 $favicon = $data['value'];
	}
	}
	}
	if(!empty($favicon))
	{
	$fav ='http://digimonk.net/social_media/assets/'.$favicon;
	
	    
	}
	
// 	$query1 = $this->db->query("select * from setting WHERE id = 1");
// 	$result1 = $query1->row_array();
// 	$this->profilepic = '';
// 	 $fav1=base_url().'uploads';
// 	if(!empty($result1))
// 	{

// 	if($result1['profilepic']){
//     	$this->profilepic = $result1['profilepic'];
// 	}
// 		if($result1['profilepic']){
// 			 $favicon1 = $result1['profilepic'];
	
// 	}
// 	}
	
// 	if(!empty($favicon1))
// 	{
//      	$fav1 = base_url().'uploads/'.$favicon1;
// 	}
	
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0' >
        <link rel="shortcut icon" href="<?php echo $fav; ?>">
        <title><?php echo $this->website_name.' Admin Panel'; ?></title>
        <!-- <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />-->
        <link href="<?php echo base_url(); ?>assets/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- <link href="<?php echo base_url(); ?>assets/css/materialdesignicons.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/css/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/css/bootstrap-switch.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/css/admin.css" rel="stylesheet" type="text/css" /> -->
        <link href="<?php echo base_url(); ?>assets/css/color-settings.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/css/login-register.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/css/main.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/css/vendor.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/css/dashboard.css" rel="stylesheet" type="text/css" />
        <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css" media="all" />

<style>
.custom-checkbox.custom-checkbox-primary .custom-control-input:checked ~ .custom-control-label:before,
                .custom-radio.custom-radio-primary .custom-control-input:checked ~ .custom-control-label:before {
                    background-color: PRIMARYCOLORVAL;
                    border-color: PRIMARYCOLORVAL;
                }
            
                .custom-checkbox.custom-checkbox-secondary .custom-control-input:checked ~ .custom-control-label:before,
                .custom-radio.custom-radio-secondary .custom-control-input:checked ~ .custom-control-label:before {
                    background-color: SECONDARYCOLORVAL;
                    border-color: SECONDARYCOLORVAL;
                }
            
                .custom-checkbox.custom-checkbox-success .custom-control-input:checked ~ .custom-control-label:before,
                .custom-radio.custom-radio-success .custom-control-input:checked ~ .custom-control-label:before {
                    background-color: SUCCESSCOLORVAL;
                    border-color: SUCCESSCOLORVAL;
                }
            
                .custom-checkbox.custom-checkbox-warning .custom-control-input:checked ~ .custom-control-label:before,
                .custom-radio.custom-radio-warning .custom-control-input:checked ~ .custom-control-label:before {
                    background-color: WARNINGCOLORVAL;
                    border-color: WARNINGCOLORVAL;
                }
            
                .custom-checkbox.custom-checkbox-danger .custom-control-input:checked ~ .custom-control-label:before,
                .custom-radio.custom-radio-danger .custom-control-input:checked ~ .custom-control-label:before {
                    background-color: DANGERCOLORVAL;
                    border-color: DANGERCOLORVAL;
                }
            
                .custom-checkbox.custom-checkbox-info .custom-control-input:checked ~ .custom-control-label:before,
                .custom-radio.custom-radio-info .custom-control-input:checked ~ .custom-control-label:before {
                    background-color: INFOCOLORVAL;
                    border-color: INFOCOLORVAL;
                }
            
                .custom-checkbox.custom-checkbox-light .custom-control-input:checked ~ .custom-control-label:before,
                .custom-radio.custom-radio-light .custom-control-input:checked ~ .custom-control-label:before {
                    background-color: LIGHTCOLORVAL;
                    border-color: LIGHTCOLORVAL;
                }
            
                .custom-checkbox.custom-checkbox-dark .custom-control-input:checked ~ .custom-control-label:before,
                .custom-radio.custom-radio-dark .custom-control-input:checked ~ .custom-control-label:before {
                    background-color: DARKCOLORVAL;
                    border-color: DARKCOLORVAL;
                }
            
                .material-checkbox.material-checkbox-primary .custom-control-input:checked ~ .custom-control-label:before {
                    border-color: PRIMARYCOLORVAL;
                }
            
                .material-checkbox.material-checkbox-success .custom-control-input:checked ~ .custom-control-label:before {
                    border-color: SUCCESSCOLORVAL;
                }
            
                .material-checkbox.material-checkbox-secondary .custom-control-input:checked ~ .custom-control-label:before {
                    border-color: SECONDARYCOLORVAL;
                }
            
                .material-checkbox.material-checkbox-warning .custom-control-input:checked ~ .custom-control-label:before {
                    border-color: WARNINGCOLORVAL;
                }
            
                .material-checkbox.material-checkbox-danger .custom-control-input:checked ~ .custom-control-label:before {
                    border-color: DANGERCOLORVAL;
                }
            
                .material-checkbox.material-checkbox-info .custom-control-input:checked ~ .custom-control-label:before {
                    border-color: INFOCOLORVAL;
                }
            
                .material-checkbox.material-checkbox-light .custom-control-input:checked ~ .custom-control-label:before {
                    border-color: LIGHTCOLORVAL;
                }
            
                .material-checkbox.material-checkbox-dark .custom-control-input:checked ~ .custom-control-label:before {
                    border-color: DARKCOLORVAL;
                }
            
                .material-radio.material-radio-primary .custom-control-input:checked ~ .custom-control-label:before {
                    border-color: PRIMARYCOLORVAL;
                }
            
                .material-radio.material-radio-primary .custom-control-input:checked ~ .custom-control-label:after {
                    background-color: PRIMARYCOLORVAL;
                }
            
                .material-radio.material-radio-success .custom-control-input:checked ~ .custom-control-label:before {
                    border-color: SUCCESSCOLORVAL;
                }
            
                .material-radio.material-radio-success .custom-control-input:checked ~ .custom-control-label:after {
                    background-color: SUCCESSCOLORVAL;
                }
            
                .material-radio.material-radio-secondary .custom-control-input:checked ~ .custom-control-label:before {
                    border-color: SECONDARYCOLORVAL;
                }
            
                .material-radio.material-radio-secondary .custom-control-input:checked ~ .custom-control-label:after {
                    background-color: SECONDARYCOLORVAL;
                }
            
                .material-radio.material-radio-warning .custom-control-input:checked ~ .custom-control-label:before {
                    border-color: WARNINGCOLORVAL;
                }
            
                .material-radio.material-radio-warning .custom-control-input:checked ~ .custom-control-label:after {
                    background-color: WARNINGCOLORVAL;
                }
            
                .material-radio.material-radio-danger .custom-control-input:checked ~ .custom-control-label:before {
                    border-color: DANGERCOLORVAL;
                }
            
                .material-radio.material-radio-danger .custom-control-input:checked ~ .custom-control-label:after {
                    background-color: DANGERCOLORVAL;
                }
            
                .material-radio.material-radio-info .custom-control-input:checked ~ .custom-control-label:before {
                    border-color: INFOCOLORVAL;
                }
            
                .material-radio.material-radio-info .custom-control-input:checked ~ .custom-control-label:after {
                    background-color: INFOCOLORVAL;
                }
            
                .material-radio.material-radio-light .custom-control-input:checked ~ .custom-control-label:before {
                    border-color: LIGHTCOLORVAL;
                }
            
                .material-radio.material-radio-light .custom-control-input:checked ~ .custom-control-label:after {
                    background-color: LIGHTCOLORVAL;
                }
            
                .material-radio.material-radio-dark .custom-control-input:checked ~ .custom-control-label:before {
                    border-color: DARKCOLORVAL;
                }
            
                .material-radio.material-radio-dark .custom-control-input:checked ~ .custom-control-label:after {
                    background-color: DARKCOLORVAL;
                }
                
                .modal-backdrop  {
    position: inherit !important;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    z-index: 1040;
    background-color: #000;
}
                </style>

                <style type="text/css">
	.sanjeev-table .no-footer .row{width:100%;}
	.sanjeev-table .no-footer .row table.dataTable{border-collapse: collapse !important;}
	.sanjeev-table div .row .col-sm-6 .dataTables_length label{float:left;}
	.sanjeev-table div .row .col-sm-6 .dataTables_length label select{margin:0 10px;}
	.sanjeev-table div .row .col-sm-6 .dataTables_filter label{float:left; margin-left: -134px;}


	 table.dataTable thead .sorting:after, table.dataTable thead .sorting_asc:after, table.dataTable thead .sorting_desc:after, table.dataTable thead .sorting_asc_disabled:after, table.dataTable thead .sorting_desc_disabled:after {
        background: url(img/ase-dsc.png) no-repeat; width:20px; height:20px; font-size:0px;
}
table.dataTable thead .sorting_desc:after {
    background: url(img/ase-dsc.png) no-repeat; width:20px; height:20px; font-size:0px;
}
table.dataTable thead .sorting_asc:after {
    background: url(img/ase-dsc2.png) no-repeat; width:20px; height:20px; font-size:0px;
}


.data-table-wrapper .data-table tr .img.sam img {
    width: 100%;
    height: auto;
}
.data-table-wrapper .data-table tr .img.sam2 img {
    width: 100%;
    height: 420px;
}



/*manage image css*/

.sanjeev-table .no-footer .row{width:100%;}
    .sanjeev-table .no-footer .row table.dataTable{border-collapse: collapse !important;}
    .sanjeev-table div .row .col-sm-6 .dataTables_length label{float:left;}
    .sanjeev-table div .row .col-sm-6 .dataTables_length label select{margin:0 10px;}
    .sanjeev-table div .row .col-sm-6 .dataTables_filter label{float:left; position:relative; left:-110px;}
     .sp-button{     position: absolute;    right: 35px; }
     .sanjeev-table .card img:not(.img-fluid) {    width: 100%;    height: 250px;    object-fit: fill; }
     .sanjeev-table .card {    width: 65%;    height: auto;    margin: 0 auto;    display: block;}
     
     table.dataTable thead .sorting:after, table.dataTable thead .sorting_asc:after, table.dataTable thead .sorting_desc:after, table.dataTable thead .sorting_asc_disabled:after, table.dataTable thead .sorting_desc_disabled:after {
        background: url(img/ase-dsc.png) no-repeat; width:20px; height:20px; font-size:0px;
}
table.dataTable thead .sorting_desc:after {
    background: url(img/ase-dsc.png) no-repeat; width:20px; height:20px; font-size:0px;
}
table.dataTable thead .sorting_asc:after {
    background: url(img/ase-dsc2.png) no-repeat; width:20px; height:20px; font-size:0px;
}







textarea {
  border: 0;
  font-size: 13px;
  height: 30px; 
  -webkit-box-sizing: content-box;
  min-height: 30px;
  line-height: 30px;
  margin: 0;
  padding: 0 10px;
  width: calc(100% - 20px) !important;
}

.box {
  background: #FFF;
  border-radius: 4px;
  box-shadow: 0 0 50px 5px rgba(0,0,0,.25);
  height: auto;
  margin: 30px auto 40px;
  max-width: 100%;
  overflow: hidden;
  padding: 20px 0 0;
  position: relative;
}
.box > [class*="box-"] {
  margin: 0 auto;
  padding: 0 30px;
  position: relative;
}
.box > [class*="box-"] img {
  display: block;
  width: 100%;
}
.box > .box-header {
  margin: 0 auto;
  padding: 0 30px 10px;
  width: initial;
}
.box > .box-header > h3 {
  font-size: 15px;
  font-weight: 700;
  height: 60px;
  margin: 5px auto; text-align:left;
  overflow: hidden;
  padding: 5px 0 0;
  position: relative;
}
.box > .box-header > h3 > a {
  margin: 0;
  overflow: hidden;
  padding: 0;
  position: relative;
}
.box > .box-header > h3 > span {
  color: #9197A3;
  display: block;
  font-size: 13px;
  font-weight: 400;
}
.box > .box-header > h3 > span .fa {
  font-size: 15px;
  margin-left: 5px;
}
.box > .box-header > span {
  background: #F4F4F4;
  border-radius: 3px;
  color: #BCBFC6;
  cursor: pointer;
  font-size: 24px;
  height: 18px;
  line-height: 18px;
  margin: 5px auto 0;
  padding: 3px 4px;
  position: absolute;
  right: 40px;
  top: 0;
}
.box > .box-header > span:hover {
  color: #888;
}
.box > .box-header > span > i {
  height: 18px;
  line-height: 18px;
}
.box > .box-header img {
  border-radius: 100px;
  float: left;
  height: 60px;
  margin: 3px 10px 0 0;
  object-fit: cover;
  width: 60px;
}
.box > .box-content {
  margin: 0;
  overflow: hidden;
  padding: 0;
  position: relative;
  width: initial;
}
.box > .box-content > .content {
  height: auto;
  margin: 0;
  overflow: hidden;
  padding: 0;
  position: relative;
  width: initial;
}
.box > .box-content > .bottom {
  margin: 0 auto;
  padding: 0 30px; 
  position: relative;
  width: initial;
}
.box > .box-content > .bottom > p {
  color: #71747A;
  font-size: 15px;
  line-height: 20px;
  margin: 0;
  padding: 20px 0;
}
.box > .box-content > .bottom > span {
  background: linear-gradient(to top, rgba(0,0,0,.45), rgba(0,0,0,0));
  height: 160px;
  left: 0;
  line-height: 160px;
  margin: 0 auto;
  overflow: hidden;
  padding: 0;
  position: absolute;
  text-align: right;
  top: -160px;
  vertical-align: bottom;
  width: 100%;
}
.box > .box-content > .bottom > span > span {
  background: rgba(0,0,0,.35);
  border-radius: 4px;
  bottom: 0;
  color: #FFF;
  cursor: pointer;
  font-size: 20px;
  margin: 0 30px 25px auto;
  opacity: .75;
  overflow: hidden;
  padding: 10px;
  position: absolute;
  right: 0;
  top: auto;
  -webkit-transition: all .25s ease-in-out;
     -moz-transition: all .25s ease-in-out;
          transition: all .25s ease-in-out;
}
.box > .box-content > .bottom > span > span:hover {
  opacity: 1;
}
.box > .box-likes {
  margin: 0 auto;
  overflow: hidden;
  padding: 0 30px;
  position: relative;
}
.box > .box-likes > .row {
  border-top: 1px solid #F4F4F4;
  padding: 20px 0;
}
.box > .box-likes > .row > span {
  display: inline-block;
  font-size: 13px;
  margin: 0 2px 0 0;
  position: relative;
  vertical-align: middle;
}
.box > .box-likes > .row:first-child {
  float: left;
  width: 60%;
}
.box > .box-likes > .row:last-child {
  float: left;
  text-align: end;
  width: 40%;
}
.box > .box-likes > .row:first-child > span:nth-child(4) {
  background: #4D679F;
  border-radius: 50px;
  font-weight: bold;
  padding: 0 8px 0 6px;
}
.box > .box-likes > .row:first-child > span:nth-child(4) > a {
  color: #FFF;
}
.box > .box-likes > .row:first-child > span,
.box > .box-likes > .row:last-child > span {
  color: #9197A3;
}
.box > .box-likes > .row:last-child > span {
  display: inline-block;
  verrtical-align: middle;
}
.box > .box-likes > .row img {
  border-radius: 100px;
  height: 28px;
  object-fit: cover;
  width: 28px;
}
.box > .box-buttons {
  margin: 0 auto;
  overflow: hidden;
  padding: 0;
  position: relative;
}
.box > .box-buttons *,*::before,*::after {
  -webkit-box-sizing: border-box;
     -moz-box-sizing: border-box;
          box-sizing: border-box;
}
.box > .box-buttons > .row {
  border-bottom: 1px solid #F4F4F4;
  border-top: 1px solid #F4F4F4;
  overflow: hidden;
  padding: 0;
  position: relative;
}
.box > .box-buttons > .row > button:last-child {
  border: 0;
}
.box > .box-buttons > .row > button {
  background: #FFF;
  border: 0;
  border-right: 1px solid #F4F4F4;
  color: #9197A3;
  font-size: 20px;
  float: left;
  height: 40px;
  line-height: 40px;
  margin: 0;
  *outline: 1px #08F;
  padding: 0;
  width: 33.33333333333%;
}
.box > .box-buttons > .row > button:hover {
  background: #F5F5F5;
  color: #7D8696;
}
.box > .box-buttons > .row > button:focus {
  background: #F0F2F2;
  color: #6C7588;
  box-shadow: inset 0 0 10px rgba(0,0,0,.2);
  outline-color: #08F;
}
.box > .box-click {
  color: #4D679F;
  font-size: 13px;
  margin: 0 auto; text-align:left;
  overflow: hidden;
  padding: 10px 30px;
  position: relative;
}
.box > .box-click > span {
  cursor: pointer;
}
.box > .box-click > span i {
  font-size: 18px;
  margin-right: 5px;
}
.box > .box-comments {
  margin: 0;
  overflow: hidden;
  padding: 0;
  position: relative;
}
.box > .box-comments > .comment {
  border-top: 1px solid #F4F4F4;
  margin: 0;
  overflow: hidden;
  padding: 16px 30px;
  position: relative;
}
.box > .box-comments > .comment > img {
  border-radius: 100px;
  float: left;
  height: 56px;
  margin: 0;
  object-fit: cover;
  width: 56px;
}
.box > .box-comments > .comment > .content {
  height: auto;
  line-height: 20px;
  margin: 0 0 0 70px;
  overflow: hidden;
  padding: 0;
  position: relative;
  width: initial;
}
.box > .box-comments > .comment > .content > h3 {
  float: left;
  font-size: 14px;
  font-weight: 600;
  margin: 4px auto 0;
  text-transform: capitalize;
  width: 150px;
}
.box > .box-comments > .comment > .content > h3 > span {
  color: #9197A3;
  display: block;
  font-size: 12px;
  font-weight: 400;
  text-transform: none;
}
.box > .box-comments > .comment > .content > p {
  color: #4B4D53;
  font-size: 13px;
  margin: 0;
  padding: 0;
}
.box > .box-new-comment {
  background: #9298A4;
  margin: 0;
  overflow: hidden;
  padding: 20px 30px;
  position: relative;
}
.box > .box-new-comment > img {
  border-radius: 100px;
  float: left;
  height: 40px;
  margin: 0;
  object-fit: cover;
  width: 40px;  
}
.box > .box-new-comment > .content {
  border-radius: 20px;
  margin: 4px 0 0 52px;
  overflow: hidden;
  padding: 0;
  position: relative;
  width: initial;
  -webkit-transition: all .25s ease-in-out;
     -moz-transition: all .25s ease-in-out;
          transition: all .25s ease-in-out;
}
.box > .box-new-comment > .content > .row {
  background: transparent;
  display: inline-block;
  height: 32px;
  overflow: hidden;
  position: relative;
  vertical-align: middle;
  width: 100%;
  -webkit-transition: all .25s ease-in-out;
     -moz-transition: all .25s ease-in-out;
          transition: all .25s ease-in-out;
}
.box > .box-new-comment > .content > .row:last-child {
  color: #C6C9D0;
  font-size: 22px;
  height: 28px;
  line-height: 27px;
  margin: 2px 0;
  position: absolute;
  text-align: center;
  top: 0;
  right: 10px;
  width: 40px;
}
.box > .box-new-comment > .content > .row:last-child > span {cursor: pointer;}
.box > .box-new-comment > .content > .row > textarea {
  border: 1px solid transparent;
  border-radius: 20px;
  color: #555;
  outline: 0;
  padding: 0 40px 0 10px;
  resize: none;
  width: calc(100% - 52px) !important;
  -webkit-transition: all .25s ease-in-out;
     -moz-transition: all .25s ease-in-out;
          transition: all .25s ease-in-out;
}
.box.update,
.box.text {
  border: 1px solid #E0E1E4;
  box-shadow: none;
  padding: 20px 0 0;
}
.box.update > .box-header,
.box.text > .box-header {
  padding: 0 30px;
}
.box.update > .box-header > span,
.box.text > .box-header > span{
  background: transparent;
  color: #9298A4;
  font-size: 32px;
  margin: -10px auto 0;
}
.box.update > .box-content > .content > p,
.box.text > .box-content > .content > p {
  border-top: 1px solid #F4F4F4;
  color: #4D5057;
  font-size: 14px; text-align:left;
  line-height: 22px;
  padding: 26px 30px;
}
.box.update > .box-content > .content > .img {
  margin: 0;
  overflow: hidden;
  padding: 0;
  position: relative;
  width: initial;
}
.box.update > .box-content > .content > .img:before {
  border: 1px solid rgba(0,0,0,.25);
  bottom: 0;
  content: "";
  height: 100%;
  left: 0;
  position: absolute;
  right: 0;
  top: 0;
  width: 100%;
}
.dik h5{font-size: 14px;    font-weight: normal;    color: #7387b4;}
.dik li a:hover{text-decoration:none;}
#example2 td a.sssde{color:#fff;}
.box.text > .box-buttons > .row > button {
  font-size: 13px;
}
.box.text > .box-buttons > .row > button > span {
  font-size: 20px;
}
.box.image > .box-new-comment > .content,
.box.image > .box-new-comment > .content > .row > textarea,
.box.video > .box-new-comment > .content,
.box.video > .box-new-comment > .content > .row > textarea {
  background: #9298A4;
  -webkit-transition: all .25s ease-in-out;
     -moz-transition: all .25s ease-in-out;
          transition: all .25s ease-in-out;  
}
.box > .box-new-comment > .content > .row > textarea:focus,
.box.image > .box-new-comment > .content:active > .row {background: #FFF;}
.box > .box-new-comment > .content > .row > textarea:focus,
.box.video  .box-new-comment > .content:active > .row {background: #FFF;}


/*end of manage image css*/


/* start manage video css */
.sanjeev-table div .row .col-sm-6 .dataTables_filter label{float:left; position:relative; left:-110px;}
.sanjeev-table .card img:not(.img-fluid) {    width: 100%;    height: 250px;    object-fit: fill; }		
	 .sanjeev-table .card {    width: 65%;    height: auto;    margin: 0 auto;    display: block;}
	 
	 /*end of manage video css*/




	</style>
        <!--[if lt IE 9]>
			<script src="<?php echo base_url(); ?>assets/js/html5shiv.js"></script>
			<script src="<?php echo base_url(); ?>assets/js/respond.min.js"></script>
        <![endif]-->
        <script src="<?php echo base_url(); ?>assets/js/modernizr.min.js"></script>
    </head>
    <body class="nav-md theme-green">
    <div class="main-container">
        