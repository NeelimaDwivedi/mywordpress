<?php
/**
 * Template Name: UpdateTemplate
 * 
 */
get_header();
$user_info=get_userdata(get_current_user_id());
$user_address=get_usermeta(get_current_user_id(),'address');
$user_mobile=get_usermeta(get_current_user_id(),'mobile');
$user_dob=get_usermeta(get_current_user_id(),'dob');
//echo '<pre>';

  //print_r($user_data);
  $user_name = $user_info->display_name;
  $user_email = $user_info->user_email;
  
  //echo '</pre>';
?>
<div class="custom-main">
<?php _e("<h2>Updation Form</h2>"); ?>
<div class="container">
  <form action="" method="post">
  <div class="row">
    <div class="col-25">
      <label for="uname"><?php _e('User Name'); ?></label>
    </div>
    <div class="col-75">
      <input type="text" id="uname" name="uname" value="<?php echo $user_name; ?>" placeholder="Your name.." disabled>
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="uemail"><?php _e('Email'); ?></label>
    </div>
    <div class="col-75">
      <input type="text" id="uemail" name="uemail" value="<?php echo $user_email; ?>" placeholder="Your Email.." disabled>
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="uaddress"><?php _e('Address'); ?></label>
    </div>
    <div class="col-75">
      <input type="text" id="uaddress" name="uaddress" value="<?php echo $user_address; ?>" placeholder="Write something.." style="height:100px"></textarea>
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="umob"><?php _e('Phone no.'); ?></label>
    </div>
    <div class="col-75">
      <input type="text" id="umob" name="umob"  value="<?php echo $user_mobile ;?>" placeholder="Your mobile.." maxlength="10">
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="udob"><?php _e('Date Of Birth'); ?></label>
    </div>
    <div class="col-75">
      <input type="date" id="udob" name="udob" value="<?php echo $user_dob;?>" placeholder="Your DOB..">
    </div>
  </div>
  <div class="row">
    <input type="submit" value="Update"  name="updatersubmit">
  </div>
  </form>
</div>
</div>