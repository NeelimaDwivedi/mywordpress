<?php
/**
 * Template Name: FormTemplate
 * 
 */
get_header();

?>

<div class="custom-main">
<?php _e("<h2>Registration Form</h2>"); ?>
<div class="container">
  <form action="" method="post">
  <div class="row">
    <div class="col-25">
      <label for="uname"><?php _e('User Name'); ?></label>
    </div>
    <div class="col-75">
      <input type="text" id="uname" name="uname" placeholder="Your name..">
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="uemail"><?php _e('Email'); ?></label>
    </div>
    <div class="col-75">
      <input type="text" id="uemail" name="uemail" placeholder="Your Email..">
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="upass"><?php _e('Password'); ?></label>
    </div>
    <div class="col-75">
      <input type="text" id="upass" name="upass" placeholder="Your password..">
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="uaddress"><?php _e('Address'); ?></label>
    </div>
    <div class="col-75">
      <textarea id="uaddress" name="uaddress" placeholder="Write something.." style="height:100px"></textarea>
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="umob"><?php _e('Phone no.'); ?></label>
    </div>
    <div class="col-75">
      <input type="text" id="umob" name="umob" placeholder="Your mobile.." maxlength="10">
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="udob"><?php _e('Date Of Birth'); ?></label>
    </div>
    <div class="col-75">
      <input type="date" id="udob" name="udob" placeholder="Your DOB..">
    </div>
  </div>
  <div class="row">
    <input type="submit" value="Submit" name="registersubmit">
  </div>
  </form>
</div>
</div>