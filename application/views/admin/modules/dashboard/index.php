

            <!-- theme settings-->
            <div class="settings-wrapper builder d-none d-md-block" id="builder">
                <div class="p-l-20 p-r-20">
                    <!--<a id="builder-close" class="builder-close settings-toggle" href="javascript:void(0)" title="Close">
                        <i class="fa fa-close" aria-hidden="true"></i>
                    </a>
                    <a id="builder-toggle" class="builder-toggle" title="Settings">
                        <i class="fa fa-cog fa-spin" aria-hidden="true"></i>
                    </a>-->
                    <ul class="nav nav-tabs nav-tabs-simple nav-tabs-simple-bottom nav-justified" id="settingsTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="layouts-tab" data-toggle="tab" href="#layouts" role="tab" aria-controls="layouts" aria-expanded="true">Layout settings</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="colors-tab" data-toggle="tab" href="#colors" role="tab" aria-controls="colors" aria-expanded="false">Custom Colors</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="settingsTabContent">
                        <div role="tabpanel" class="tab-pane fade active show" id="layouts" aria-labelledby="layouts-tab" aria-expanded="true">
                            <div class="scroll-wrapper">
                                <div class="scroll-content">
                                    <div>
                                        <h5 class="semi-bold">
                                            Layout color options
                                        </h5>
                                        <div class="sidebar-settings m-b-10">
                                            <p class="hint-text mb-0">
                                                Sidebar color.
                                            </p>
                                            <button type="button" class="btn btn-outline-primary btn-activate-sidebar mt-2 active" title="Light Sidebar" id="activate-light-sidebar">
                                                Light
                                            </button>
                                            <button type="button" class="btn btn-outline-primary btn-activate-sidebar mt-2" title="Dark Sidebar" id="activate-dark-sidebar">
                                                Dark
                                            </button>
                                        </div>
                                        <div class="header-settings m-b-10">
                                            <p class="hint-text mb-0">
                                                Header color.
                                            </p>
                                            <button type="button" class="btn btn-outline-info btn-activate-header mt-2" title="Light Header" id="activate-light-header">
                                                Light
                                            </button>
                                            <button type="button" class="btn btn-outline-info btn-activate-header mt-2 active" title="Dark Header" id="activate-dark-header">
                                                Dark
                                            </button>
                                        </div>
            
                                        <div class="m-b-10">
                                            <p class="hint-text mb-0">
                                                Main color of your theme
                                            </p>
                                            <button type="button" class="btn btn-outline-green btn-activate-color btn-raised mt-2 btn-circle active" id="activate-green" title="Green">
                                                <i class="fa fa-check" aria-hidden="true"></i>
                                            </button>
                                            <button type="button" class="btn btn-outline-purple btn-activate-color btn-raised mt-2 btn-circle" id="activate-purple" title="Purple">
                                                <i class="fa fa-check" aria-hidden="true"></i>
                                            </button>
                                            <button type="button" class="btn btn-outline-red btn-activate-color btn-raised mt-2 btn-circle" id="activate-red" title="Red">
                                                <i class="fa fa-check" aria-hidden="true"></i>
                                            </button>
                                            <button type="button" class="btn btn-outline-cyan btn-activate-color btn-raised mt-2 btn-circle" id="activate-cyan" title="Cyan">
                                                <i class="fa fa-check" aria-hidden="true"></i>
                                            </button>
                                            <button type="button" class="btn btn-outline-orange btn-activate-color btn-raised mt-2 btn-circle" id="activate-orange" title="Orange">
                                                <i class="fa fa-check" aria-hidden="true"></i>
                                            </button>
                                            <button type="button" class="btn btn-outline-grey btn-activate-color btn-raised mt-2 btn-circle" id="activate-grey" title="Grey">
                                                <i class="fa fa-check" aria-hidden="true"></i>
                                            </button>
                                            <p class="hint-text mt-2">Pick a Custom Theme Color</p>
                                            <input class="jscolor form-control btn-activate-color d-inline-block" id="activate-custom" value="4DD0E1" title="Pick a custom theme color">
                                        </div>
                                        <h5 class="semi-bold">
                                            Layout view options
                                        </h5>
                                        <div class="row">
                                            <div class="col-md-12 col-lg-12">
                                                <div class="card box-shadow-none">
                                                    <div class="card-body p-0">
                                                        <h5 class="card-title hint-text">Fixed full width header</h5>
                                                        <div class="layout-view layout-view-fixed-header d-flex align-items-center justify-content-center"
                                                             id="activate-fixed-header"
                                                             title="Activate Fixed Full Width Header">
                                                            <button type="button" class="card-link btn btn-theme btn-activate mt-2"></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
            
                                            <div class="col-md-12 col-lg-12">
                                                <div class="card box-shadow-none">
                                                    <div class="card-body p-0">
                                                        <h5 class="card-title hint-text">Left sidebar</h5>
                                                        <div class="layout-view active layout-view-left-sidebar d-flex align-items-center justify-content-center"
                                                             id="activate-left-sidebar"
                                                             title="Activate Left Sidebar">
                                                            <button type="button" class="card-link btn btn-theme btn-activate mt-2"></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
            
                                            <div class="col-md-12 col-lg-12">
                                                <div class="card box-shadow-none">
                                                    <div class="card-body p-0">
                                                        <h5 class="card-title hint-text">Right sidebar</h5>
                                                        <div class="layout-view layout-view-right-sidebar d-flex align-items-center justify-content-center"
                                                             id="activate-right-sidebar"
                                                             title="Activate Right Sidebar">
                                                            <button type="button" class="card-link btn btn-theme btn-activate mt-2"></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-lg-12">
                                                <div class="card box-shadow-none mb-0">
                                                    <div class="card-body p-0">
                                                        <h5 class="card-title hint-text">RTL Content</h5>
                                                        <div class="layout-view layout-view-rtl-content d-flex align-items-center justify-content-center"
                                                             id="activate-rtl-content"
                                                             title="Activate RTL Content">
                                                            <button type="button" class="card-link btn btn-theme btn-activate activate-rtl mt-2"></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="colors" role="tabpanel" aria-labelledby="colors-tab" aria-expanded="false">
                            <div class="scroll-wrapper">
                                <div class="scroll-content">
                                    <div>
                                        <h5 class="semi-bold">
                                            Color Options
                                        </h5>
                                        <p class="hint-text">
                                            Customize colors of your theme.
                                        </p>
                                        <div class="row mb-2">
                                            <div class="col-12">
                                                <div class="d-flex justify-content-between align-items-center color-settings-row">
                                                    <div>
                                                        <label>Pick a primary background color</label>
                                                        <input class="jscolor {position:'left'} form-control" id="primary-color" value="6d5cae" title="Pick a primary background color">
                                                        <label>Pick a primary text color</label>
                                                        <input class="jscolor {position:'left'} form-control" id="primary-text-color" value="ffffff" title="Pick a primary text color">
                                                    </div>
                                                    <div class="d-flex align-items-center">
                                                      <button class="btn mt-1 btn-prev" id="btn-primary-prev" title="Preview of primary color">Primary</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-12">
                                                <div class="d-flex justify-content-between align-items-center color-settings-row">
                                                    <div>
                                                        <label>Pick a secondary background color</label>
                                                        <input class="jscolor {position:'left'} form-control" id="secondary-color" value="cfd0d2" title="Pick a secondary background color">
                                                        <label>Pick a secondary text color</label>
                                                        <input class="jscolor {position:'left'} form-control" id="secondary-text-color" value="ffffff" title="Pick a secondary text color">
                                                    </div>
                                                    <div class="d-flex align-items-center">
                                                        <button class="btn mt-1 btn-prev" id="btn-secondary-prev" title="Preview of secondary color">Secondary</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-12">
                                                <div class="d-flex justify-content-between align-items-center color-settings-row">
                                                    <div>
                                                        <label>Pick a success background color</label>
                                                        <input class="jscolor {position:'left'} form-control" id="success-color" value="0aa89e" title="Pick a success background color">
                                                        <label>Pick a success text color</label>
                                                        <input class="jscolor {position:'left'} form-control" id="success-text-color" value="ffffff" title="Pick a success text color">
                                                    </div>
                                                    <div class="d-flex align-items-center">
                                                        <button class="btn mt-1 btn-prev" id="btn-success-prev" title="Preview of success color">Success</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
            
            
                                        <div class="row mb-2">
                                            <div class="col-12">
                                                <div class="d-flex justify-content-between align-items-center color-settings-row">
                                                    <div>
                                                        <label>Pick a info background color</label>
                                                        <input class="jscolor {position:'left'} form-control" id="info-color" value="4DD0E1" title="Pick a info background color">
                                                        <label>Pick a info text color</label>
                                                        <input class="jscolor {position:'left'} form-control" id="info-text-color" value="ffffff" title="Pick a info text color">
                                                    </div>
                                                    <div class="d-flex align-items-center">
                                                        <button class="btn mt-1 btn-prev" id="btn-info-prev" title="Preview of info color">Info</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
            
                                        <div class="row mb-2">
                                            <div class="col-12">
                                                <div class="d-flex justify-content-between align-items-center color-settings-row">
                                                    <div>
                                                        <label>Pick a warning background color</label>
                                                        <input class="jscolor {position:'left'} form-control" id="warning-color" value="ffaa00" title="Pick a warning background color">
                                                        <label>Pick a warning text color</label>
                                                        <input class="jscolor {position:'left'} form-control" id="warning-text-color" value="ffffff" title="Pick a warning text color">
                                                    </div>
                                                    <div class="d-flex align-items-center">
                                                        <button class="btn mt-1 btn-prev" id="btn-warning-prev" title="Preview of warning color">Warning</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
            
                                        <div class="row mb-2">
                                            <div class="col-12">
                                                <div class="d-flex justify-content-between align-items-center color-settings-row">
                                                    <div>
                                                        <label>Pick a danger background color</label>
                                                        <input class="jscolor {position:'left'} form-control" id="danger-color" value="e43a45" title="Pick a danger background color">
                                                        <label>Pick a danger text color</label>
                                                        <input class="jscolor {position:'left'} form-control" id="danger-text-color" value="ffffff" title="Pick a danger text color">
                                                    </div>
                                                    <div class="d-flex align-items-center">
                                                        <button class="btn mt-1 btn-prev" id="btn-danger-prev" title="Preview of danger color">Danger</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
            
                                        <div class="row mb-2">
                                            <div class="col-12">
                                                <div class="d-flex justify-content-between align-items-center color-settings-row">
                                                    <div>
                                                        <label>Pick a light background color</label>
                                                        <input class="jscolor {position:'left'} form-control" id="light-color" value="eaeef3" title="Pick a light background color">
                                                        <label>Pick a light text color</label>
                                                        <input class="jscolor {position:'left'} form-control" id="light-text-color" value="8e959d" title="Pick a light text color">
                                                    </div>
                                                    <div class="d-flex align-items-center">
                                                        <button class="btn mt-1 btn-prev" id="btn-light-prev" title="Preview of light color">Light</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
            
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="d-flex justify-content-between align-items-center color-settings-row">
                                                    <div>
                                                        <label>Pick a dark background color</label>
                                                        <input class="jscolor {position:'left'} form-control" id="dark-color" value="8e959d" title="Pick a dark background color">
                                                        <label>Pick a dark text color</label>
                                                        <input class="jscolor {position:'left'} form-control" id="dark-text-color" value="ffffff" title="Pick a dark text color">
                                                    </div>
                                                    <div class="d-flex align-items-center">
                                                        <button class="btn mt-1 btn-prev" id="btn-dark-prev" title="Preview of dark color">Dark</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="fixed-bottom-buttons">
                        <div class="mt-2">
                            <button type="button" id="btnOpenSaveSettingsModal" class="btn btn-theme btn-raised" data-toggle="modal" data-target="#save-settings-modal" title="Save Settings">
                                <i class="fa fa-check left" aria-hidden="true"></i><span>Save</span>
                            </button>
                            <button type="button" class="btn btn-theme btn-raised" id="btnPrevSettings" title="Preview Settings">
                                <i class="fa fa-clone left" aria-hidden="true"></i><span>Preview</span>
                            </button>
                            <button type="button" class="btn btn-light btn-raised" id="btnCancelSettings" title="Cancel Settings">
                                <i class="fa fa-ban left" aria-hidden="true"></i><span>Cancel</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Settings Modal -->
            <div class="modal fade" id="save-settings-modal" tabindex="-1" role="dialog" aria-labelledby="SaveModal" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="SaveModal">Save Settings</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <p>If you want to get this view in the project, you should change <code>body</code> classlist to this</p>
                                <p id="customized-body-classlist" class="font-weight-bold"></p>
                            </div>
                           <div>
                               <p>If you want to use these colors in the template, you should find and replace the code of this file <span class="text-success">src/sass/partials/default-colors.sass</span> to this code</p>
                               <p id="customized-css" class="font-weight-bold"></p>
                           </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-theme" id="btnSaveSettings">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /theme settings -->

            <!-- page content -->
            <div class="main-content small-gutter" role="main">
                <div class="row bg-title clearfix page-title">
                    <!--<div class="col-12 col-lg-3">
                        <h4 class="page-title">Welcome!</h4>
                    </div>-->
                    <div class="col-12 col-lg-9">
                        <ol class="breadcrumb pl-0 pr-0 float-lg-left">
                            <!--<li><a href="index.html">User Dashboard</a></li>-->
                            <li class="active">Dashboard</li>
                        </ol>
                    </div>
                </div>
                <!-- top tiles -->
               
                <div class="row tile-count">
                   
                    <div class="col-sm-6 col-md-6 col-lg-3 col-xl-3 tile-stats-count">
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-6"><i class="fa fa-users" aria-hidden="true"></i>
                                <h5 class="text-muted text-uppercase">Total App User</h5>
                            </div>
                            <div class="col-md-6 col-sm-6 col-6">
                                <h3 class="counter text-right m-t-15 text-info"><?php  print_r(count($total_user_count)); ?></h3>
                            </div>
                            <div class="col-12">
                                <!--<div class="progress progress-sm">-->
                                <!--    <div class="progress-bar bg-info w-50" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>-->
                                <!--</div>-->
                            </div>
                        </div>
                    </div>
                   
                    <div class="col-sm-6 col-md-6 col-lg-3 col-xl-3 tile-stats-count">
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-6"><i class="fa fa-flag" aria-hidden="true"></i>
                                <h5 class="text-muted text-uppercase">Total Reported Post</h5>
                            </div>
                            <div class="col-md-6 col-sm-6 col-6">
                                <h3 class="counter text-right m-t-15 text-primary"><?php  print_r(count($total_reported_count)); ?></h3>
                            </div>
                            <!--<div class="col-12">-->
                            <!--    <div class="progress progress-sm">-->
                            <!--        <div class="progress-bar bg-primary w-25" role="progressbar"  aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>-->
                            <!--    </div>-->
                            <!--</div>-->
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6 col-lg-3 col-xl-3 tile-stats-count">
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-6"> <i class="fa fa-smile-o" aria-hidden="true"></i>
                                <h5 class="text-muted text-uppercase">Total Feelings</h5>
                            </div>
                            <div class="col-md-6 col-sm-6 col-6">
                                <h3 class="counter text-right m-t-15 text-danger"><?php  print_r(count($total_feeling_count)); ?></h3>
                            </div>
                        <!--    <div class="col-12">-->
                        <!--        <div class="progress progress-sm">-->
                        <!--            <div class="progress-bar bg-danger w-25" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>-->
                        <!--        </div>-->
                        <!--    </div>-->
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6 col-lg-3 col-xl-3 tile-stats-count">
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-6"><i class="fa fa-envelope" aria-hidden="true"></i>
                                <h5 class="text-muted text-uppercase">Total Post</h5>
                            </div>
                            <div class="col-md-6 col-sm-6 col-6">
                                <h3 class="counter text-right m-t-15 text-success"><?php  print_r(count($total_post_count)); ?></h3>
                            </div>
                            <!--<div class="col-12">-->
                            <!--    <div class="progress progress-sm">-->
                            <!--        <div class="progress-bar bg-success w-75" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>-->
                            <!--    </div>-->
                            <!--</div>-->
                        </div>
                    </div>
                </div>
                <!-- /top tiles -->

                <div class="row">
                    
                    
                    <div class="col-12 mb-2">
                        <div class="table-responsive">
                        <div class="h-100 bg-white padding-25">
                            <h4 class="box-title mt-0">Recently Added User</h4>
                            <div class="table-responsive">
                                <table class="table mt-0 mb-0">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Status</th>
                                        <th>Last Login</th>
                                        <th>Country</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        
                                       <!--<?php var_dump($my_join); ?>-->
 

