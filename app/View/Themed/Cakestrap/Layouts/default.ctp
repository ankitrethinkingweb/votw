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
		<!--Start of Zopim Live Chat Script-->
<!--<script type="text/javascript">
window.$zopim||(function(d,s){var z=$zopim=function(c){z._.push(c)},$=z.s=
d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
_.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute('charset','utf-8');
$.src='//v2.zopim.com/?1WexvHLlBHL9HtYzGDNtOz28OYD3WX0r';z.t=+new Date;$.
type='text/javascript';e.parentNode.insertBefore($,e)})(document,'script');
</script>-->
<!--End of Zopim Live Chat Script-->
<!--<script src="http://code.jquery.com/jquery-1.10.1.min.js" type = "text/javascript"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/jquery-ui.min.js" type = "text/javascript"></script>-->
		<?php
			echo $this->Html->meta('icon');
			echo $this->fetch('meta');

			echo $this->Html->css('bootstrap');
			//echo $this->Html->css('bootstrap-responsive.min');
			echo $this->Html->css('chosen');
			echo $this->Html->css('styles');
			echo $this->Html->css('font-awesome');
		
			echo $this->Html->css('aristo-ui');
			echo $this->Html->css('elfinder');
			echo $this->Html->css('jquery.gritter');
		    echo $this->Html->css('TableTools');
			echo $this->fetch('css');
			echo $this->Html->script('jquery');
			
			echo $this->Html->css('responsive-tables');
			echo $this->Html->script('jquery-ui-1.10.1.custom.min');
			//echo $this->Html->script('jquery.sparkline');
			echo $this->Html->script('jquery.dataTables');
			echo $this->Html->script('ZeroClipboard');
			echo $this->Html->script('dataTables.bootstrap');
			echo $this->Html->script('TableTools');

			echo $this->Html->script('bootstrap-fileupload');
			//echo $this->Html->script('jquery.metadata');
			//echo $this->Html->script('jquery.tablesorter.min');
			//echo $this->Html->script('jquery.tablecloth');
			//echo $this->Html->script('jquery.flot');
			//echo $this->Html->script('jquery.flot.selection');
			//echo $this->Html->script('jquery.flot.resize');
			echo $this->Html->script('jquery.collapsible');
			echo $this->Html->script('accordion.nav');
			//echo $this->Html->script('bootstrap-datetimepicker.min');
			//echo $this->Html->script('responsive-tables');
			echo $this->Html->script('date');
			//echo $this->Html->script('jquery.prettyPhoto');
			echo $this->Html->script('chosen.jquery');
			echo $this->Html->script('jquery.gritter');
			//echo $this->Html->script('jquery.metadata');
			//echo $this->Html->script('stepy.jquery');
			//echo $this->Html->script('ckeditor/ckeditor');
			//echo $this->Html->script('tiny_mce/jquery.tinymce');
			
			//echo $this->Html->script('ios-orientationchange-fix');
			//echo $this->Html->script('jquery.dataTables.rowGrouping');
			echo $this->Html->script('bootbox');
			//echo $this->Html->script('ajaxfileupload');
			echo $this->Html->script('respond.min');
			echo $this->Html->script('custom');
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

	<body>

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

<div class="layout">
   <div class="navbar navbar-inverse top-nav">
		<div class="navbar-inner">
			<div class="container">
				<span class="home-link"><a href="http://www.global-voyages.in" class="icon-home" title = 'Back to www.global-voyages.in' ></a></span><a class="brand" href="http://www.global-voyages.in"><img src="<?php echo $this->webroot;?>images/visa-logo.png" height = '50px'alt="Global Voyages"></a>
				
				<div class="btn-toolbar pull-right notification-nav">
					<div class="btn-group">
						<div class="dropdown">
							<span class="label label-inverse" id = "date_notify"><i class="icon-time"></i>   <?php echo date('d M Y h:i:s A'); ?></span>
						</div>
					</div>
				</div>
				
				
