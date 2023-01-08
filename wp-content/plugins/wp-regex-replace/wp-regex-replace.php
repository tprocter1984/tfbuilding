<?php
/*
Plugin Name: WP RegEx Replace
Plugin URI: http://www.nettantra.com/
Description: This plugin will replace regular expressions in the final rendered WordPress output.
Version: 0.10.1
Author: NetTantra
Author URI: http://www.nettantra.com
*/

function do_replace($buffer) {
  if( strpos($_SERVER["REQUEST_URI"], 'wp-admin') === false ){
    if( get_option('regex_replace_hash') ){
      $regex_replace_hash = json_decode( get_option('regex_replace_hash') );
    } else {
      $regex_replace_hash[''] = '';
    }
    $regex_replace_source = array();
    $regex_replace_destination = array();
    foreach( $regex_replace_hash as $key=>$val ){
      array_push( $regex_replace_source, "/".str_replace(array('/', ":SQUOTE:", ":DQUOTE:"),array('\/',"\'",'\"'),$key)."/" );
      array_push( $regex_replace_destination, $val );
    }
    $buffer = preg_replace($regex_replace_source, $regex_replace_destination, $buffer);
  }
  return $buffer;
}

function buffer_start() {
  ob_start("do_replace");
}

function buffer_end() {
  ob_end_flush();
}

function regex_replace_admin_options(){
  if( get_option('regex_replace_hash') ){
    $regex_replace_hash = json_decode( get_option('regex_replace_hash') );
  } else {
    $regex_replace_hash[''] = '';
  }
?>
<style type="text/css">
<!--
a.remove-pair:link, a.remove-pair:visited { display: inline-block; padding: 2px 3px 3px; line-height: 11px; font-size: 11px; background: #888; color: #fff; font-family: "Comic Sans MS"; font-weight: bold; -moz-border-radius: 3px; border-radius: 3px; text-decoration: none;  }
a.remove-pair:hover { background: #BBB; }
-->
</style>
<form method="post" action="">
  <h2>WP RegEx Replace</h2>
  Save your Wordpress RegEx Replace details here:<br/>
  <?php if(count($regex_replace_hash) > 0): ?>
  <?php foreach($regex_replace_hash as $key => $val): ?>
  <p class="regex_replace_hash"><strong>Replace</strong>
  <input type="text" name="regex_replace_source[]" value="<?php echo $key;?>" size="40" autocomplete="off" style="width: 280px" /> <strong>with</strong>
  <input type="text" name="regex_replace_destination[]" value="<?php echo $val;?>" size="40" autocomplete="off" style="width: 280px" />
  <a href="javascript:void(0)" class="remove-pair">X</a></p>
  <?php endforeach; ?>
  <?php else: ?>
  <p class="regex_replace_hash"><strong>Replace</strong>
  <input type="text" name="regex_replace_source[]" value="" size="40" autocomplete="off" /> <strong>with</strong>
  <input type="text" name="regex_replace_destination[]" value="" size="40" autocomplete="off" />
  <a href="javascript:void(0)" class="remove-pair">x</a></p>
  <?php endif; ?>
<div>
  <input type="hidden" name="regex_replace_hidden" value="regex_replace_hidden" />
  <input type="button" id="add_more_items" value="Add more"/>
  <input type="submit" value="Update"/>
</div>
</form>
<script type="text/javascript">
<!--
jQuery(function(){
  jQuery('#add_more_items').click(function(){
    jQuery('.regex_replace_hash:last').after( jQuery('.regex_replace_hash:eq(0)').clone() );
    jQuery('.regex_replace_hash:last').find('input').val("");
  });
  jQuery('.remove-pair').live('click', function(){
    if( jQuery('.regex_replace_hash').length > 1 )
      jQuery(this).parents('.regex_replace_hash:first').remove();
    else
      alert('Cannot remove the last pair');
  });
});
-->
</script>
<?php
}

function regex_replace_admin_menu() {
  if(@$_REQUEST['regex_replace_hidden']=="regex_replace_hidden"){
    $regex_replace_source = $_REQUEST['regex_replace_source'];
    $regex_replace_destination = $_REQUEST['regex_replace_destination'];
    $regex_replace_hash = array();
    foreach($regex_replace_source as $key=>$val) {
      if($val) $regex_replace_hash[$val] = $regex_replace_destination[$key];
    }
    $regex_replace_hash = json_encode($regex_replace_hash);
    update_option('regex_replace_hash', $regex_replace_hash);
  }
  add_options_page('My Plugin Options', 'WP RegEx Replace', 8, __FILE__, 'regex_replace_admin_options');
}

add_action('admin_menu', 'regex_replace_admin_menu');
add_action('init', 'buffer_start', 100);
?>
