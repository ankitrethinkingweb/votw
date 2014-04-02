
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
				title: 'Transaction Mode Master',
				paging: true, 
	            pageSize: 10,
		            sorting: true, 
		            defaultSorting: 'tr_mode_id asc',
		            
								
				actions: {
					listAction: '<?php $this->webroot ?>admins/ajax_action/tr_mode?action=list',
					createAction: '<?php $this->webroot ?>admins/ajax_action/tr_mode?action=create',
					updateAction: '<?php $this->webroot ?>admins/ajax_action/tr_mode?action=update',
					deleteAction: '<?php $this->webroot ?>admins/ajax_action/tr_mode?action=delete'
				},
				fields: {
					tr_mode_id: {
						key: true,
						title: 'Transaction Mode Id',
						width: '20%',
						create: false,
		                edit: false,
		                list:false
					},
					tr_mode: {
						title: 'Transaction Mode',
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
          