<?php $userId = $this->UserAuth->getUserId(); if ($userId) { ?>
				<div class="nav-collapse" style = "float:right;">
					<ul class="nav">
					<li class="dropdown"><a data-toggle="dropdown" class="dropdown-toggle" href="#"><i class="icon-wrench"></i> Settings <b class="icon-angle-down"></b></a>
						<div class="dropdown-menu">
							<ul>
								<li><a href="<?php echo $this->webroot;?>changePassword" ><i class="icon-edit"></i><span>Change Password</span></a></li>
								<?php if($this->UserAuth->getGroupName() == 'Admin') { ?>
									<li><a href="<?php echo $this->webroot;?>settings" ><i class="icon-cogs"></i><span>Admin Settings</span></a></li>
									<li><a href="<?php echo $this->webroot;?>agentSetting" ><i class="icon-cogs"></i><span>Agent Settings</span></a></li>	
								<?php } ?>	
							</ul>
						</div>
						</li>
					</ul>
				</div>
			<?php if($this->UserAuth->getGroupName() == 'User') { 
			$amt = $this->UserAuth->getUserAmt();
			//print_r($amt) ; exit;
			?>	
			
			<div class = "btn-toolbar pull-right notification-nav">
					<div class="btn-group">		
						<?php if(isset($amt[2])){ 
						echo '<button style="margin-top:10px;margin-left:3px;padding:5px;color:white;background-color:#9B96A0;" class="btn" type="button"><strong>Total - '.$amt[2];
						if(isset($amt[3])) echo " ". $amt[3];
						echo '</strong></button>'; 
						 } ?>
					</div>
				</div>	
				
				<div class = "btn-toolbar pull-right notification-nav">
					<div class="btn-group">		
					<?php if(isset($amt[1])){ 
						echo '<button ';
						if($amt[4] > $amt[1])
						echo 'style="margin-top:10px;margin-left:3px;padding:5px;color:white;background-color:#FF5A5A"';
						else echo 'style="margin-top:10px;margin-left:3px;padding:5px;color:white;background-color:#3C9C48"';
						echo ' class="btn" type="button"><strong>Credit Limit - '.$amt[1];
						if(isset($amt[3])) echo " ". $amt[3];
						echo '</strong></button>'; 
						 } ?>
					</div>
				</div>		
				
			<div class = "btn-toolbar pull-right notification-nav">
					<div class="btn-group">		
						<?php if(isset($amt[0])){ 
						echo '<button ';
						if($amt[0] == 0)
						echo 'style="margin-top:10px;margin-left:3px;padding:5px;color:white;background-color:#FF5A5A"';
						else echo 'style="margin-top:10px;margin-left:3px;padding:5px;color:white;background-color:#3C9C48"';
						echo ' class="btn" type="button"><strong>Wallet - '.$amt[0];
						if(isset($amt[3])) echo " ". $amt[3];
						echo '</strong></button>'; 
						 } ?>
					</div>
				</div>	
			
		<?php } ?>			
<?php } ?>
			</div>
		</div>
	</div>
	<?php  $userId = $this->UserAuth->getUserId();?>
<?php	if (!$userId) { ?>
      <div class="container"><?php echo $this->fetch('content'); ?></div>
     <?php }else {
   
   echo $this->element('dashboard'); ?>
   <div class="main-wrapper">
 <?php echo $this->fetch('content');?>
 </div>
 <?php } ?>
     
<div class="copyright">
		<p style="float:left">
Copyright <a href="#" target="_blank"></a>. All Rights Reserved.
</p>
<p style="float: right;padding-right: 16px;">
Powered By <a href="http://www.rethinkingweb.com" target="_blank">Rethinkingweb</a>
</p>
<div style="clear:both;"></div>
	</div>
	<div class="scroll-top">
		<a href="#" class="tip-top" title="Go Top"><i class="icon-double-angle-up"></i></a>
	</div>

</body>
</html>




		