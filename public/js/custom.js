/* ------------------------------------------------------------------------------
 *
 *  # Custom JS code
 *
 *  Place here all your custom js. Make sure it's loaded after app.js
 *
 * ---------------------------------------------------------------------------- */
const editors = new Map(); // You can also use new Map() if you use ES6.

const Custom = function () {


		const _ajaxCall = (ele) =>{
			$(document).on('click', ele , function (e) {				   
				e.preventDefault();			       
				// object instance        
				$this = $(this);

				// initialize variable
				var url = ($this.hasAttr("data-ajax-url")) ? $this.data("ajax-url") : $this.attr("href") ,
				responseShow = ($this.hasAttr("data-ajax-response-show")) ? $this.data("ajax-response-show") : "#response-container" ,
				data  = ($this.hasAttr("data-ajax-data")) ? $this.data('ajax-data') : null,
				type  = ($this.hasAttr("data-ajax-type")) ? $this.data('ajax-type') : "GET" ,
				trigger = ($this.hasAttr("data-ajax-trigger")) ? $this.data('ajax-trigger') : "html";

				$.ajax({
							type:type,
							url:url,
							data:data,
							success:function(response){                
														// Append response          
														if(trigger == "append")
															$(responseShow).append(response);
														else if(trigger == "prepend")
															$(responseShow).prepend(response);
														else
															$(responseShow).html(response);

														// show the modal
														if($this.hasAttr("data-hide-modal")){
															var modalId  = ($this.hasAttr("data-modal-id")) ? $this.data('modal-id') : "#dynamicModal" ;
															$(modalId).modal("hide");
														}
														
														$.fn.modal.Constructor.prototype.enforceFocus = function() {};		
														Custom.initFvFormValidation();	
														Custom.initSelectComponent();						
														feather.replace()
									
							}
				}); 
			});
		}


		const _dynamicModal = (linkedClass , linkedModal) => {
		 
			$(document).on('click', linkedClass , function (e) {				   
			       e.preventDefault();			       
			       // object instance        
			       $this = $(this);
			       // initialize variable
			       var url = ($this.hasAttr("data-ajax-url")) ? $this.data("ajax-url") : $this.attr("href") ,
			           responseShow = ($this.hasAttr("data-ajax-response-show")) ? $this.data("ajax-response-show") : "#dynamicModal" ,
			           data  = ($this.hasAttr("data-ajax-data")) ? $this.data('ajax-data') : null,
			           type  = ($this.hasAttr("data-ajax-type")) ? $this.data('ajax-type') : "GET" ,
			           trigger = ($this.hasAttr("data-ajax-trigger")) ? $this.data('ajax-trigger') : "html";
			       
			       // set modal directions
				   ($this.hasAttr("data-modal-direction")) ? $(linkedModal).addClass($this.data('modal-direction')) : $(linkedModal).addClass("right");    
			       
				   if($this.data('template')){
					   $(linkedModal).html(" <div class='modal-dialog'> " +
							   						"<div class='modal-content'> " +
							   							" <div class='modal-header bg-light'> " +
							   								" <h5 class='modal-title'> " + $this.data('modal-title') + " </h5> " +
							   								" <a href='javascript:void(0)' class='close' data-dismiss='modal'>&times;</a>" +
							   							"</div>" +
							   							"<div class='modal-body'>" +
							   								" <p>" + $this.data('modal-body') + " </p>"+
							   							"</div>" +
							   							"<div class='modal-footer bg-solitude'>"+
							   								" <button type='button' class='btn btn-danger px-5 text-xs' data-dismiss='modal'>Close</button>" +    
							   							"</div>"+
							   						"</div>"+
					   							"</div>").modal("show");                
				   }else{
					   $.ajax({
						   		type:type,
						   		url:url,
						   		data:data,
						   		success:function(response){                
						   									// Append response          
						   									if(trigger == "append")
					   											$(responseShow).append(response);
						   									else if(trigger == "prepend")
						   										$(responseShow).prepend(response);
						   									else
						   										$(responseShow).html(response);

						   									// show the modal
						   									$(linkedModal).modal("show");

						   									// initialize validation   
						   									//Initialize
						   								 //
						   								  $(linkedModal).on('hidden.bs.modal', function (event) {
						   									  $(linkedModal).html("");
						   								  }); 
						   				
						   		}
					   });  
			      } 
				   
			
			});
	   }
		
		
	   const _extendDataTableDefaults = () => {
		   // Setting datatable defaults
		   $.extend( $.fn.dataTable.defaults, {
	            autoWidth: false,
	            dom: '<"datatable-header"fB><"datatable-scroll-wrap"t><"datatable-footer"ip>',
	            language: {
	                search: '_INPUT_',
	                searchPlaceholder: 'Type to filter...',
	                lengthMenu: '<span>Show:</span> _MENU_',
	                paginate: { 'first': 'First', 'last': 'Last', 'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;', 'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;' }
	            },
	            lengthMenu: [
	                [ 10, 25, 50, -1 ],
	                [ '10 rows', '25 rows', '50 rows', 'Show all' ]
	            ],
	            buttons: [           
	                {   
	                    extend: 'excel',
	                    text: '<i class="icon-file-spreadsheet mr-2"></i> Excel',                    
	                    className:'btn btn-primary btn-sm'
	                },
	                {   
	                    extend: 'copy',
	                    text: '<i class="icon-copy3 mr-2"></i> Copy',
	                    className:'btn btn-primary btn-sm'
	                },
	                {   
	                    extend: 'print',
	                    text: '<i class="icon-printer mr-2"></i> Print',
	                    className:'btn btn-primary btn-sm'
	                },
	                {
	                    extend: 'colvis',
	                    text:'',
	                    columns: ':not(.noVis)',
	                    className: 'btn btn-primary btn-sm dropdown-toggle'
	                },
	                {
	                    extend: 'pageLength',
	                    className: 'btn btn-success btn-sm'
	                }
	            ],
	            columnDefs: [
	                {
	                    orderable: false,
	                    className: 'select-checkbox noVis',
	                    targets: 0
	                },
	                {
	                   targets:0,
	                   className: 'noVis'
	                }

	            ],
	            select: {
	                style: 'os',
	                selector: 'td:first-child'
	            },
	            order: [[1, 'asc']]
	        });

	        // Apply custom style to select
	        $.extend( $.fn.dataTableExt.oStdClasses, {            
	            "sFilterInput": "form-control form-control-sm"
	        });
	   }
	   
	   const _check_ele_attribute = () => {
		   //custom function	
		   $.fn.hasAttr = function(name) {  
			   return this.attr(name) !== undefined;
		   };
	   }
	   
	   
/*	   const _fv_form_validation = () => {
	    	$(".fv-form").formValidation({
	            message: 'This field is required and cannot be empty',
	            excluded: ':disabled'
	    	})
			.on('success.form.fv', function(e) {
	        	// Get the form instance
	            var $form = $(e.target);
	            
	        	if($form.hasAttr("data-ajax-form")){
	        		// Prevent form submission
	        		e.preventDefault();	        		
	            	// response
	            	var responseShow = ($form.hasAttr("data-ajax-response-show")) ? $form.data("ajax-response-show") : "#response-container";	            	
	            	// trigger action
	            	var trigger = ($form.hasAttr("data-ajax-trigger")) ? $form.data('ajax-trigger') : "html";	            	
	            	// ajax loader ui message					            	
	            	$loaderMessage = ($this.hasAttr("data-ajax-loader-message")) ? $this.data('ajax-loader-message') : "We are processing your request.  Please be patient.";
	            	$(responseShow).block({message: $loaderMessage });
	            	
	            	// Use Ajax to submt form data
	            	$.post($form.attr('action'), $form.serialize(), function(response) {		
	            		
	                    if(trigger == "append")
	                        $(responseShow).append(response);
	                    else if(trigger == "prepend")
	                        $(responseShow).prepend(response);
	                    else
	                        $(responseShow).html(response);	
	                    
	                    $form
		                	.formValidation('disableSubmitButtons', false)  // Enable the submit buttons
		                	.formValidation('resetForm', true);             // Reset the form             
				               
	            	});
	        	}
	        });
	   }*/
	   
	   
	   const _fv_form_validation = () => {
			$( ".fv-form" ).each(function( i,e ) {
				var formFv = $(e).data('formValidation');		
				if (formFv === undefined) {
					$(e).formValidation({
						message: 'This field is required and cannot be empty',
						excluded: ':disabled'
					})
					.on('success.form.fv', function(e) {
						// Get the form instance
						var $form = $(e.target);
						$message =  ($form.hasAttr("data-message")) ? $form.data('message') : "Are you sure?";
						if($form.hasClass("confirm-request") && !confirm){
							e.preventDefault();
							bootbox.confirm({ 
								centerVertical:true,
								message: $message,
								onHide: function(e) {
									confirm = false;
								} ,
								callback: function(result){ 							
									if(result){
										confirm = result;										
										$form.submit();										 							
									}else {
										$form
											.formValidation('disableSubmitButtons', false)  // Enable the submit buttons
											.formValidation('resetForm', true);             // Reset the form  	
										
										return false;
									}					
								}
							});
						}
						
						if($form.hasAttr("data-ajax-form")){
							// Prevent form submission
							e.preventDefault();	        		
							// response
							var responseShow = ($form.hasAttr("data-ajax-response-show")) ? $form.data("ajax-response-show") : "#response-container";	            	
							// trigger action
							var trigger = ($form.hasAttr("data-ajax-trigger")) ? $form.data('ajax-trigger') : "html";	            	
							// Use Ajax to submt form data
							$.ajax({
										type:"POST",
										url: $form.attr('action'),
										data:new FormData($form[0]),	
										processData: false,
										contentType: false,																			
										success:function(response){
											console.log(responseShow);

											if(trigger == "append")
												$(responseShow).append(response);
											else if(trigger == "prepend")
												$(responseShow).prepend(response);
											else
												$(responseShow).html(response);
												
					
											// show the modal
											if($form.hasAttr("data-hide-modal")){
												var modalId  = ($form.hasAttr("data-modal-id")) ? $form.data('modal-id') : "#dynamicModal" ;
												$(modalId).modal("hide");
											}
											
											$.fn.modal.Constructor.prototype.enforceFocus = function() {};
					
											$form
												.formValidation('disableSubmitButtons', false)  // Enable the submit buttons
												.formValidation('resetForm', true);             // Reset the form  			
					
											// 	
											Custom.initSelectComponent();
											feather.replace();
										}
							});							
						}
					});	
				}
		  	});    	
	   }
	   
	   const _select_component = (ele) => {
		   									$(ele).select2();
	   }
	   
	   const _ck_editor = (ele) => {
		   if($(ele).length > 0){
				let toolbar = ['heading','|','bold','italic','underline','link','alignment','subscript','superscript','strikethrough','|','bulletedList','numberedList','todoList'];
				if($(ele).hasAttr('data-toolbar-full'))
						toolbar = [
										'heading',
										'|',
										'bold',
										'italic',
										'underline',
										'link',
										'bulletedList',
										'numberedList',
										'todoList',
										'|',
										'blockQuote',
										'alignment',
										'outdent',
										'indent',
										'subscript',
										'superscript',
										'removeFormat',
										'strikethrough',
										'|',
										'fontColor',
										'fontBackgroundColor',
										'fontSize',
										'fontFamily',
										'insertTable',
										'mediaEmbed',
										'imageInsert',
										'htmlEmbed',
										'findAndReplace',
										'horizontalLine',
										'undo',
										'redo','|', 'toggleImageCaption', 'linkImage'
									];


									$(ele).each(function(k,e){
										if($(e).hasAttr("id")){
											let id = $(e).attr("id");
											console.log(id);
											//createEditor( id,toolbar,false , $(e));																						
										}										
									});
 
		   }		   
	   }

	   function createEditor( elementId,toolbar,validate , ele) {
					ClassicEditor
						.create( document.querySelector("#"+elementId), {
							toolbar: {			
								items: toolbar
							}							
						} )
						.then( editor => { 
//							editors[ elementId ] = editor; 							
//							editors[ elementId ].model.document.on( 'change:data', (e) => {
//								ele.val(editors[ elementId ].getData());
//                    			ele.closest("form").formValidation('revalidateField', ele);								
//							} );
							
						})
						.catch( error => {
							console.error( 'Oops, something went wrong!' );
							console.error( error );
						} );  
	   }
	   
	   const _date_picker = (ele) => {
		   $(ele).daterangepicker({
			   singleDatePicker: true
	       });		   
	   }
	   
	   const _select2_ajax = (ele) => {
			$(ele).select2({								
				multiple: true,				
				minimumInputLength: 2,
				ajax: {
					url: $(this).data('ajaxUrl'),
					dataType: "json",
					type: "POST",
					data: function (params) {
						return {
								 searchTerm: params.term,
								 term:params.term,
						       };			
					},
					processResults: function (response) {	
						let id = $(this).get(0).options.options.listKey;
						let text = $(this).get(0).options.options.listValue;
						//			
						return {
							results:$.map(response,function(o,i){
																	return  {"id" : _.get(o,id) , "text": _.get(o,text)};
									})
						};
					},
					cache: true
				}
			});
	   }

	   const _confirmations = (ele) => {
		   $(document).on("click","a"+ele,function(e){			   
				// 
				$this = $(this);
				$node = $this[0].nodeName;
				$message =  ($this.hasAttr("data-message")) ? $this.data('message') : "Are you sure?";
				// 				
				if(!confirm){
					e.preventDefault();
					bootbox.confirm({ 
						message: $message,
						centerVertical:true,
						onHide: function(e) {
							confirm = false;
						} ,
						callback: function(result){ 
							if(result){
								confirm = result;
								if($node == "A")
									$this.get(0).click();
							}					
						}
					});
				}
		   });
	   }
	   
	   
	   return {
		   
		    initDynamicModal : (linkedClass = '.dynamicModal' , linkedModal = '#dynamicModal') => {
		    	_dynamicModal(linkedClass , linkedModal);
		    },
		    
		    initExtendDataTableDefaults : () => {
		    	_extendDataTableDefaults();
		    },
		    
		    initCheckElementAttribute : () => {
		    	_check_ele_attribute();
		    },
		    
		    initFvFormValidation : () => {
		    	_fv_form_validation();
		    },
		    
		    initSelectComponent : ( e = '.select2' ) => {
		    	_select_component(e);
		    },
		    
		    initCKEditor : (e = '.ck-editor') => {
		    	_ck_editor(e);
		    },
		    
		    initDatePicker : (e = '.datepicker') => {
		    	_date_picker(e);
		    },
		    
		    initSelect2Ajax : (e = '.select-ajax') => {
				_select2_ajax(e);
			},
			
			initConfirmations :(e = '.confirm-request') => {
				_confirmations(e);
			},

			initAjaxCall : (e = '.ajax-call') => {
				_ajaxCall(e);
			},
		    
	        // Initialize core
	        initCore: () => { 
	        	Custom.initCheckElementAttribute();
	        	Custom.initDynamicModal();	        		        	
	        	Custom.initFvFormValidation();
	        	Custom.initSelectComponent();
	        	Custom.initCKEditor();
	        	//Custom.initDatePicker();
	        	Custom.initExtendDataTableDefaults();
	        	Custom.initConfirmations();
	        	Custom.initSelect2Ajax();
				Custom.initAjaxCall();
	        }
	   }
}();

/**
 *
 * Initialize module 
 * When content is loaded
 *  
 **/

document.addEventListener('DOMContentLoaded', function() {	
	$.fn.modal.Constructor.prototype.enforceFocus = function() {};
	Custom.initCore();
	feather.replace()

	$('.date').datetimepicker({
		format: 'YYYY-MM-DD',
		locale: 'en'
	});
	
	$('.datetime').datetimepicker({
		format: 'YYYY-MM-DD HH:mm',
		locale: 'en',
		sideBySide: true,
		stepping: 5,
		minDate:new Date()
	});

	$(document).ajaxStart($.blockUI).ajaxStop($.unblockUI);
	$(window).bind('beforeunload',function(){		
		$.blockUI();
    });
});

/**
*
* Initialize module 
* when page is fully loaded
*  
**/

window.addEventListener('load', function() {
 //...
});