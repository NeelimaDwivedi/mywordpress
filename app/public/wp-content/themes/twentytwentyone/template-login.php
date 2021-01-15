<?php
/**
 * Template Name: LoginTemplate
 * 
 */
get_header();
?>
<div class="custom-main">
<?php _e("<h2>Login</h2>"); ?>
<div class="container">
  <form action="" method="post">
  <div class="row">
    <div class="col-25">
      <label for="username"><?php _e('User Name'); ?></label>
    </div>
    <div class="col-75">
      <input type="text" id="username" name="username" placeholder="Your name..">
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="userpass"><?php _e('Password'); ?></label>
    </div>
    <div class="col-75">
      <input type="password" id="userpass" name="userpass" placeholder="Your password..">
    </div>
  </div>
  <div class="row">
    <input type="submit" value="Submit" name="loginsubmit">
  </div>
  </form>
</div>
</div>