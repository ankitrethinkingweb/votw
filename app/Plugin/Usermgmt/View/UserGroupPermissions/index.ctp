<?php
/*
	This file is part of UserMgmt.

	Author: Chetan Varshney (http://ektasoftwares.com)

	UserMgmt is free software: you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation, either version 3 of the License, or
	(at your option) any later version.

	UserMgmt is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with Foobar.  If not, see <http://www.gnu.org/licenses/>.
*/
echo $this->Html->script('/usermgmt/js/umupdate');
?>

<div class="container-fluid">
	
			<div class="row-fluid">
				<div class="span12">
					<div class="content-widgets light-gray">
						<div class="widget-head orange">
							<h3>Group Permissions</h3>
						</div>
						 <div class=" information-container">
						<?php echo $this->Session->flash(); ?>
						<form class="form-horizontal">
						<div class="control-group">
						<label class="control-label">User Group Permissions</label>
						<div class="controls">
						<span  class="umstyle2"><?php __('Select Controller');?></span>  <?php echo $this->Form->input("controller",array('type'=>'select','div'=>false,'options'=>$allControllers,'selected'=>$c,'label'=>false,"onchange"=>"window.location='".SITE_URL."permissions/?c='+(this).value","data-placeholder"=>"Choose a Country...","class"=>"chzn-select span6"))?>
						</div>
						</div>
						</div>
						<?php   if (!empty($controllers)) { ?>
					<input type="hidden" id="BASE_URL" value="<?php echo SITE_URL?>">
					<input type="hidden" id="groups" value="<?php echo $groups?>">
							<table class="responsive table table-striped table-bordered" id="data-table">
							<thead>
							<tr>
								<th> <?php echo __("Controller");?> </th>
								<th> <?php echo __("Action");?> </th>
								<th> <?php echo __("Permission");?> </th>
								<th> <?php echo __("Operation");?> </th>
							</tr>
							</thead>
							<tbody>
			<?php
					$k=1;
					
					foreach ($controllers as $key=>$value) {
						if (!empty($value)) {
							for ($i=0; $i<count($value); $i++) {
								if (isset($value[$i])) {
									$action=$value[$i];
									echo $this->Form->create();
									echo $this->Form->hidden('controller',array('id'=>'controller'.$k,'value'=>$key));
									echo $this->Form->hidden('action',array('id'=>'action'.$k,'value'=>$action));
									
								echo "<tr>";
									echo "<td>".$key."</td>";
									echo "<td>".$action."</td>";
									echo "<td>";
									for ($j=0; $j<count($user_groups); $j++) {
										$ugname=$user_groups[$j];
										if (isset($value[$action][$ugname]) && $value[$action][$ugname]==1) {
											$checked=true;
										} else {
											$checked=false;
										}
										echo $this->Form->input($ugname,array('id'=>$ugname.$k,'type'=>'checkbox','checked'=>$checked));
									}
									echo "</td>";
									echo "<td>";
									echo $this->Form->button('Update', array('type'=>'button','id'=>'mybutton123','name'=>$k,'onClick'=>'javascript:update_fields('.$k.');', 'class'=>'btn btn-info'));
									echo "<div id='updateDiv".$k."' align='right'>&nbsp;</div>";
									echo "</td>";
									echo "</tr>";
									echo $this->Form->end();
									$k++;
							}
							}
							}
							}
							}
							
					?>
					</tbody>
					</table>
					</div>
				</div>
			</div>	
		</div>
	</div>		
<style>
.space{
margin:5px;
}
</style>


<script type = "text/javascript">
 $(function () {
                $('#data-table').dataTable({
                    "sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>"
                    /*"oTableTools": {
			"aButtons": [
				"copy",
				"print",
				{
					"sExtends":    "collection",
					"sButtonText": 'Save <span class="caret" />',
					"aButtons":    [ "csv", "xls", "pdf" ]
				}
			]
		}*/
                });
            });
</script>
