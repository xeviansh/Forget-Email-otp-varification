<html lang="en">

<head>
</head>
<!-- page wrapper -->

<body class="">
  <div class="boxed_wrapper">
    <!-- Preloader -->
    <div class="loader-wrap" style="display: none;">
      <div class="preloader">
        <div class="preloader-close">Preloader Close</div>
      </div>
      <div class="layer layer-one"><span class="overlay" style="left: 100%; transform: translate3d(0px, 0px, 0px);"></span></div>
      <div class="layer layer-two"><span class="overlay" style="left: 100%; transform: translate3d(0px, 0px, 0px);"></span></div>
      <div class="layer layer-three"><span class="overlay" style="left: 100%; transform: translate3d(0px, 0px, 0px);"></span></div>
    </div>
    <!-- Preloader -->

    <!-- search-popup -->
    <div id="search-popup" class="search-popup">
      <div class="close-search"><i class="flaticon-close"></i></div>
      <div class="popup-inner">
        <div class="overlay-layer"></div>
        <div class="search-form">
          <form method="post" action="#">
            <div class="form-group">
              <fieldset>
                <input type="search" class="form-control" name="search-input" value="" placeholder="Search Here" required="">
                <input type="submit" value="Search Now!" class="theme-btn style-four">
              </fieldset>
            </div>
          </form>

        </div>
      </div>
    </div>
    <!-- search-popup end -->

    <!-- main header -->
    <?php $this->load->view('common/header'); ?>
    <!-- main-header end -->
    <!-- Mobile Menu  -->

  

    <div class="container mt-2 mb-4" style="padding:90px 0;">
    
      <div class="col-sm-4 ml-auto mr-auto">
      
        <div class="tab-content" id="pills-tabContent">
          <div class="tab-pane fade show active" id="pills-signin" role="tabpanel" aria-labelledby="pills-signin-tab">
            <?php
            //============================Success=====================================
            if (!empty($this->session->flashdata('success'))) {
            ?>
              <div class="alert alert-dismissible bg-success text-white border-0 fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
                <?php echo $this->session->flashdata('success');
                if (isset($_SESSION['success'])) {
                  unset($_SESSION['success']);
                } ?>
              </div>
            <?php
            } ?>
            <?php
            //============================Error=====================================
            if (!empty($this->session->flashdata('error'))) {
            ?>
              <div class="alert alert-dismissible bg-danger text-white border-0 fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
                <?php echo $this->session->flashdata('error');
                if (isset($_SESSION['error'])) {
                  unset($_SESSION['error']);
                } ?>
              </div>
            <?php
            } ?>
            
            <div class="col-sm-12 border form-custom pt-0">
            <h3>Mortgage</h3>
              <form action="" method="post" id="forget_password">
                <div class="input-group mb-3">
                  <input type="email" class="form-control" name="email" placeholder="Email" required>
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-envelope"></span>
                    </div>
                  </div>
                  <div class="email_error red_error"></div>
                  <div class="success"></div>
                </div>
                <div class="form-group marginsa">
                  <input type="submit"  name="submit"  value="Request new password" class="btn btn-block ">
                </div>
              </form>
              <!-- <p class="mt-3 mb-1">
                <a href="<?php echo base_url() . 'Login'; ?>">Login</a>
              </p>
              <p class="mb-0">
                <a href="<?php echo base_url() . 'Register'; ?>" class="text-center">Register a new membership</a>
              </p> -->
            </div>
          </div>

        </div>
        </form>
      </div>
    </div>
  </div>
  <!-- page-title end-->

  <?php $this->load->view('common/footer'); ?>





  <!-- jQuery -->
  <script src="<?php echo base_url() . 'assets/new-template/'; ?>plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="<?php echo base_url() . 'assets/new-template/'; ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="<?php echo base_url() . 'assets/new-template/'; ?>dist/js/adminlte.min.js"></script>

  <script>
    jQuery(document).ready(function($) {
      $("#forget_password").submit(function(e) {
        e.preventDefault(); // avoid to execute the actual submit of the form.
        $('.preloader_box').css('display', 'flex');
        var form = $('#forget_password').serialize();

        $.ajax({
          type: "POST",
          url: '<?php echo base_url(); ?>forget_password_mail',
          data: form, // serializes the form's elements.
          dataType: "JSON",
          success: function(data) {
            // var result = $.parseJSON(data);
            // console.log(data);

            if (data['email_error'] != '') {
              $('.email_error').html(data['email_error']);
              //alert("ok");
            } else {
              $('.email_error').html('');

            }
            


            if (data['success'] != '' && data['status'] == 1) {

              $('#forget_password').html('<p><small>Please, Check your email for verification code</small></p><p><small>The code is valid for 5 minutes</small></p><div class="input-group mb-3"><input type="text" class="form-control opt" name="opt" placeholder="Enter Code" ><div class="input-group-append"><div class="input-group-text"><span class="fas fa-envelope"></span></div></div><div class="otp_error otp_expired_error red_error xx"></div></div><div class="row"><div class="col-12"><button type="submit" name="otp_bt" class="btn btn-primary mb-5 btn-block otp_bt">Continue</button></div></div>');


            //   $('.success').html(data['success']);
              $('.success').html('Your password has been changed successfully.');
              $('.email_error').html('');
            } else {
              $('.success').html('Check Email for OTP');


            }
            $('.preloader_box').css('display', 'none');
          }
        });
      });


      $(document).on('click', '.otp_bt', function(e) {
        e.preventDefault(); // avoid to execute the actual submit of the form.
        $('.preloader_box').css('display', 'flex');
        var form = $('#forget_password').serialize();

        $.ajax({
          type: "POST",
          url: '<?php echo base_url(); ?>otp_verification',
          data: form, // serializes the form's elements.
          dataType: "JSON",
          success: function(data) {
            // var result = $.parseJSON(data);
            // console.log(data);

            if (data['otp_error'] != '') {
              $('.otp_error').html(data['otp_error']);

            } else {
              $('.otp_error').html('');

            }
            

            if (data['status'] != '' && data['status'] == 1) {

              $('#forget_password').html('<div class="input-group mb-3"><input type="text" class="form-control pass" name="pass" placeholder="Enter New Password"><div class="input-group-append"><div class="input-group-text"><span class="fas fa-envelope"></span></div></div></div><div class="input-group mb-3"><input type="text" class="form-control confirm_pass" name="confirm_pass" placeholder="Confirm New Password"><div class="input-group-append"><div class="input-group-text"><span class="fas fa-envelope"></span></div></div><div class="password_error otp_expired_error red_error"></div></div><div class="row"><div class="col-12"><button type="submit" name="sub_password" class="btn btn-primary btn-block sub_password mb-5">Submit</button></div></div>');


              $('.success').html(data['success']);
              $('.otp_error').html('');
            }

            $('.preloader_box').css('display', 'none');
          }
        });
      });



      $(document).on('click', '.sub_password', function(e) {
        e.preventDefault(); // avoid to execute the actual submit of the form.
        $('.preloader_box').css('display', 'flex');
        var form = $('#forget_password').serialize();

        $.ajax({
          type: "POST",
          url: '<?php echo base_url(); ?>change_otp_password',
          data: form, // serializes the form's elements.
          dataType: "JSON",
          success: function(data) {
            // var result = $.parseJSON(data);
            // console.log(data);

            if (data['password_error'] != '') {
              $('.password_error').html(data['password_error']);

            } else {
              $('.password_error').html('');

            }


            if (data['status'] != '' && data['status'] == 1) {

              // swal("Success", "Well done, Your password has been changed successfully.", "success")

              $('#forget_password').html('<div class="success_error mb-5">Your password has been changed successfully.</div>');
              //$('.success').html(data['success']);
              $('.password_error').html('');
            }

            $('.preloader_box').css('display', 'none');
          }
        });
      });


    });
  </script>
  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script> -->
  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script> -->
