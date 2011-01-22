$(document).ready(function(){

	//---------------------------
	// Header animation
	//---------------------------
	if ( $("#headerPanel").length ) {
		
		//Cache variables
		var headerPanel = $("#headerPanel"),
			height = headerPanel.height() - 30,
			toggler = $("#togglePanel");
			
		//Hide the header by default
		headerPanel.css({ marginTop: -height });
		toggler.addClass("closed");
		
		toggler.click(function(){
			slideHeader();
		});

		$("#header").find("a").click(function(){
			slideHeader();
			return true;
		});
		
		// Show and hide header
		function slideHeader(){
			if ( toggler.hasClass("closed") ){
				headerPanel.animate({
					marginTop: 0
				},400,"easeOutQuad");
				toggler.removeClass("closed");
			}else{
				headerPanel.animate({
					marginTop: -height
				},400,"easeOutQuad");
				toggler.addClass("closed");
			}
		}	
		
	}
	
	//---------------------------
	// Autofilling forms using placeholders
	//---------------------------
	if( !supports_placeholder() ){
		// If your browser does not support placeholders
		$("input[type=text], textarea").each(function(){
			$(this).val($(this).attr('placeholder'));
		}).focus(function(){
			if($(this).val() == $(this).attr('placeholder')) { $(this).val(""); }
		}).blur(function(){
			if($(this).val() == "") { $(this).val($(this).attr('placeholder')); }
		});
	}
	
	// Test placeholder support
	function supports_placeholder() {
		var i = document.createElement('input');
		return 'placeholder' in i;
	}

	//---------------------------
	// Ajax Form
	//---------------------------	
    
    if($("#contactForm").length){
    
		$("#contactForm").submit(function(){
		    
		    var ContactForm = $(this),
		    	errors = 0,
		        loader = $("#loader"),
		        result = $("#result");
		        
		    loader.fadeIn();
		    result.find(".fail, .success").hide();
		    
		    ContactForm.find(".required").each(function(){
		        var id = $(this).attr("id");
		        if($(this).hasClass("email")){
		            errors += $(this).validateEmail();
		        }
			if($(this).hasClass("digits")){
		            errors += $(this).validateDigits();
		        }else if($(this).attr("id") == "captcha"){
		            errors += $(this).validateCaptcha();
		        }else{
		            //Must contain at least 3 characters
		            errors += $(this).validateLength(3);
		        }
		    });
		    
		    //If there are no errors, send the email
		    if(errors === 0){
		        var data = ContactForm.serialize(),
		            URL = ContactForm.attr("action");
				$.ajax({
					type: 'post',
					url: URL,
					data: data,
					success: function(results) {
						loader.fadeOut(function() {
							if(/email sent/.test(results)) {
								result.find(".success").fadeIn();
								ContactForm.find(".form").each(function(){
								    $(this).val( $(this).attr("placeholder") );
		                        });
							} else {
								result.find(".fail").fadeIn();
							}
						});
					},
					error: function() {
						result.find(".fail").fadeIn();
					}
				});
		    }else{
		    	// else, nudge the incorrect fields
		    	ContactForm.find(".notRight").each(function(){
		    		$(this).nudge();
		    	});
		    }
		    loader.fadeOut();     
	        return false;    
	    });
	
	    //Content length validation
	    $.fn.validateLength = function(l){
	        if( this.val().length < l || this.val() == this.attr("placeholder") ) {
	        	this.addClass("notRight");
	        	return 1;
	        } else {
	            this.removeClass('error');
	            return 0;
	        }
	    };
	
		//email validation
		$.fn.validateEmail = function(){
			var filter = /^[a-zA-Z0-9]+[a-zA-Z0-9_.-]+[a-zA-Z0-9_-]+@[a-zA-Z0-9]+[a-zA-Z0-9.-]+[a-zA-Z0-9]+.[a-z]{2,4}$/;
			if(filter.test(this.val())){
				this.removeClass("error");
				return 0;
			}else{
				this.addClass("notRight");
				return 1;
			}
		}
		//digits validation
		$.fn.validateDigits = function(){
			var filter = /^[0-9]+$/;
			if(filter.test(this.val())){
				this.removeClass("error");
				return 0;
			}else{
				this.addClass("notRight");
				return 1;
			}
		}
		
	    // Captcha validation
	    $.fn.validateCaptcha = function(){
	    	var field1 = parseInt($("#captchaField1").text()),
	    		operator = ( $("#captchaField2").text() == "+" ) ? true : false;
	    		field3 = parseInt($("#captchaField3").text()),
	    		correct = operator ? field1+field3 : field1-field3;   
	        if(this.val() != correct) {
	        	this.addClass("notRight");
	        	return 1;
	        } else {
	            this.removeClass('error');
	            return 0;
	        }
	    };
		
	    // Nudge effect
		$.fn.nudge = function(){
			$(this).animate({
				'right' : -4
			}, 40, function(){
				$(this).animate({
					'right' : 4
				}, 40, function(){
					$(this).animate({
						'right' : -4
					}, 40, function(){
						$(this).animate({
							'right' : 4
						}, 40, function(){
							$(this).animate({
								'right' : -4
							}, 40, function(){
								$(this).animate({
									'right' : 0
								}, 40, function(){
									$(this).delay(80).removeClass('notRight').addClass("error");
								});
							});
						});
					});
				});
			});
		}
			
	}	


});