<?php  if(@$my_join) { foreach($my_join as $data) {

 $status = 'Active'; $set_class='badge-primary'; if($data['status']==0){$status = 'Deactive'; $set_class='badge-warning'; } 
                  
                 

?>

<tr>
                                        <td><?php echo @$data["name"]; ?></td>
                                        <td><span class="badge badge-pill <?php echo $set_class; ?> text-uppercase"> <?php echo @$status; ?></span> </td>
                                        <td><?php echo @$data["last_login"]; ?></td>
                                        <td><span class="text-primary"><?php echo @$data["country"]; ?></span></td>
                                    </tr>
<?php }  }  ?>
                                    
                                    
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    </div>
                    </div>
                    
                    
                    
            <!--<div class="row">-->
            <!--        <div class="col-12 col-lg-6 col-xl-4 mb-2">-->
            <!--            <div class="row h-100">-->
            <!--                <div class="col-12 mb-2 carousel-wrapper">-->
            <!--                    <div class="h-100 w-100 bg-primary padding-25 d-flex align-items-center justify-content-center">-->
            <!--                        <div id="dashboardCarousel1" class="carousel slide w-100 dashboard-carousel m-t-20" data-ride="carousel">-->
            <!--                            <ol class="carousel-indicators">-->
            <!--                                <li data-target="#dashboardCarousel1" data-slide-to="0" class=""></li>-->
            <!--                                <li data-target="#dashboardCarousel1" data-slide-to="1" class=""></li>-->
            <!--                                <li data-target="#dashboardCarousel1" data-slide-to="2" class="active"></li>-->
            <!--                            </ol>-->
            <!--                            <div class="carousel-inner h-100 w-100">-->
            <!--                                <div class="carousel-item active">-->
            <!--                                    <div class="text-left">-->
            <!--                                        <h4 class="mt-0">Manage App User</h4>-->
            <!--                                        <p class="m-0 hint-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eius, dolores facilis maiores minus itaque excepturi.</p>-->
            <!--                                    </div>-->
            <!--                                    <h2 class="m-t-20">-->
            <!--                                        <i class="fa fa-angle-down"></i>-->
            <!--                                        254,453-->
            <!--                                    </h2>-->
            <!--                                </div>-->
            <!--                                <div class="carousel-item">-->
            <!--                                    <div class="text-left">-->
            <!--                                        <h4 class="mt-0">Manage Country</h4>-->
            <!--                                        <p class="m-0 hint-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eius, dolores facilis maiores minus itaque excepturi.</p>-->
            <!--                                    </div>-->
            <!--                                    <h2 class="m-t-20">-->
            <!--                                        <i class="fa fa-angle-down"></i>-->
            <!--                                        58,634-->
            <!--                                    </h2>-->
            <!--                                </div>-->
            <!--                                <div class="carousel-item">-->
            <!--                                    <div class="text-left">-->
            <!--                                        <h4 class="mt-0">Manage Emoji</h4>-->
            <!--                                        <p class="m-0 hint-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eius, dolores facilis maiores minus itaque excepturi.</p>-->
            <!--                                    </div>-->
            <!--                                    <h2 class="m-t-20">-->
            <!--                                        <i class="fa fa-angle-up"></i>-->
            <!--                                        241,147-->
            <!--                                    </h2>-->
            <!--                                </div>-->
            <!--                            </div>-->
            <!--                        </div>-->
            <!--                    </div>-->
            <!--                </div>-->
            <!--                <div class="col-12 carousel-wrapper">-->
            <!--                    <div class="h-100 w-100 bg-info padding-25 d-flex align-items-center justify-content-center">-->
            <!--                        <div id="carouselExampleSlidesOnly2" class="carousel slide w-100" data-ride="carousel">-->
            <!--                            <div class="carousel-inner h-100 w-100">-->
            <!--                                <div class="carousel-item active">-->
            <!--                                    <div class="text-left">-->
            <!--                                        <p class="">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eius, dolores facilis maiores minus itaque excepturi.</p>-->
            <!--                                    </div>-->
            <!--                                    <div class="m-t-40">-->
            <!--                                        <div class="float-left mr-3">-->
            <!--                                            <img src="<?php echo base_url(); ?>assets/images/user-1.png" alt="User Image" class="rounded-circle profile-img">-->
            <!--                                        </div>-->
            <!--                                        <div class="text-left">-->
            <!--                                            <h6 class="m-0 hint-text">-->
            <!--                                                Share Public Post - 20m ago-->
            <!--                                            </h6>-->
            <!--                                            <h4 class="m-0">Richard Cook</h4>-->
            <!--                                        </div>-->
            <!--                                    </div>-->
            <!--                                </div>-->
            <!--                                <div class="carousel-item">-->
            <!--                                    <div class="text-left">-->
            <!--                                        <p class="">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eius, dolores facilis maiores minus itaque excepturi.</p>-->
            <!--                                    </div>-->
            <!--                                    <div class="m-t-40">-->
            <!--                                        <div class="float-left mr-3">-->
            <!--                                            <img src="<?php echo base_url(); ?>assets/images/user-2.png" alt="User Image" class="rounded-circle profile-img">-->
            <!--                                        </div>-->
            <!--                                        <div class="text-left">-->
            <!--                                            <h6 class="m-0 hint-text">-->
            <!--                                                Share Public Post - 2h ago-->
            <!--                                            </h6>-->
            <!--                                            <h4 class="m-0">Samuel Nelson</h4>-->
            <!--                                        </div>-->
            <!--                                    </div>-->
            <!--                                </div>-->
            <!--                                <div class="carousel-item">-->
            <!--                                    <div class="text-left">-->
            <!--                                        <p class="">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eius, dolores facilis maiores minus itaque excepturi.</p>-->
            <!--                                    </div>-->
            <!--                                    <div class="m-t-40">-->
            <!--                                        <div class="float-left mr-3">-->
            <!--                                            <img src="<?php echo base_url(); ?>assets/images/user-3.png" alt="User Image" class="rounded-circle profile-img">-->
            <!--                                        </div>-->
            <!--                                        <div class="text-left">-->
            <!--                                            <h6 class="m-0 hint-text">-->
            <!--                                                Share Public Post - 3h ago-->
            <!--                                            </h6>-->
            <!--                                            <h4 class="m-0">Richard Sevian</h4>-->
            <!--                                        </div>-->
            <!--                                    </div>-->
            <!--                                </div>-->
            <!--                            </div>-->
            <!--                        </div>-->
            <!--                    </div>-->
            <!--                </div>-->
            <!--            </div>-->
            <!--        </div>-->
            <!--        <div class="col-12 col-lg-6 col-xl-4 mb-2">-->
            <!--            <div class="h-100 bg-white padding-25">-->
            <!--                <h4 class="box-title mt-0">Manage Reported Post</h4>-->
            <!--                <ul class="list-task list-group" data-role="tasklist">-->
            <!--                    <li class="list-group-item border-0 pt-0" data-role="task">-->
            <!--                        <div class="d-flex w-100 justify-content-between align-items-center">-->
            <!--                            <div class="custom-control custom-checkbox material-checkbox">-->
            <!--                                <input type="checkbox" class="custom-control-input" id="meetNewSuppliers" checked>-->
            <!--                                <label class="custom-control-label" for="meetNewSuppliers">New reported post</label>-->
            <!--                            </div>-->
            <!--                        </div>-->
            <!--                    </li>-->
            <!--                    <li class="list-group-item border-0" data-role="task">-->
            <!--                        <div class="d-flex w-100 justify-content-between align-items-center">-->
            <!--                            <div class="custom-control custom-checkbox material-checkbox">-->
            <!--                                <input type="checkbox" class="custom-control-input" id="makeSalesReport" checked>-->
            <!--                                <label class="custom-control-label" for="makeSalesReport">Make reported post</label>-->
            <!--                            </div>-->
            <!--                            <span class="badge badge-danger">Today</span>-->
            <!--                        </div>-->
            <!--                    </li>-->
            <!--                    <li class="list-group-item border-0" data-role="task">-->
            <!--                        <div class="d-flex w-100 justify-content-between align-items-center">-->
            <!--                            <div class="custom-control custom-checkbox material-checkbox">-->
            <!--                                <input type="checkbox" class="custom-control-input" id="makeAnAppointement" checked>-->
            <!--                                <label class="custom-control-label" for="makeAnAppointement">Make an Post</label>-->
            <!--                            </div>-->
            <!--                        </div>-->
            <!--                    </li>-->
            <!--                    <li class="list-group-item border-0" data-role="task">-->
            <!--                        <div class="d-flex w-100 justify-content-between align-items-center">-->
            <!--                            <div class="custom-control custom-checkbox material-checkbox">-->
            <!--                                <input type="checkbox" class="custom-control-input" id="rearrangeAllTasks">-->
            <!--                                <label class="custom-control-label" for="rearrangeAllTasks">Rearrange all post</label>-->
            <!--                            </div>-->
            <!--                            <span class="badge badge-warning">8 days</span>-->
            <!--                        </div>-->
            <!--                    </li>-->
            <!--                    <li class="list-group-item border-0" data-role="task">-->
            <!--                        <div class="d-flex w-100 justify-content-between align-items-center">-->
            <!--                            <div class="custom-control custom-checkbox material-checkbox">-->
            <!--                                <input type="checkbox" class="custom-control-input" id="makeAnewOrder">-->
            <!--                                <label class="custom-control-label" for="makeAnewOrder">Reason for report</label>-->
            <!--                            </div>-->
            <!--                        </div>-->
            <!--                    </li>-->
            <!--                    <li class="list-group-item border-0" data-role="task">-->
            <!--                        <div class="d-flex w-100 justify-content-between align-items-center">-->
            <!--                            <div class="custom-control custom-checkbox material-checkbox">-->
            <!--                                <input type="checkbox" class="custom-control-input" id="generalThings">-->
            <!--                                <label class="custom-control-label" for="generalThings">Delete a post</label>-->
            <!--                            </div>-->
            <!--                            <span class="badge badge-success">3 weeks</span>-->
            <!--                        </div>-->
            <!--                    </li>-->
            <!--                </ul>-->
            <!--            </div>-->
            <!--        </div>-->
            <!--        <div class="col-12 col-lg-6 col-xl-4 mb-2">-->
            <!--            <div class="h-100 w-100 bg-white padding-25">-->
            <!--                <h4 class="box-title mt-0">Manage Post Content</h4>-->
            <!--                <div class="text-center">-->
            <!--                    <div id="pieChart"></div>-->
            <!--                </div>-->
            <!--            </div>-->
            <!--        </div>-->
            <!--        <div class="col-12 col-lg-6 col-xl-4 mb-2 mb-xl-0">-->
            <!--            <div class="h-100 w-100 bg-white padding-25">-->
            <!--                <h4 class="box-title mt-0">Social Media Analytics</h4>-->
            <!--                <div id="columnChart"></div>-->
            <!--            </div>-->
            <!--        </div>-->
            <!--        <div class="col-12 col-lg-6 col-xl-4 mb-2 mb-lg-0 dik">-->
            <!--            <div class="h-100 bg-white padding-25">-->
            <!--                <h4 class="box-title mt-0">Manage Videos Content</h4>-->
            <!--                <ul class="list-new-registrations list-group" data-role="newregistrationslist">-->
            <!--                    <li class="list-group-item border-0 d-flex align-items-center justify-content-between pt-0" data-role="newregistrationslist">-->
            <!--                        <a href="#" class="d-flex justify-content-between align-items-center">-->
            <!--                            <div class="img-wrapper float-left"><img src="<?php echo base_url(); ?>assets/images/user-1.png" class="rounded-circle" alt="User Image"></div>-->
            <!--                            <h5>Ankit Lodhi</h5>-->
            <!--                        </a>-->
            <!--                        <button type="button" class="btn"><i class="fa fa-ban"></i></button>-->
            <!--                    </li>-->
            <!--                    <li class="list-group-item border-0 d-flex align-items-center justify-content-between" data-role="newregistrationslist">-->
            <!--                        <a href="#" class="d-flex justify-content-between align-items-center">-->
            <!--                            <div class="img-wrapper float-left"><img src="<?php echo base_url(); ?>assets/images/user-3.png" class="rounded-circle" alt="User Image"></div>-->
            <!--                            <h5>Sanjeev Pal</h5>-->
            <!--                        </a>-->
            <!--                        <button type="button" class="btn"><i class="fa fa-ban"></i></button>-->
            <!--                    </li>-->
            <!--                    <li class="list-group-item border-0 d-flex align-items-center justify-content-between" data-role="newregistrationslist">-->
            <!--                        <a href="#" class="d-flex justify-content-between align-items-center">-->
            <!--                            <div class="img-wrapper float-left"><img src="<?php echo base_url(); ?>assets/images/user-2.png" class="rounded-circle" alt="User Image"></div>-->
            <!--                            <h5>Pulkit Sharma</h5>-->
            <!--                        </a>-->
            <!--                        <button type="button" class="btn"><i class="fa fa-ban"></i></button>-->
            <!--                    </li>-->
            <!--                    <li class="list-group-item border-0 d-flex align-items-center justify-content-between" data-role="newregistrationslist">-->
            <!--                        <a href="#" class="d-flex justify-content-between align-items-center">-->
            <!--                            <div class="img-wrapper float-left"><img src="<?php echo base_url(); ?>assets/images/user-4.png" class="rounded-circle" alt="User Image"></div>-->
            <!--                            <h5>Nidhi Sharma</h5>-->
            <!--                        </a>-->
            <!--                        <button type="button" class="btn"><i class="fa fa-ban"></i></button>-->
            <!--                    </li>-->
            <!--                    <li class="list-group-item border-0 d-flex align-items-center justify-content-between" data-role="newregistrationslist">-->
            <!--                        <a href="#" class="d-flex justify-content-between align-items-center">-->
            <!--                            <div class="img-wrapper float-left"><img src="<?php echo base_url(); ?>assets/images/user-5.png" class="rounded-circle" alt="User Image"></div>-->
            <!--                            <h5>Bhoomika Gupta</h5>-->
            <!--                        </a>-->
            <!--                        <button type="button" class="btn"><i class="fa fa-ban"></i></button>-->
            <!--                    </li>-->
            <!--                </ul>-->
            <!--            </div>-->
            <!--        </div>-->
            <!--        <div class="col-12 col-lg-6 col-xl-4">-->
            <!--            <div class="h-100 w-100 bg-white padding-25">-->
            <!--                <h4 class="box-title mt-0">Manage Image Content</h4>-->
            <!--                <div class="table-responsive data-table-wrapper">-->
            <!--                    <table class="table mb-0 mt-0 data-table">-->
            <!--                        <thead>-->
            <!--                        <tr>-->
            <!--                            <th>Image Content</th>-->
            <!--                            <th>User Name</th>-->
            <!--                            <th>Status</th>-->
            <!--                            <th>Action</th>-->
            <!--                        </tr>-->
            <!--                        </thead>-->
            <!--                        <tbody>-->
            <!--                        <tr>-->
            <!--                            <td>-->
            <!--                                <div id="areaChart1"></div>-->
            <!--                            </td>-->
            <!--                            <td><span  class="d-block">Gopal Mahor</span></td>-->
            <!--                            <td><span class="text-success">Active</span></td>-->
            <!--                            <td class="actions">-->
            <!--                                <a href="#" class="text-info mr-2" title="Edit"><i class="fa fa-pencil"></i></a>-->
            <!--                                <a href="#" class="text-danger mr-2" title="Delete"><i class="fa fa-trash-o"></i></a>-->
            <!--                            </td>-->
            <!--                        </tr>-->
            <!--                        <tr>-->
            <!--                            <td>-->
            <!--                                <div id="columnChart1"></div>-->
            <!--                            </td>-->
            <!--                            <td><span class="d-block">Pulkit Sharma</span></td>-->
            <!--                            <td><span class="text-primary">Deactive</span></td>-->
            <!--                            <td class="actions">-->
            <!--                                <a href="#" class="text-info mr-2" title="Edit"><i class="fa fa-pencil"></i></a>-->
            <!--                                <a href="#" class="text-danger mr-2" title="Delete"><i class="fa fa-trash-o"></i></a>-->
            <!--                            </td>-->
            <!--                        </tr>-->
            <!--                        <tr>-->
            <!--                            <td>-->
            <!--                                <div id="pieChart1"></div>-->
            <!--                            </td>-->
            <!--                            <td><span  class="d-block">Ankit Lodhi</span></td>-->
            <!--                            <td><span class="text-danger">Pending</span></td>-->
            <!--                            <td class="actions">-->
            <!--                                <a href="#" class="text-info mr-2" title="Edit"><i class="fa fa-pencil"></i></a>-->
            <!--                                <a href="#" class="text-danger mr-2" title="Delete"><i class="fa fa-trash-o"></i></a>-->
            <!--                            </td>-->
            <!--                        </tr>-->
            <!--                        </tbody>-->
            <!--                    </table>-->
            <!--                </div>-->
            <!--            </div>-->
            <!--        </div>-->
            <!--    </div>-->
            <!--</div>-->

            <!-- /page content -->
    
           