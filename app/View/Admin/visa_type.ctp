
<?php 
			//echo $this->Html->script('jquery-ui-1.8.16.custom.min');
			echo $this->Html->script('jquery.jtable');
			echo $this->fetch('script');
			echo $this->Html->script('jquery.validate');
echo $this->Html->script('ckeditor/ckeditor');
			echo $this->Html->css('lightcolor/red/jtable');	
			echo $this->fetch('css');		
?>
          <div id="PeopleTableContainer" style="width: 100%;"></div>                        

          
          <script type="text/javascript">                  
		$(document).ready(function () {
			
		    //Prepare jTable
			$('#PeopleTableContainer').jtable({
				title: 'Visa Type Master',
				paging: true, 
	            pageSize: 10,
		        sorting: true, 
		        defaultSorting:'visa_type_id',
								
				actions: {
					listAction: '<?php $this->webroot ?>admins/visa_type_action?action=list',
					createAction: '<?php $this->webroot ?>admins/visa_type_action?action=create',
					updateAction: '<?php $this->webroot ?>admins/visa_type_action?action=update',
					deleteAction: '<?php $this->webroot ?>admins/visa_type_action?action=delete'
				},
				fields: {
					visa_type_id: {
						key: true,
						title: 'Visa Type Id',
						width: '10%',
						 create: false,
		                  edit: false,
		                  list:false
					},
					
					visa_type: {
						title: 'Visa Type',
						width: '20%',
						inputClass: 'validate[required]'
					},
					visa_cost: {
						title: 'Visa Cost Price',
						width: '10%',
						inputClass: 'validate[required]'							
					},
					visa_scost: {
						title: 'Visa Selling Price',
						width: '10%',
						inputClass: 'validate[required]'							
					},
					create_date: {
						title: 'Create date',
						width: '20%',
						create:false,
						edit:false	
					},
					update_date: {
						title: 'Update date',
						width: '20%',
						create:false,
						edit:false	
					},
					ext_status: {
						title: 'Extension Type',
						width: '20%',
						options: { '1': 'Extendable', '0': 'Non-Extendable' },
						inputClass: 'validate[required]'	
					},
					MyButton: {
					title: 'Eligibility',
					width: '40%',
					create:false,
					edit:false,
					display: function(data) {
					return '<a style="font-size:10px;" href="<?php echo $this->webroot; ?>users/visatype_ckedit/'+data.record.visa_type_id+'" target="_" class="prompt btn" >View / Edit</a> ';
						}
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
		

				 
function view(id){

			$.ajax({
					  url: "<?php echo $this->webroot; ?>users/visatype_ckedit/"+id,
					  dateType:'html',
					  type:'post',
					  data:'id='+id,
					  success: function(data){	    
						 bootbox.alert(data, function () {
					 CKEDITOR.replace('#document');

						 });
						 
				  },         
				})
}

	</script>
          