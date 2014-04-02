<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

$cakeDescription = __d('cake_dev', 'Global Voyages : Online Visa Application');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<?php echo $this->Html->charset(); ?>
		<title>
			<?php echo $cakeDescription ?>
		</title>

<!--<script src="http://code.jquery.com/jquery-1.10.1.min.js" type = "text/javascript"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/jquery-ui.min.js" type = "text/javascript"></script>-->
		<?php
			echo $this->Html->meta('icon');
			echo $this->fetch('meta');
			//echo $this->Html->css('font-awesome');
			
			echo $this->Html->css('aristo-ui');
			echo $this->Html->css('plugins/elfinder/elfinder.min');
			echo $this->Html->css('plugins/gritter/jquery.gritter');
		    echo $this->Html->css('plugins/datatable/TableTools');
		    //echo $this->Html->css('responsive-tables');
		    echo $this->Html->css('bootstrap.min');
			echo $this->Html->css('plugins/icheck/all');
			//echo $this->Html->css('bootstrap-responsive.min');
			echo $this->Html->css('plugins/chosen/chosen');
			echo $this->Html->css('themes');
			echo $this->Html->css('style');
			echo $this->fetch('css');
			
			echo $this->Html->script('jquery.min.js');
			echo $this->Html->script('jquery-ui-1.10.1.custom.min');
			//echo $this->Html->script('jquery.sparkline');
			echo $this->Html->script('plugins/datatable/jquery.dataTables');
			echo $this->Html->script('ZeroClipboard');
			//echo $this->Html->script('dataTables.bootstrap');
			echo $this->Html->script('plugins/datatable/TableTools.min');
			echo $this->Html->script('plugins/fileupload/bootstrap-fileupload');
			//echo $this->Html->script('jquery.metadata');
			//echo $this->Html->script('jquery.tablesorter.min');
			//echo $this->Html->script('jquery.tablecloth');
			//echo $this->Html->script('jquery.flot');
			//echo $this->Html->script('jquery.flot.selection');
			//echo $this->Html->script('jquery.flot.resize');
			//echo $this->Html->script('jquery.collapsible');
			//echo $this->Html->script('accordion.nav');
			//echo $this->Html->script('bootstrap-datetimepicker.min');
			//echo $this->Html->script('responsive-tables');
			//echo $this->Html->script('date');
			//echo $this->Html->script('jquery.prettyPhoto');
			echo $this->Html->script('plugins/chosen/chosen.jquery.min');
			echo $this->Html->script('plugins/gritter/jquery.gritter.min');
			
			//echo $this->Html->script('jquery.metadata');
			//echo $this->Html->script('stepy.jquery');
			//echo $this->Html->script('ckeditor/ckeditor');
			//echo $this->Html->script('tiny_mce/jquery.tinymce');
			//echo $this->Html->script('ios-orientationchange-fix');
			//echo $this->Html->script('jquery.dataTables.rowGrouping');
			
			echo $this->Html->script('plugins/bootbox/jquery.bootbox');
			//echo $this->Html->script('respond.min');
			//echo $this->Html->script('custom');
			echo $this->Html->script('plugins/icheck/jquery.icheck.min');
			echo $this->Html->script('eakroko');
			echo $this->Html->script('bootstrap');
			echo $this->fetch('script');			
			
		?>
		<link rel="shortcut icon" href="<?php echo $this->webroot;?>theme/Cakestrap/ico/favicon.ico">
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo $this->webroot;?>theme/Cakestrap/ico/apple-touch-icon-144-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo $this->webroot;?>theme/Cakestrap/ico/apple-touch-icon-114-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo $this->webroot;?>theme/Cakestrap/ico/apple-touch-icon-72-precomposed.png">
<link rel="apple-touch-icon-precomposed" href="<?php echo $this->webroot;?>theme/Cakestrap/ico/apple-touch-icon-57-precomposed.png">

<script type="text/javascript">
$(function () {
    $(".left-primary-nav a").hover(function () {
        $(this).stop().animate({
            fontSize: "30px"
        }, 200);
    }, function () {
        $(this).stop().animate({
            fontSize: "24px"
        }, 100);
    });
});
</script>

	</head>

	<body class='login'> 

<style >
#date_notify{
margin-top: 12px;
height: 17px;
font-size: 12px;
padding-top: 6px;
}

.navbar-inverse .nav > li > a{
color:#fff;
}
</style>

	<?php  $userId = $this->UserAuth->getUserId();?>
<?php	if (!$userId) { ?>
<body class='login'> 
      <div class="wrapper">     
      	<?php echo $this->fetch('content'); ?>      
      </div>
      <body>
     <?php }else {
   echo $this->element('dashboard'); ?>
   <body>
   <div class="wrapper">
 	<?php echo $this->fetch('content');?>
   </div>
 </body>
 <?php } ?>

</html>




		