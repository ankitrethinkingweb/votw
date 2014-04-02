/*$(function () {  
    $.validator.addMethod("anyDate",
    		function(value, element) {
    		return value.match(/^(0?[1-9]|[12][0-9]|3[0-2])[.,/ -](0?[1-9]|1[0-2])[.,/ -](19|20)?\d{2}$/);
    		},
    		"Please enter valid date"
    		);
    		               
    		               
    		              
    		               $(".form-horizontal").validate({
    		              
    		                    rules: {
    		                     	'data[User][dependent_id]':{
    		                     	required:function(){
    		              return $("#visaform input[type='radio']:checked").val() == 'dependent';
    		               },
    		                     	 number: true,
    		                     	 },
    		                     
    		                       'data[User][ticket_no]': {
    		                       		required: true,
    		                        	//alphanumeric: true, 
    		                            minlength: 2
    		                        },
    		                        'data[User][first_name]': {
    		                            required: true,
    		                        },
    		                        'data[User][last_name]': {
    		                            required: true,
    		                         
    		                        },
    		                        
    		                          'data[User][father_name]': {
    		                            required: true,
    		                         
    		                        },
    		                        
    		                           'data[User][mother_name]': {
    		                            required: true,
    		                         
    		                        },
    		                        
    		                        'data[User][marital_status]' :{ 
    		                     	required :true,
    		                     	 digits: true,
    		          				  }, 
    		          				  
    		          				   'data[User][language]' :{ 
    		                     	required :true,
    		                     	 digits: true,
    		          				  }, 
    		          				  
    		          				    'data[User][cur_nationality]' :{ 
    		                     
    		                     	 digits: true,
    		          				  }, 
    		          				  
    		          				    'data[User][pre_nationality]' :{ 
    		                     
    		                     	 digits: true,
    		          				  }, 
    		          				  
    		          				    'data[User][dob]': {
    		                            required: true,
    		                            anyDate:true
    		                         
    		                        },
    		                        
    		                         'data[User][birth_place]': {
    		                            required: true,
    		                         
    		                        },
    		                        
    		                        
    		          				    'data[User][religion]' :{ 
    		                     	required :true,
    		                     	 digits: true,
    		          				  }, 
    		          				      'data[User][profession]' :{ 
    		                     	required :true,
    		                     	 digits: true,
    		          				  }, 
    		          				  
    		          				      'data[User][education]' :{ 
    		                     	required :true,
    		                     	 digits: true,
    		          				  }, 
    		          				  
    		          				  'data[User][passport_no]' :{ 
    		                     	required :true,
    		                     	 alphanumeric: true,
    		          				  }, 
    		          				  
    		          				  'data[User][issue_date]' :{ 
    		                     	required :true,
    		                     	  anyDate:true
    		          				  },
    		          				  
    		          				  'data[User][exp_date]' :{ 
    		                     	required :true,
    		                     	  anyDate:true
    		          				  },
    		          				  
    		          				   'data[User][passport_type]' :{ 
    		                     	required :true,
    		                     	 digits: true,
    		          				  }, 
    		          				  
    		          				  'data[User][issue_govt]' :{ 
    		                     	required :true,
    		                     	 digits: true,
    		          				  }, 
    		          				  
    		          				   'data[User][issue_country]' :{ 
    		                     	required :true,
    		                     	 digits: true,
    		          				  }, 
    		          				  
    		          				   'data[User][issue_place]' :{ 
    		                     	required :true,
    		                     	
    		          				  }, 
    		          				  
    		          				     'data[User][visit_purpose]' :{ 
    		                     	required :true,
    		                     	 digits: true,
    		          				  },
    		          				  
    		          				   'data[User][address1]' :{ 
    		                     	required :true,
    		                     	minlength:4
    		          				  },
    		          				  
    		          				  'data[User][city]' :{ 
    		                     	required :true,
    		                     	minlength:3
    		          				  },
    		          				  
    		          				  'data[User][country]' :{ 
    		                     	required :true,
    		                     	 digits: true,
    		          				  },
    		          				  
    		          				  'data[User][pin]' :{ 
    		                     	required :true,
    		                     	 number: true,
    		          				  },
    		          				  
    		          				   'data[User][mobile]' :{ 
    		                     	required :true,
    		                     	 number: true,
    		                     	 minlength:10
    		          				  },
    		          				  
    		          				   'data[User][std_code]' :{ 
    		                     	 number: true,
    		                     	
    		          				  },
    		          				  
    		          				   'data[User][phone]' :{ 
    		                     	 number: true,
    		                     	
    		          				  },
    		          				  
    		                        'data[User][email_id]': {
    		                        
    		                            email: true
    		                        },
    		                        'data[User][hotel_address]': {
    		                            required: true,
    		                          
    		                        },
    		                      	'data[User][po_box]': {
    		                            required: true,
    		                            number:true,
    		                            minlength: 2
    		                        },
    		                      	'data[User][city]': {
    		                            required: true,
    		                            minlength: 2
    		                        },
    		                        
    		                        'data[User][telephone]' :{ 
    		                        required:true,
    		                     	 number: true,
    		                     	minlength:10
    		          				  },
    		          				  
    		                        'data[User][emp_type]': {
    		                            digit: true
    		                        }, 
    		                     
    		                       
    		                        
    		                        'data[User][company_contact]' :{ 
    		                     	 number: true,
    		                     	minlength:10
    		          				  },
    		                        
    		                        
    		                        'data[User][emp_date]': {
    		                           
    		                       		anyDate:true
    		                        }, 
    		                        
    		                         'data[User][pnr_no]': {
    		                            required: true,
    		                       		alphanumeric:true
    		                        }, 
    		                        
    		                        'data[User][coming_from]': {
    		                            required: true,
    		                       		digit:true
    		                        }, 
    		                        
    		                         'data[User][arrival_flight]': {
    		                            required: true,
    		                       		alphanumeric:true
    		                        }, 
    		                        
    		                        'data[User][arrival_date]': {
    		                            required: true,
    		                       		anyDate:true
    		                        }, 
    		                        
    		                         'data[User][arrival_time]': {
    		                            required: true,
    		                       		
    		                        }, 
    		                        
    		                         'data[User][leaving_to]': {
    		                            required: true,
    		                       		digit:true
    		                        }, 
    		                        
    		                         'data[User][departure_flight]': {
    		                            required: true,
    		                       		alphanumeric:true
    		                        }, 
    		                        
    		                        'data[User][departure_date]': {
    		                            required: true,
    		                       		anyDate:true
    		                        }, 
    		                        
    		                         'data[User][departure_time]': {
    		                            required: true,
    		                       		
    		                        }, 
    		                        
    		                         'data[User][airline]': {
    		                            required: true,
    		                       		digit:true
    		                        }, 
    		                        'data[User][visa_type]': {
    		                            required: true,
    		                       		digit:true
    		                        }, 
    		                        
    		                        'data[User][currency]': {
    		                            required: true,
    		                       		digit:true
    		                        }, 
    		                        
    		                        'data[User][photograph]': {
    		                            required: true,
    		                       		
    		                        }, 
    		                        
    		                        'data[User][bio_page]': {
    		                            required: true,
    		                       		
    		                        }, 
    		                        
    		                        'data[User][last_page]': {
    		                            required: true,
    		                       		
    		                        }, 
    		                        
    		                        'data[User][ticket]': {
    		                            required: true,
    		                       		
    		                        }, 
    		                    },
    		                    messages: {
    		                    'data[User][relation]':{
    		                    required : "Please Select Relationship",
    		                    digits : "Please Select Relationship",
    		                    },
    		                    'data[User][dependent_id]':"Please Enter Valid Dependent ID",
    		                    
    		                      'data[User][ticket_no]':"Please Enter Valid Ticket Number",
    		                     
    		                        'data[User][first_name]': {
    		                            required: "Please enter a first name",
    		                            //minlength: "Your username must consist of at least 2 characters"
    		                        },
    		                       'data[User][last_name]': {
    		                            required: "Please enter a last name",
    		                         //   minlength: "Your password must be at least 5 characters long"
    		                        },
    		                        
    		                        'data[User][father_name]': {
    		                            required: "Please enter a father name",
    		                         //   minlength: "Your password must be at least 5 characters long"
    		                        },
    		                        
    		                        'data[User][mother_name]': {
    		                            required: "Please enter a mother name",
    		                         //   minlength: "Your password must be at least 5 characters long"
    		                        },
    		                        'data[User][marital_status]': {
    		                            required: "Please select marital status",
    		                         //   minlength: "Your password must be at least 5 characters long"
    		                        },
    		                        
    		                         'data[User][language]': {
    		                            required: "Please select language",
    		                         //   minlength: "Your password must be at least 5 characters long"
    		                        },
    		                        
    		                         'data[User][cur_nationality]': {
    		                            digits: "Please select current nationality",
    		                       
    		                        },
    		                        
    		                         'data[User][pre_nationality]': {
    		                            digits: "Please select previous nationality",
    		                       
    		                        },
    		                        
    		                         'data[User][dob]': {
    		                            required: "Please enter date of birth",
    		                            anyDate: "Please enter valid date of birth",
    		                        },
    		                        
    		                         'data[User][birth_place]': {
    		                            required: "Please enter birth place",
    		                       
    		                        },
    		                        
    		                          'data[User][religion]': {
    		                            digits: "Please select religion",
    		                       
    		                        },
    		                        
    		                        'data[User][profession]': {
    		                            digits: "Please select profession",
    		                       
    		                        },
    		                        
    		                          'data[User][education]': {
    		                            digits: "Please select education",
    		                       
    		                        },
    		                        
    		                        'data[User][passport_no]': {
    		                            required: "Please enter valid passport number",
    		                       
    		                        },
    		                        
    		                         'data[User][issue_date]': {
    		                         
    		                          required: "Please enter passport issue date",
    		                            anyDate: "Please enter valid passport issue date",
    		                        
    		                       
    		                        },
    		                        
    		                           'data[User][exp_date]': {
    		                         
    		                          required: "Please enter passport expiry date",
    		                            anyDate: "Please enter valid passport expiry date",
    		                        
    		                       
    		                        },
    		                        
    		                         'data[User][passport_type]': {
    		                         
    		                          required: "Please select passport type",
    		                              digit: "Please select passport type",
    		                        
    		                       
    		                        },
    		                          'data[User][issue_govt]': {
    		                         
    		                          required: "Please select passport issue government",
    		                              digit: "Please select passport issue government",
    		                        
    		                       
    		                        },
    		                        
    		                         'data[User][issue_country]': {
    		                         
    		                          required: "Please select passport issue country",
    		                              digit: "Please select passport issue country",
    		                        
    		                       
    		                        },
    		                        
    		                         'data[User][issue_place]': {
    		                         
    		                          required: "Please enter passport issue place",
    		                        },
    		                        
    		                         'data[User][visit_purpose]': {
    		                         
    		                          required: "Please select purpose of visit",
    		                              digit: "Please select purpose of visit",
    		                        
    		                       
    		                        },
    		                        
    		                          'data[User][address1]': {
    		                         
    		                          required: "Please enter Address 1",
    		                        },
    		                        
    		                          'data[User][city]': {
    		                         
    		                           required: "Please enter City",
    		                        },
    		                        
    		                        'data[User][country]': {
    		                         
    		                          required: "Please select country",
    		                              digit: "Please select country",
    		                        
    		                       
    		                        },
    		                        
    		                         'data[User][pin]': {
    		                         
    		                          required: "Please enter pincode",
    		                              number: "Please enter valid pincode",
    		                        
    		                       
    		                        },
    		                        
    		                          'data[User][mobile]': {
    		                         
    		                          required: "Please enter mobile number",
    		                              number: "Please enter valid mobile number",
    		                        
    		                       
    		                        },
    		                        
    		                          'data[User][std_code]': {
    		                          number: "Please enter valid  std code",
    		                        },
    		                        
    		                          'data[User][phone]': {
    		                          number: "Please enter valid  std code",
    		                        },
    		                        
    		                          'data[User][email_id]': {
    		                          email: "Please enter valid  email id",
    		                        },
    		                        
    		                         'data[User][hotel_address]': {
    		                          required: "Please enter hotel address",
    		                        },
    		                        
    		                        'data[User][po_box]': {
    		                          required: "Please enter PO Box Number",
    		                        },
    		                        
    		                         'data[User][city]': {
    		                          required: "Please enter city",
    		                        },
    		                        
    		                         
    		                         'data[User][telephone]': {
    		                          required: "Please enter telephone number",
    		                            number: "Please enter valid telephone number",
    		                          minlength:"Please enter valid telephone number"
    		                        },
    		                        
    		                         'data[User][company_contact]': {
    		                     number: "Please enter valid telephone number",
    		                          minlength:"Please enter valid telephone number"
    		                        },
    		                        
    		                         'data[User][emp_date]': {
    		                     anyDate: "Please enter valid last employment date",
    		                         
    		                        },
    		                        
    		                        'data[User][pnr_no]': {
    		                     required: "Please enter PNR number",
    		                          alphanumeric:"Please enter valid PNR number"
    		                        },
    		                        
    		                          'data[User][coming_from]': {
    		                     required: "Please select coming from city",
    		                          digit:"Please select coming from city"
    		                        },
    		                        
    		                         
    		                        'data[User][arrival_flight]': {
    		                     required: "Please enter Arrival Flight number",
    		                          alphanumeric:"Please enter valid Arrival Flight number"
    		                        },
    		                        
    		                        'data[User][arrival_date]': {
    		                     required: "Please enter Arrival Date",
    		                          anyDate:"Please enter Arrival Date"
    		                        },
    		                        
    		                      'data[User][arrival_time]': {
    		                     required: "Please enter Arrival Time",
    		                        },  
    		                        
    		                          'data[User][leaving_to]': {
    		                     required: "Please select leaving to city",
    		                          digit:"Please select leaving to city"
    		                        },
    		                        
    		                         
    		                        'data[User][departure_flight]': {
    		                     required: "Please enter Departure Flight number",
    		                          alphanumeric:"Please enter valid Departure Flight number"
    		                        },
    		                        
    		                        'data[User][departure_date]': {
    		                     required: "Please enter Departure Date",
    		                          anyDate:"Please enter Departure Date"
    		                        },
    		                        
    		                      'data[User][departure_time]': {
    		                     required: "Please enter Departure Time",
    		                        }, 
    		                        
    		                          
    		                      'data[User][airline]': {
    		                     required: "Please select Airline",
    		                      digit: "Please select Airline",
    		                        },  
    		                        
    		                        'data[User][visa_type]': {
    		                     required: "Please select Visa Type",
    		                      digit: "Please select Visa Type",
    		                        },  
    		                        
    		                           'data[User][currency]': {
    		                     required: "Please select Currency",
    		                      digit: "Please select Currency",
    		                        },  
    		                        
    		                        'data[User][photograph]': {
    		                     required: "Please Upload Photograph",
    		                     
    		                        },  
    		                        
    		                        'data[User][bio_page]': {
    		                     required: "Please Upload passport bio page",
    		                     
    		                        },  
    		                        
    		                        'data[User][last_page]': {
    		                     required: "Please upload passport last page",
    		                   
    		                        },  
    		                        
    		                        'data[User][ticket]': {
    		                     required: "Please upload ticket",
    		                   
    		                        },  
    		                      
    		                    }
    		                    
    		                });
    		                $("#relation").rules("add", "digits"); 
    		            });
    		*/