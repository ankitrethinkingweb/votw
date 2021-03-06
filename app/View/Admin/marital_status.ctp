
<?php 
			//echo $this->Html->script('jquery-ui-1.8.16.custom.min');
			echo $this->Html->script('jquery.jtable');
			echo $this->fetch('script');
			
			echo $this->Html->css('lightcolor/red/jtable');	
			echo $this->fetch('css');		
?>
          <div id="PeopleTableContainer" style="width: 100%;"></div>                        

          
          <script type="text/javascript">                  
		$(document).ready(function () {
			
		    //Prepare jTable
			$('#PeopleTableContainer').jtable({
				title: 'Marital Status Master',
				paging: true, 
	            pageSize: 10,
		            sorting: true, 
		            defaultSorting:'marital_status desc',
		            
								
				actions: {
					listAction: '<?php echo $this->webroot ?>admins/ajax_action/mar_status?action=list',
					createAction: '<?php echo $this->webroot ?>admins/ajax_action/mar_status?action=create',
					updateAction: '<?php echo $this->webroot ?>admins/ajax_action/mar_status?action=update',
					deleteAction: '<?php echo $this->webroot ?>admins/ajax_action/mar_status?action=delete'
				},
				fields: {
					marital_id: {
						key: true,
						title: 'Marital Status Id',
						width: '20%',
						 create: false,
		                    edit: false,
		                    list:false
					},
					marital_status: {
						title: 'Marital Status',
						width: '40%',
						inputClass: 'validate[required]'
							
					},
					create_date: {
						title: 'Create date',
						width: '30%',
						create:false,
						edit:false	
					},
					update_date: {
						title: 'Update date',
						width: '30%',
						create:false,
						edit:false	
					},
					status: {
						title: 'Status',
						width: '20%',
						options: { '1': 'Active', '0': 'Inactive' },
						inputClass: 'validate[required]'	
					},
				}
			});

			//Load person list from server
			$('#PeopleTableContainer').jtable('load');

		});

	</script>
          