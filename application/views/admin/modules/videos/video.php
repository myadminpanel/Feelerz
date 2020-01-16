 <!-- page content -->
            <div class="main-content small-gutter">
                <!-- START PAGE COVER -->
                <div class="row bg-title clearfix page-title">
                    <div class="col-12 col-lg-3">
                        <h4 class="page-title">Manage Videos</h4>
                    </div>
                    <div class="col-12 col-lg-9">
                        <!-- START breadcrumb -->
                        <ol class="breadcrumb pl-0 pr-0 float-lg-right">
                            <li><a href="index.html">User Dashboard</a></li>
                            <li class="active">Manage Videos</li>
                        </ol>
                        <!-- END breadcrum -->
                    </div>
                    <!--<div class="col-12">
                        <h3>Form Layouts</h3>
                    </div>-->
                </div>
                <!-- END PAGE COVER -->
                <div class="container-fluid">
                    <div class="row">
                        
	
	<div class="col-lg-12 col-xl-12 mb-2">
                            <div class="bg-white padding-25 h-100">
                                <h4 class="mt-0 box-title">Videos List</h4>
                                <div class="data-table-wrapper">
                                    <div class="row">
                                        <!--<div class="col-sm-12 col-lg-4 col-xl-6">
                                            <div class="data-table-filter mb-2 float-sm-left float-lg-none d-lg-inline-block">
                                                <label for="search1">Search:</label>
                                                <input type="search" class="form-control" id="search1">
                                            </div>
                                        </div>
	<div class="col-sm-12 col-lg-4 col-xl-4">
                                            <div class="data-table-length">
                                                <label>
                                                    Show
                                                    <select aria-controls="example" class="form-control">
                                                        <option value="10">10</option>
                                                        <option value="25">25</option>
                                                        <option value="50">50</option>
                                                        <option value="100">100</option>
                                                    </select>
                                                    entries
                                                </label>
                                            </div>
                                        </div>-->
                                       
                                            
                                            <div class="actions ml-md-3 mb-2 text-sm-right d-lg-inline-block sp-button sss">
	
	<button id="ids_for_dele" class="btn btn-danger btn-raised ripple">
	<span>Delete Videos</span>
	</button>
                                            </div>
                                       
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="table-responsive sanjeev-table">
                                                <table id="example2" class="table table-striped table-bordered data-table table-checkable mb-0" role="grid">
                                                    <thead style="display:none;">
                                                    <tr>
                                                        <!--<th tabindex="0" aria-controls="example" rowspan="1" colspan="1">
                                                            <div class="form-check">
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" id="tableCheckbox1">
                                                                    <label class="custom-control-label" for="tableCheckbox1"></label>
                                                                </div>
                                                            </div>
                                                        </th>-->
                                                        <th tabindex="0" aria-controls="example" rowspan="1" colspan="1" aria-label="Name: activate to sort column descending">&nbsp;</th>
                                                        
                                                    </tr>
                                                    </thead>
                                                    <tbody style="background-color: #fff;">
                                                         <?php 
                   
                    foreach($list as $videodata) { ?>
                                                    <tr style="background-color: #fff;">
                                                        <!--<td>
                                                          <div class="form-check">
                                                                <div class="custom-control custom-checkbox custom-checkbox-primary">
                                                                    <input type="checkbox" class="custom-control-input checkitem" id="tableCheckbox222">
                                                                    <label class="custom-control-label" for="tableCheckbox222"></label>
                                                                </div>
                                                            </div>  
                                                        </td>-->
                                                        <td style="border: 1px solid #ffffff;">
	<div class="box update" style="margin: 0;">
      <div class="box-header">
          <div class="form-check" style="float:left;">
                                                                <div class="custom-control custom-checkbox custom-checkbox-primary">
                                                                    <input type="checkbox" class="custom-control-input checkitem" name="same1[]" id="tableCheckbox222_<?php echo $videodata['id']; ?>" value="<?php echo $videodata['id']; ?>"                                                                    <label class="custom-control-label" for="tableCheckbox222"></label>
                                                               <input type="hidden" class="custom-control-input checkitem" name="same1[]" >
                       <label class="custom-control-label" for="tableCheckbox222_<?php echo $videodata['id']; ?>"></label>
                                                               
                                                                </div>
                                                            </div>  
         <h3><a href=""><img src="https://goo.gl/oOD0V2" alt="">Roswell Parian</a>
       <span style="margin-top:0px !important;">March 21,18:45pm <i class="fa fa-globe"></i></span>
       </h3>
        <span>
            
	<button class="btn btn-info btn-raised ripple">
	<span>Unblock</span>
	</button>
        </span>
        <div class="window"><span></span></div>
      </div>
      <div class="box-content">
        <div class="content">
          <p><?php echo $videodata['description']; ?></p>
          <div class="img"><video class="img-thumbnail" controls="" width="100%">
	<source src="<?php base_url()?>../assets/videos/<?php echo $videodata['video']; ?>" type="video/webm">
	</video></div>
        </div>
      </div>
      <div class="box-likes">
        <div class="row">
          <span><a href="#"><img src="https://goo.gl/oM0Y8G" alt=""></a></span>
          <span><a href="#"><img src="https://goo.gl/vswgSn" alt=""></a></span>
          <span><a href="#"><img src="https://goo.gl/4W27eB" alt=""></a></span>

        </div>
        <div class="row">
          <span>145 comments</span>
        </div>
      </div>
      <div class="box-buttons">
        <div class="row">
          <button><span class="fa fa-thumbs-up"></span></button>
          <button><span class="fa fa-comments-o"></span></button>
          <button><span class="fa fa-share-alt"></span></button>
        </div>
      </div>
      <div class="box-click"><span><i class="fa fa-comments-o"></i> View 140 more comments</span></div>
      <div class="box-comments">
        <!--<div class="comment"><img src="https://goo.gl/oM0Y8G" alt="">
          <div class="content">
            <h3><a href="">Emily Rudd</a><span><time> 1 hr - </time><a href="#">Like</a></span></h3>
            <p>The nature is wonderfull, :D loll </p>
          </div>
        </div>
        <div class="comment"><img src="https://goo.gl/vswgSn" alt="">
          <div class="content">
            <h3><a href="">barbara Palvin</a><span><time> 1 hr - </time><a href="#">Like</a></span></h3>
            <p>The Image is awesome, &lt;3 Nice Photo</p>
          </div>
        </div>-->
      </div>
        <div class="box-new-comment">
          <img src="https://goo.gl/oOD0V2" alt="">
          <div class="content">
            <div class="row">
              <textarea placeholder="write a comment..."></textarea>
            </div>
            <div class="row">
              <span class="ion-android-attach"></span>
              <span class="fa fa-smile-o"></span>
            </div>
          </div>
        </div>
    </div>

      <!--<div class="box-click"><span><i class="fa fa-comments-o"></i> View 140 more comments</span></div>-->
      <div class="box-comments">
        <!--<div class="comment"><img src="https://goo.gl/oM0Y8G" alt="">
          <div class="content">
            <h3><a href="">Emily Rudd</a><span><time> 1 hr - </time><a href="#">Like</a></span></h3>
            <p>The nature is wonderfull, :D loll </p>
          </div>
        </div>
        <div class="comment"><img src="https://goo.gl/vswgSn" alt="">
          <div class="content">
            <h3><a href="">barbara Palvin</a><span><time> 1 hr - </time><a href="#">Like</a></span></h3>
            <p>The Image is awesome, &lt;3 Nice Photo</p>
          </div>
        </div>-->
      </div>
       
    </div>
	</td>
                                                    </tr>
                                                  <?php } ?>
                                                    </thead>
                                                   
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
	<div class="row">&nbsp;</div>
                                </div>
                            </div>
                        </div>
	
	
	
	
                      
	
                    </div>
                </div>
            </div>
            <!-- /page content -->