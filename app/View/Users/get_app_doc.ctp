<style>
.thumbnail{
width: 109px;
float: left;
border:none!important;
text-align:center!important;
}

.example-image-link img{
width:90px;
height:90px;
}



</style>					
					<?php if(isset($groupNo)) $groupNo = $groupNo; else $groupNo = 0;?>
					<?php if(isset($value)){ if(isset($value['app_no'])){ //print_r($value); exit;?>
					<div class="container">
						
		<div class="image-row">
			<div class="image-set">
						<a class="example-image-link" href="<?php echo $this->webroot; ?>app/webroot/uploads/<?php echo $groupNo; ?>/<?php echo $value['app_no']; ?>/<?php echo $value['pfp']; ?>" data-lightbox="example-set<?php echo $value['app_no']; ?>" title="Passport First Page">
								<?php if(isset($value['pfp'])){ ?>
								<img src="<?php echo $this->webroot; ?>app/webroot/uploads/<?php echo $groupNo; ?>/<?php echo $value['app_no']; ?>/<?php echo $value['pfp']; ?>" />
							<?php }else{ ?>
								<img src="<?php echo $this->webroot; ?>app/webroot/images/thumb.gif" />
							<?php } ?>
							</a>
							
							<a class="example-image-link" href="<?php echo $this->webroot; ?>app/webroot/uploads/<?php echo $groupNo; ?>/<?php echo $value['app_no']; ?>/<?php echo $value['pfp']; ?>" data-lightbox="example-set<?php echo $value['app_no']; ?>" title="Passport Last Page">
							<?php if(isset($value['plp'])){ ?>
								<img src="<?php echo $this->webroot; ?>app/webroot/uploads/<?php echo $groupNo; ?>/<?php echo $value['app_no']; ?>/<?php echo $value['plp']; ?>" />
							<?php }else{ ?>
								<img src="<?php echo $this->webroot; ?>app/webroot/images/thumb.gif" />
							<?php } ?>
							</a>
							
							<a class="example-image-link" href="<?php echo $this->webroot; ?>app/webroot/uploads/<?php echo $groupNo; ?>/<?php echo $value['app_no']; ?>/<?php echo $value['pfp']; ?>" data-lightbox="example-set<?php echo $value['app_no']; ?>" title="Photograph">
							<?php if(isset($value['photograph'])){ ?>
								<img src="<?php echo $this->webroot; ?>app/webroot/uploads/<?php echo $groupNo; ?>/<?php echo $value['app_no']; ?>/<?php echo $value['photograph']; ?>" />
							<?php }else{ ?>
								<img src="<?php echo $this->webroot; ?>app/webroot/images/thumb.gif" />
							<?php } ?></a>
							
							<a class="example-image-link" href="<?php echo $this->webroot; ?>app/webroot/uploads/<?php echo $groupNo; ?>/<?php echo $value['app_no']; ?>/<?php echo $value['pfp']; ?>" data-lightbox="example-set<?php echo $value['app_no']; ?>" title="Ticket Copy">
							<?php if(isset($value['ticket'])){ ?>
								<img src="<?php echo $this->webroot; ?>app/webroot/uploads/<?php echo $groupNo; ?>/<?php echo $value['app_no']; ?>/<?php echo $value['ticket']; ?>" />
							<?php }else{ ?>
								<img src="<?php echo $this->webroot; ?>app/webroot/images/thumb.gif" />
							<?php } ?></a>
							
					</div>
		</div>
					<?php } } ?>
					</div>
