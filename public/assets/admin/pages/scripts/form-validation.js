var FormValidation = function () {

    // basic validation
    var handleValidation1 = function() {
        // for more info visit the official plugin documentation: 
            // http://docs.jquery.com/Plugins/Validation

            var form1 = $('#userAdd');
            var error1 = $('.alert-danger', form1);
            var success1 = $('.alert-success', form1);

			var clientsForm = $('#clients_form');
			var error2 = $('.alert-danger', clientsForm);
			
			var id = $('#id').val();
			if (id > 0) {
				form1.validate({
					errorElement: 'span', //default input error message container
					errorClass: 'help-block help-block-error', // default input error message class
					focusInvalid: false, // do not focus the last invalid input
					ignore: "",  // validate all fields including form hidden input
					rules: {
						firstname: {
							minlength: 2,
							required: true
						},
						lastname: {
							minlength: 2,
							required: true
						},
						rpassword: {
							equalTo: "#register_password"
						},
						permission: {
							required: true
						},
						mobile: {
							minlength: 2,
							required: true
						},
					},

					invalidHandler: function (event, validator) { //display error alert on form submit              
						success1.hide();
						error1.show();
						Metronic.scrollTo(error1, -200);
					},

					highlight: function (element) { // hightlight error inputs
						$(element)
							.closest('.form-group').addClass('has-error'); // set error class to the control group
					},

					unhighlight: function (element) { // revert the change done by hightlight
						$(element)
							.closest('.form-group').removeClass('has-error'); // set error class to the control group
					},

					success: function (label) {
						label
							.closest('.form-group').removeClass('has-error'); // set success class to the control group
					},

					submitHandler: function (form) {                    
						form.submit();
						error1.hide();
					}
				});

				clientsForm.validate({
					errorElement: 'span', //default input error message container
					errorClass: 'help-block', // default input error message class
					focusInvalid: false, // do not focus the last invalid input
					ignore: "",
					rules: {
						client: {
							required: true
						},
					},
					invalidHandler: function (event, validator) { //display error alert on form submit       
						error2.show();

						Metronic.scrollTo(error1, -200);
					},

					highlight: function (element) { // hightlight error inputs
						$(element)
							.closest('.form-group').addClass('has-error'); // set error class to the control group
					},

					unhighlight: function (element) { // revert the change done by hightlight
						$(element)
							.closest('.form-group').removeClass('has-error'); // set error class to the control group
					},

					success: function (label) {
						label
							.closest('.form-group').removeClass('has-error'); // set success class to the control group
					},
					submitHandler: function (form) {
							$clients = "";
							$('#clients').val('');
							$('#client option:selected').each(function(){			
								$clients += $(this).val() + ",";
							});
							if ($clients != "") {
								$('#clients').val($clients);
							}
							error2.hide();
							form.submit();
					}
				});
			} else {
				form1.validate({
					errorElement: 'span', //default input error message container
					errorClass: 'help-block help-block-error', // default input error message class
					focusInvalid: true, // do not focus the last invalid input
					ignore: "",  // validate all fields including form hidden input
					rules: {
						email: {
							required: true,
							email: true
						},
						firstname: {
							minlength: 2,
							required: true
						},
						lastname: {
							minlength: 2,
							required: true
						},
						password: {
							minlength: 5,
							required: true
						},
						rpassword: {
							minlength: 5,
							required: true,
							equalTo: "#register_password"
						},
						mobile: {
							minlength: 2,
							required: true
						},
						permission: {
							required: true
						},							
					},

					invalidHandler: function (event, validator) { //display error alert on form submit              
						success1.hide();
						error1.show();
						Metronic.scrollTo(error1, -200);
					},

					highlight: function (element) { // hightlight error inputs
						$(element)
							.closest('.form-group').addClass('has-error'); // set error class to the control group
					},

					unhighlight: function (element) { // revert the change done by hightlight
						$(element)
							.closest('.form-group').removeClass('has-error'); // set error class to the control group
					},

					success: function (label) {
						label
							.closest('.form-group').removeClass('has-error'); // set success class to the control group
					},

					submitHandler: function (form) {                    
						form.submit();
						error1.hide();
					}
				});			
			}



    }

    // validation using icons
    var handleValidation2 = function() {
        // for more info visit the official plugin documentation: 
            // http://docs.jquery.com/Plugins/Validation

            var form2 = $('#clientAdd');
            var error2 = $('.alert-danger', form2);
            var success2 = $('.alert-success', form2);

            form2.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block help-block-error', // default input error message class
                focusInvalid: true, // do not focus the last invalid input
                ignore: "",  // validate all fields including form hidden input
                rules: {
                    name: {
                        minlength: 2,
                        required: true
                    },
                    address: {
                        minlength: 2,
                        required: true
                    },
                    abn: {
                        minlength: 2,
                        required: true
                    },
                    email: {
                        required: true,
                        email: true
                    },
					phone: {
						required: true,
						number: true,
						minlength: 10
					},	
                    region: {
                        required: true
                    },
                },

                invalidHandler: function (event, validator) { //display error alert on form submit              
                    success2.hide();
                    error2.show();
                    Metronic.scrollTo(error2, -200);
                },

                highlight: function (element) { // hightlight error inputs
                    $(element)
                        .closest('.form-group').removeClass("has-success").addClass('has-error'); // set error class to the control group   
                },

                unhighlight: function (element) { // revert the change done by hightlight
					$(element)
						.closest('.form-group').removeClass('has-error'); // set error class to the control group                    
                },

                success: function (label, element) {
                    var icon = $(element).parent('.input-icon').children('i');
                    $(element).closest('.form-group').removeClass('has-error').addClass('has-success'); // set success class to the control group
                    icon.removeClass("fa-warning").addClass("fa-check");
                },

                submitHandler: function (form) {
                    form.submit();
                    error2.hide();
                }
            });
    }

   // validation using icons
    var handleValidation3 = function() {
        // for more info visit the official plugin documentation: 
            var form3 = $('#clientcontactAdd');
            var error3 = $('.alert-danger', form3);
            var success3 = $('.alert-success', form3);

            form3.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block help-block-error', // default input error message class
                focusInvalid: true, // do not focus the last invalid input
                ignore: "",  // validate all fields including form hidden input
                rules: {
                    client: {
                        required: true
                    },
                    name: {
                        minlength: 2,
                        required: true
                    },
                    email: {
                        required: true,
                        email: true
                    },
					mobile: {
						required: true,
						minlength: 2
					},
                },

                invalidHandler: function (event, validator) { //display error alert on form submit              
                    success3.hide();
                    error3.show();
                    Metronic.scrollTo(error3, -200);
                },

                highlight: function (element) { // hightlight error inputs
                    $(element)
                        .closest('.form-group').removeClass("has-success").addClass('has-error'); // set error class to the control group   
                },

                unhighlight: function (element) { // revert the change done by hightlight
					$(element)
						.closest('.form-group').removeClass('has-error'); // set error class to the control group                    
                },

                success: function (label, element) {
                    var icon = $(element).parent('.input-icon').children('i');
                    $(element).closest('.form-group').removeClass('has-error').addClass('has-success'); // set success class to the control group
                    icon.removeClass("fa-warning").addClass("fa-check");
                },

                submitHandler: function (form) {
                    form.submit();
                    error3.hide();
                }
            });
    }

   // validation using icons
    var handleValidation4 = function() {
        // for more info visit the official plugin documentation: 
            var form3 = $('#atmAdd');
            var error3 = $('.alert-danger', form3);
            var success3 = $('.alert-success', form3);

            form3.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block help-block-error', // default input error message class
                focusInvalid: true, // do not focus the last invalid input
                ignore: "",  // validate all fields including form hidden input
                rules: {
                    client: {
                        required: true
                    },
                    terminalID: {
                        minlength: 10,
                        required: true
                    },
                    name: {
                        minlength: 2,
                        required: true
                    },
                    modem: {
                        minlength: 2,
                        required: true
                    },
                    startdate: {
                        required: true
                    },
                    serial: {
                        minlength: 2,
                        required: true
                    },
                    address: {
                        minlength: 2,
                        required: true
                    },
                    site: {
                        minlength: 2,
                        required: true
                    },
                },
                errorPlacement: function (error, element) { // render error placement for each input type
                    if (element.parent(".input-group").size() > 0) {
                        error.insertAfter(element.parent(".input-group"));
                    } else if (element.attr("data-error-container")) { 
                        error.appendTo(element.attr("data-error-container"));
                    } else if (element.parents('.radio-list').size() > 0) { 
                        error.appendTo(element.parents('.radio-list').attr("data-error-container"));
                    } else if (element.parents('.radio-inline').size() > 0) { 
                        error.appendTo(element.parents('.radio-inline').attr("data-error-container"));
                    } else if (element.parents('.checkbox-list').size() > 0) {
                        error.appendTo(element.parents('.checkbox-list').attr("data-error-container"));
                    } else if (element.parents('.checkbox-inline').size() > 0) { 
                        error.appendTo(element.parents('.checkbox-inline').attr("data-error-container"));
                    } else {
                        error.insertAfter(element); // for other inputs, just perform default behavior
                    }
                },
                invalidHandler: function (event, validator) { //display error alert on form submit              
                    success3.hide();
                    error3.show();
                    Metronic.scrollTo(error3, -200);
                },

                highlight: function (element) { // hightlight error inputs
                    $(element)
                        .closest('.form-group').removeClass("has-success").addClass('has-error'); // set error class to the control group   
                },

                unhighlight: function (element) { // revert the change done by hightlight
					$(element)
						.closest('.form-group').removeClass('has-error'); // set error class to the control group                    
                },

                success: function (label, element) {
                    var icon = $(element).parent('.input-icon').children('i');
                    $(element).closest('.form-group').removeClass('has-error').addClass('has-success'); // set success class to the control group
                    icon.removeClass("fa-warning").addClass("fa-check");
                },

                submitHandler: function (form) {
                    form.submit();
                    error3.hide();
                }
            });

            //initialize datepicker
            $('.date-picker').datepicker({
                rtl: Metronic.isRTL(),
                autoclose: true
            });
            $('.date-picker .form-control').change(function() {
                form3.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input 
            })
    }

    // validation using icons
    var handleValidation5 = function() {
        // for more info visit the official plugin documentation: 
            // http://docs.jquery.com/Plugins/Validation

            var form5 = $('#bankAdd');
            var error5 = $('.alert-danger', form5);
            var success5 = $('.alert-success', form5);

            form5.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block help-block-error', // default input error message class
                focusInvalid: true, // do not focus the last invalid input
                ignore: "",  // validate all fields including form hidden input
                rules: {
                    bankName: {
                        minlength: 2,
                        required: true
                    },                 
                },

                invalidHandler: function (event, validator) { //display error alert on form submit              
                    success5.hide();
                    error5.show();
                    Metronic.scrollTo(error5, -200);
                },

                highlight: function (element) { // hightlight error inputs
                    $(element)
                        .closest('.form-group').removeClass("has-success").addClass('has-error'); // set error class to the control group   
                },

                unhighlight: function (element) { // revert the change done by hightlight
					$(element)
						.closest('.form-group').removeClass('has-error'); // set error class to the control group                    
                },

                success: function (label, element) {
                    var icon = $(element).parent('.input-icon').children('i');
                    $(element).closest('.form-group').removeClass('has-error').addClass('has-success'); // set success class to the control group
                    icon.removeClass("fa-warning").addClass("fa-check");
                },

                submitHandler: function (form) {
                    form.submit();
                    error5.hide();
                }
            });
    }

    // validation using icons
    var handleValidation6 = function() {
        // for more info visit the official plugin documentation: 
            // http://docs.jquery.com/Plugins/Validation

            var form6 = $('#accountAdd');
            var error6 = $('.alert-danger', form6);
            var success6 = $('.alert-success', form6);

            form6.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block help-block-error', // default input error message class
                focusInvalid: true, // do not focus the last invalid input
                ignore: "",  // validate all fields including form hidden input
                rules: {
                    user: {
                        minlength: 1,
                        required: true
                    },
                    bank: {
                        minlength: 1,
                        required: true
                    },
                    accountNumber: {
                        minlength: 1,
                        required: true
                    },
                    accountName: {
                        minlength: 2,
                        required: true
                    },					
                },

                invalidHandler: function (event, validator) { //display error alert on form submit              
                    success6.hide();
                    error6.show();
                    Metronic.scrollTo(error6, -200);
                },

                highlight: function (element) { // hightlight error inputs
                    $(element)
                        .closest('.form-group').removeClass("has-success").addClass('has-error'); // set error class to the control group   
                },

                unhighlight: function (element) { // revert the change done by hightlight
					$(element)
						.closest('.form-group').removeClass('has-error'); // set error class to the control group                    
                },

                success: function (label, element) {
                    var icon = $(element).parent('.input-icon').children('i');
                    $(element).closest('.form-group').removeClass('has-error').addClass('has-success'); // set success class to the control group
                    icon.removeClass("fa-warning").addClass("fa-check");
                },

                submitHandler: function (form) {
                    form.submit();
                    error6.hide();
                }
            });
    }

    // validation using icons
    var handleValidation7 = function() {
        // for more info visit the official plugin documentation: 
            // http://docs.jquery.com/Plugins/Validation

            var form7 = $('#branchAdd');
            var error7 = $('.alert-danger', form7);
            var success7 = $('.alert-success', form7);

            form7.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block help-block-error', // default input error message class
                focusInvalid: true, // do not focus the last invalid input
                ignore: "",  // validate all fields including form hidden input
                rules: {
                    bank: {
                        minlength: 1,
                        required: true
                    },
                    bankAddress: {
                        minlength: 2,
                        required: true
                    },
                    bankPhone: {
                        minlength: 2,
						number: true,
                        required: true
                    },
                    bankContactName: {
						minlength: 2,
                        required: true                        
                    },
                },

                invalidHandler: function (event, validator) { //display error alert on form submit              
                    success7.hide();
                    error7.show();
                    Metronic.scrollTo(error7, -200);
                },

                highlight: function (element) { // hightlight error inputs
                    $(element)
                        .closest('.form-group').removeClass("has-success").addClass('has-error'); // set error class to the control group   
                },

                unhighlight: function (element) { // revert the change done by hightlight
					$(element)
						.closest('.form-group').removeClass('has-error'); // set error class to the control group                    
                },

                success: function (label, element) {
                    var icon = $(element).parent('.input-icon').children('i');
                    $(element).closest('.form-group').removeClass('has-error').addClass('has-success'); // set success class to the control group
                    icon.removeClass("fa-warning").addClass("fa-check");
                },

                submitHandler: function (form) {
                    form.submit();
                    error7.hide();
                }
            });
    }

    // validation using icons
    var handleValidation8 = function() {
        // for more info visit the official plugin documentation: 
            // http://docs.jquery.com/Plugins/Validation

            var form8 = $('#transactionAdd');
            var error8 = $('.alert-danger', form8);
            var success8 = $('.alert-success', form8);

            form8.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block help-block-error', // default input error message class
                focusInvalid: true, // do not focus the last invalid input
                ignore: "",  // validate all fields including form hidden input
                rules: {
                    account: {
                        minlength: 1,
                        required: true
                    },
                    branch: {
                        minlength: 1,
                        required: true
                    },
                    atm: {
                        minlength: 1,
                        required: true
                    },
                    evidence: {
                        minlength: 1,
                        required: false
                    },  							
                },

                invalidHandler: function (event, validator) { //display error alert on form submit              
                    success8.hide();
                    error8.show();
                    Metronic.scrollTo(error8, -200);
                },

                highlight: function (element) { // hightlight error inputs
                    $(element)
                        .closest('.form-group').removeClass("has-success").addClass('has-error'); // set error class to the control group   
                },

                unhighlight: function (element) { // revert the change done by hightlight
					$(element)
						.closest('.form-group').removeClass('has-error'); // set error class to the control group                    
                },

                success: function (label, element) {
                    var icon = $(element).parent('.input-icon').children('i');
                    $(element).closest('.form-group').removeClass('has-error').addClass('has-success'); // set success class to the control group
                    icon.removeClass("fa-warning").addClass("fa-check");
                },

                submitHandler: function (form) {
                    form.submit();
                    error8.hide();
                }
            });
    }

    // validation using icons
    var handleValidation9 = function() {
        // for more info visit the official plugin documentation: 
            // http://docs.jquery.com/Plugins/Validation

            var form9 = $('#transactionAdd');
            var error9 = $('.alert-danger', form9);
            var success9 = $('.alert-success', form9);

            form9.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block help-block-error', // default input error message class
                focusInvalid: true, // do not focus the last invalid input
                ignore: "",  // validate all fields including form hidden input
                rules: {
                    account: {
                        minlength: 1,
                        required: true
                    },
                    branch: {
                        minlength: 1,
                        required: true
                    },
                    atm: {
                        minlength: 1,
                        required: true
                    }, 
                },

                invalidHandler: function (event, validator) { //display error alert on form submit              
                    success9.hide();
                    error9.show();
                    Metronic.scrollTo(error9, -200);
                },

                highlight: function (element) { // hightlight error inputs
                    $(element)
                        .closest('.form-group').removeClass("has-success").addClass('has-error'); // set error class to the control group   
                },

                unhighlight: function (element) { // revert the change done by hightlight
					$(element)
						.closest('.form-group').removeClass('has-error'); // set error class to the control group                    
                },

                success: function (label, element) {
                    var icon = $(element).parent('.input-icon').children('i');
                    $(element).closest('.form-group').removeClass('has-error').addClass('has-success'); // set success class to the control group
                    icon.removeClass("fa-warning").addClass("fa-check");
                },

                submitHandler: function (form) {
                    form.submit();
                    error9.hide();
                }
            });
    }
  
    // validation using icons
    var handleValidation10 = function() {
        // for more info visit the official plugin documentation: 
            // http://docs.jquery.com/Plugins/Validation

            var form10 = $('#contractAdd');
            var error10 = $('.alert-danger', form10);
            var success10 = $('.alert-success', form10);

            form10.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block help-block-error', // default input error message class
                focusInvalid: true, // do not focus the last invalid input
                ignore: "",  // validate all fields including form hidden input
                rules: {
                    atm: {
                        minlength: 1,
                        required: true
                    },
                    billingPeriodEnd: {
                        minlength: 2,
                        required: true
                    },                  
                },
                errorPlacement: function (error, element) { // render error placement for each input type
                    if (element.parent(".input-group").size() > 0) {
                        error.insertAfter(element.parent(".input-group"));
                    } else if (element.attr("data-error-container")) { 
                        error.appendTo(element.attr("data-error-container"));
                    } else if (element.parents('.radio-list').size() > 0) { 
                        error.appendTo(element.parents('.radio-list').attr("data-error-container"));
                    } else if (element.parents('.radio-inline').size() > 0) { 
                        error.appendTo(element.parents('.radio-inline').attr("data-error-container"));
                    } else if (element.parents('.checkbox-list').size() > 0) {
                        error.appendTo(element.parents('.checkbox-list').attr("data-error-container"));
                    } else if (element.parents('.checkbox-inline').size() > 0) { 
                        error.appendTo(element.parents('.checkbox-inline').attr("data-error-container"));
                    } else {
                        error.insertAfter(element); // for other inputs, just perform default behavior
                    }
                },
                invalidHandler: function (event, validator) { //display error alert on form submit              
                    success10.hide();
                    error10.show();
                    Metronic.scrollTo(error10, -200);
                },

                highlight: function (element) { // hightlight error inputs
                    $(element)
                        .closest('.form-group').removeClass("has-success").addClass('has-error'); // set error class to the control group   
                },

                unhighlight: function (element) { // revert the change done by hightlight
					$(element)
						.closest('.form-group').removeClass('has-error'); // set error class to the control group                    
                },

                success: function (label, element) {
                    var icon = $(element).parent('.input-icon').children('i');
                    $(element).closest('.form-group').removeClass('has-error').addClass('has-success'); // set success class to the control group
                    icon.removeClass("fa-warning").addClass("fa-check");
                },

                submitHandler: function (form) {
                    form.submit();
                    error10.hide();
                }
            });

            //initialize datepicker
            $('.date-picker').datepicker({
                rtl: Metronic.isRTL(),
                autoclose: true
            });
            $('.date-picker .form-control').change(function() {
                form3.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input 
            })
    }


    // validation using icons
    var handleValidation11 = function() {
        // for more info visit the official plugin documentation: 
            // http://docs.jquery.com/Plugins/Validation

            var form11 = $('#rebankAdd');
            var error11 = $('.alert-danger', form11);
            var success11 = $('.alert-success', form11);

            form11.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block help-block-error', // default input error message class
                focusInvalid: true, // do not focus the last invalid input
                ignore: "",  // validate all fields including form hidden input
                rules: {
                    cash: {
                        minlength: 1,
                        required: true
                    },
                    atm: {
                        minlength: 1,
                        required: true
                    },
                    CashSourceID: {
                        minlength: 1,
                        required: true
                    },
                    c1_loaded: {
                        minlength: 1,
                        number: true,
                        required: true
                    }, 
                    c2_loaded: {
                        minlength: 1,
                        number: true,
                        required: true
                    },   
                    c1_dispensed: {
                        minlength: 1,
                        number: true,
                        required: true
                    }, 
                    c2_dispensed: {
                        minlength: 1,
                        number: true,
                        required: true
                    }, 
                    c1_remaining: {
                        minlength: 1,
                        number: true,
                        required: true
                    }, 
                    c2_remaining: {
                        minlength: 1,
                        number: true,
                        required: true
                    },

                    c1_rejects: {
                        minlength: 1,
                        number: true,
                        required: true
                    }, 
                    c2_rejects: {
                        minlength: 1,
                        number: true,
                        required: true
                    },  
                    c1_test: {
                        minlength: 1,
                        number: true,
                        required: true
                    }, 
                    c2_test: {
                        minlength: 1,
                        number: true,
                        required: true
                    },      
                    c1_rebank_amount: {
                        minlength: 1,
						number: true,
                        required: true
                    },   
                    c2_rebank_amount: {
                        minlength: 1,
						number: true,
                        required: true
                    },   
                    totalRebankAmount: {
                        minlength: 1,
						number: true,
                        required: true
                    },      
                    day_total: {
                        minlength: 1,
						number: true,
                        required: true
                    },   
                    terminal_total_amount: {
                        minlength: 1,
						number: true,
                        required: true
                    }, 
                    host_total_amount: {
                        minlength: 1,
						number: true,
                        required: true
                    },    
                    evidence: {
                        minlength: 1,
                        required: false
                    },                                                                                                                                                                                                                       
                },

                invalidHandler: function (event, validator) { //display error alert on form submit              
                    success11.hide();
                    error11.show();
                    Metronic.scrollTo(error11, -200);
                },

                highlight: function (element) { // hightlight error inputs
                    $(element)
                        .closest('.form-group').removeClass("has-success").addClass('has-error'); // set error class to the control group   
                },

                unhighlight: function (element) { // revert the change done by hightlight
                    $(element)
                        .closest('.form-group').removeClass('has-error'); // set error class to the control group                    
                },

                success: function (label, element) {
                    var icon = $(element).parent('.input-icon').children('i');
                    $(element).closest('.form-group').removeClass('has-error').addClass('has-success'); // set success class to the control group
                    icon.removeClass("fa-warning").addClass("fa-check");
                },

                submitHandler: function (form) {
                    form.submit();
                    error11.hide();
                }
            });
    }

   // validation using icons
    var handleValidation12 = function() {
        // for more info visit the official plugin documentation: 
            // http://docs.jquery.com/Plugins/Validation

            var form12 = $('#cashAdd');
            var error12 = $('.alert-danger', form12);
            var success12 = $('.alert-success', form12);

            form12.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block help-block-error', // default input error message class
                focusInvalid: true, // do not focus the last invalid input
                ignore: "",  // validate all fields including form hidden input
                rules: {
                    cash: {
                        minlength: 1,
                        required: true
                    },
                    atm: {
                        minlength: 1,
                        required: true
                    },
                    CashSourceID: {
                        minlength: 1,
                        required: true
                    },
                    c1_loaded: {
                        minlength: 1,
                        number: true,
                        required: true
                    }, 
                    c2_loaded: {
                        minlength: 1,
                        number: true,
                        required: true
                    },
                    evidence: {
                        minlength: 1,
                        required: false
                    },                                                                                                                                                                                                                       
                },

                invalidHandler: function (event, validator) { //display error alert on form submit              
                    success12.hide();
                    error12.show();
                    Metronic.scrollTo(error12, -200);
                },

                highlight: function (element) { // hightlight error inputs
                    $(element)
                        .closest('.form-group').removeClass("has-success").addClass('has-error'); // set error class to the control group   
                },

                unhighlight: function (element) { // revert the change done by hightlight
                    $(element)
                        .closest('.form-group').removeClass('has-error'); // set error class to the control group                    
                },

                success: function (label, element) {
                    var icon = $(element).parent('.input-icon').children('i');
                    $(element).closest('.form-group').removeClass('has-error').addClass('has-success'); // set success class to the control group
                    icon.removeClass("fa-warning").addClass("fa-check");
                },

                submitHandler: function (form) {
                    form.submit();
                    error12.hide();
                }
            });
    }

    var handleWysihtml5 = function() {
        if (!jQuery().wysihtml5) {
            
            return;
        }

        if ($('.wysihtml5').size() > 0) {
            $('.wysihtml5').wysihtml5({
                "stylesheets": ["../../assets/global/plugins/bootstrap-wysihtml5/wysiwyg-color.css"]
            });
        }
    }

    return {
        //main function to initiate the module
        init: function () {
			
            handleWysihtml5();
            handleValidation1(); // User
            handleValidation2(); // Client
            handleValidation3(); // Client Contact
			handleValidation4(); // ATM
			handleValidation5(); // Bank
			handleValidation6(); // Bank Account
			handleValidation7(); // Bank Branch
			handleValidation8(); // Bank Transaction(Withdraw)
			
			handleValidation10(); // Contract
            handleValidation11(); // Fill & Rebank
            handleValidation12(); // Cash
		}

    };

}();