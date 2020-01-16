<style>
.profile .profile-detail .profile-image-wrapper .profile-image {
    width: 120px;
    height: 120px;
    -o-object-fit: cover;
    object-fit: cover;
}
.profile .timeline-view #activity .timeline li .timeline-entry .card img.rounded-circle {
    width: 40px;
    left: 10px;height: 40px;
    margin-right: 10px;
}
.profile .timeline-view #activity .timeline li .timeline-entry {
    position: relative;
    display: inline-block;
    width: 100%;
    padding: 0;
    vertical-align: top;
    margin: 0 -3px 0 0;
    white-space: normal;
}
.profile .timeline-view #activity .timeline li {
    position: relative;
    display: block;
    white-space: nowrap;
    min-height: 30px;
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
}
.profile .timeline-view #activity .timeline li .timeline-entry .card {
    margin-left: 60px!important;
    margin-right: 0;
    margin-bottom: 10px;
}
.profile .timeline-view #activity .timeline li .timeline-entry .card .card-body.timeline-entry-content {
    position: relative;
}

.profile .timeline-view #activity .timeline li .timeline-entry .card .card-body {
    background-color: #f4f8fb;
}
.profile .timeline-view #activity .timeline li .timeline-entry .card .card-body.timeline-entry-content:before {
    content: "";
    position: absolute;
    top: 30px;
    left: -14px;
    width: 0;
    height: 0;
    border-style: solid;
    border-width: 14px 14px 14px 0;
    border-color: transparent #f4f8fb transparent transparent;
}
.profile .timeline-view #activity .timeline li .timeline-entry .card .card-body.timeline-entry-content span {
    color: #8b91a0!important;
    font-size: 12px;
    opacity: .8;
}
.profile .timeline-view #activity .timeline li .timeline-circle {
    position: absolute;
    line-height: 38px;
    background: #f4f8fb;
    top: 24px;
    width: 40px;
    height: 40px;
    margin-left: 0;
    font-size: 18px;
}
.profile .timeline-view #activity .timeline:before {
    top: 44px;
    bottom: 0;
    position: absolute;
    content: " ";
    background-color: #f1f6fa;
    left: 10%;
    width: 2px;
    margin-left: -1px;
}
</style>
                                        


                                        <div class="main-content small-gutter">
                                            <?php if($this->session->userdata('message')) {  ?>
                 <?php echo $this->session->userdata('message');?>
            <?php } ?>
                <!-- START PAGE COVER -->
                <div class="row bg-title clearfix page-title">
                    <div class="col-12 col-lg-3">
                        <h4 class="page-title">App User</h4>
                    </div>
                    <div class="col-12 col-lg-9">
                        <!-- START breadcrumb -->
                        <ol class="breadcrumb pl-0 pr-0 float-lg-right">
                            <li><a href="index.html">User Dashboard</a></li>
                            <li class="active">Manage App User</li>
                        </ol>
                        <!-- END breadcrum -->
                    </div>
                    <!--<div class="col-12">
                        <h3>Form Layouts</h3>
                    </div>-->
                </div>
                <!-- END PAGE COVER -->
        
                <div class="container-fluid">
                <div class="row profile">
                    <?php var_dump($list);
                    var_dump($list['profileimage']);
                    
                    ?>
                    <div class="col-12 col-lg-5 col-xl-4 mb-2 mb-md-0">
                        <div class="profile-detail card mb-2">
                            <div class="card-body text-center p-t-20">
                                <div class="profile-image-wrapper">
                                    <img src="http://digimonk.net/social_media/assets/profile_img/<?php echo $list['profileimage'];?>" class="rounded-circle profile-image" alt="Profile Image">
                                </div>
                                <ul class="list-inline my-2">
                                    <li class="list-inline-item">
                                        <h3 class="text-success mb-0">412</h3>
                                        <p class="text-muted fs-14">Followings</p>
                                    </li>

                                    <li class="list-inline-item">
                                        <h3 class="text-danger mb-0">3450</h3>
                                        <p class="text-muted fs-14">Followers</p>
                                    </li>
                                </ul>
                                <button type="button" class="btn btn-info btn-rounded ripple">Follow</button>
                                <button type="button" class="btn btn-primary btn-rounded ripple">Message</button>
                                <hr>
                                <h4 class="text-uppercase font-weight-bold fs-16 mt-0">About Me</h4>
                                <p class="text-muted mb-2 fs-12">
                                    Hi, I am talanted person whose goal is to provide you flexible and efficient service. And some other lorem ipsum text.
                                </p>
                                <div class="text-left">
                                    <p class="text-muted fs-13"><strong>Full Name :</strong> <span class="m-l-15">Richard Harvey</span></p>
                                    <p class="text-muted fs-13"><strong>Mobile :</strong><span class="m-l-15">(111) 111 1111</span></p>
                                    <p class="text-muted fs-13"><strong>Email :</strong><a href="mailto:#"> <span class="m-l-15">harvey.rich@gmail.com</span></a></p>
                                    <p class="text-muted fs-13"><strong>Location :</strong> <span class="m-l-15">Canada</span></p>
                                </div>

                                <!--<div class="mt-2 social-links">-->
                                <!--    <button type="button" class="btn btn-facebook bg-transparent ripple">-->
                                <!--        <i class="fa fa-facebook"></i>-->
                                <!--    </button>-->

                                <!--    <button type="button" class="btn btn-twitter bg-transparent ripple">-->
                                <!--        <i class="fa fa-twitter"></i>-->
                                <!--    </button>-->

                                <!--    <button type="button" class="btn btn-linkedin bg-transparent ripple">-->
                                <!--        <i class="fa fa-linkedin"></i>-->
                                <!--    </button>-->

                                <!--    <button type="button" class="btn btn-dribbble bg-transparent ripple">-->
                                <!--        <i class="fa fa-dribbble"></i>-->
                                <!--    </button>-->
                                <!--</div>-->
                            </div>
                        </div>

                        
                    </div>
                    
                    
           
                    <div class="col-12 col-lg-7 col-xl-8">
                        <div class="timeline-view bg-white padding-20">
                            <h4 class="box-title mt-0 text-uppercase font-weight-bold text-info">User Timeline</h4>
                            <div class="row">
                                <div class="col-12">
                                    <form class="material-form">
                                        <div class="form-group floating-label">
                                            <textarea class="form-control form-control-primary" id="whatisonyourmind"></textarea>
                                            <label for="whatisonyourmind">What's on your mind</label>
                                        </div>
                                    </form>
                                    <div class="">
                                        <div class="float-left">
                                            <a class="btn bg-transparent"><i class="fa fa-camera" aria-hidden="true"></i></a>
                                            <a class="btn bg-transparent"><i class="fa fa-map-marker" aria-hidden="true"></i></a>
                                            <a class="btn bg-transparent"><i class="fa fa-paperclip" aria-hidden="true"></i></a>
                                        </div>
                                        <a href="javascript:void(0);" class="btn btn-primary float-right ripple" style="margin: 0 0 15px 0;">Post</a>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div id="activity">
                                        <ul class="timeline timeline-hairline mb-0">
                                            <li class="timeline-inverted">
                                                <div class="timeline-circle rounded-circle text-info text-center"><i class="fa fa-envelope"></i></div>
                                                <div class="timeline-entry">
                                                    <div class="card">
                                                        <div class="card-body timeline-entry-content">
                                                            <p class="mb-0">Received a <a class="text-info font-weight-bold" href="#">message</a> from <span class="text-info font-weight-bold">Samuel Nelson</span></p>
                                                            <p class="mb-0">
                                                                <span>
                                                                    Sunday, March 25, 2018
                                                                </span>
                                                            </p>

                                                        </div>
                                                    </div>
                                                </div><!--end .timeline-entry -->
                                            </li>
                                            <li>
                                                <div class="timeline-circle rounded-circle text-warning text-center"><i class="fa fa-clock-o"></i></div>
                                                <div class="timeline-entry">
                                                    <div class="card">
                                                        <div class="card-body timeline-entry-content">
                                                            <p class="mb-0">
                                                                User apply for refund at <span class="text-warning font-weight-bold">9:15 pm</span>
                                                            </p>
                                                            <p class="mb-0">
                                                                <span>
                                                                    Thursday, March 15, 2018
                                                                </span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div><!--end .timeline-entry -->
                                            </li>
                                            <li>
                                                <div class="timeline-circle rounded-circle text-success text-center"><i class="fa fa-map-marker"></i></div>
                                                <div class="timeline-entry">
                                                    <div class="card mb-0">
                                                        <div class="card-body timeline-entry-content">
                                                            <img class="rounded-circle float-left" src="http://digimonk.net/ios-admin/uploads/201905100849May.jpg" alt="Profile Image">
                                                            <div class="m-l-50">
                                                                <p class="mb-0">User receives Location <span class="text-success font-weight-bold">Digimonk</span></p>
                                                                <p class="mb-0">
                                                                    <span>
                                                                        Monday, March 5, 2018
                                                                    </span>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><!--end .timeline-entry -->
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    
                    
                </div>
            </div>

  