
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
				title: 'Passport Type Master',
				paging: true, 
	            pageSize: 10,
		        sorting: true, 
		        defaultSorting:'passport_type',
								
				actions: {
					listAction: '<?php $this->webroot ?>admins/ajax_action/passport?action=list',
					createAction: '<?php $this->webroot ?>admins/ajax_action/passport?action=create',
					updateAction: '<?php $this->webroot ?>admins/ajax_action/passport?action=update',
					deleteAction: '<?php $this->webroot ?>admins/ajax_action/passport?action=delete'
				},
				fields: {
					pass_type_id: {
						key: true,
						title: 'Passport Type Id',
						width: '20%',
						 create: false,
		                  edit: false,
		                  list:false
					},
					passport_type: {
						title: 'Passport Type',
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
				},
				
			
			});

			//Load person list from server
			$('#PeopleTableContainer').jtable('load');

		});

	</script>
          