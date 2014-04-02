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
				title: 'OKTB Airlines Master',
				paging: true, 
	            pageSize: 10,
		        sorting: true, 
		        defaultSorting: 'a_id ASC',
		        
		        actions: {
					listAction: '<?php $this->webroot ?>admins/oktb_airline?action=list',
					createAction: '<?php $this->webroot ?>admins/oktb_airline?action=create',
					updateAction: '<?php $this->webroot ?>admins/oktb_airline?action=update',
					deleteAction: '<?php $this->webroot ?>admins/oktb_airline?action=delete'
				},
				fields: {
					a_id: {
						key: true,
						title: 'Airline Id',
						create: false,
		                edit: false,
		                list:false
					},
					a_name: {
						title: 'Airline',
						width: '20%',
					},
					a_price: {
						title: 'Cost Price',
						width: '10%',
					},
					a_sprice: {
						title: 'Selling Price',
						width: '15%',
					},
					a_email: {
						title: 'Email Id',
						width: '40%',
					},
					a_ccemail: {
						title: 'CC Email Id',
						width: '40%',
					},
					a_contact: {
						title: 'Contact No',
						width: '40%',
					},
					a_date: {
						title: 'Date',
						width: '30%',
						create:false,
						edit:false	
					},
					status: {
						title: 'Status',
						width: '20%',
						options: { '1': 'Active', '0': 'Inactive','2':'Urgent' },
					},
				}
			});

			//Load person list from server
			$('#PeopleTableContainer').jtable('load');

		});

	</script>
          