function openModal(id,vendor)  {
	var winWidth = window.innerWidth;
	var percentage = 0;
	var remainder = 0;
	var windHalf = 0;
	var divWidth = 0;

	$.get('/pages/detail.php?sku='+id+'&vendor='+vendor, function (data)  {
		divWidth = $('.overlaypage').innerWidth();
		remainder = winWidth-divWidth;
		
		windHalf = Math.floor(((remainder/winWidth)*100)/2);
		percentage = Math.floor(Math.ceil(divWidth)/Math.ceil(winWidth));
	});

	$('#overlay').css("visibility","visible");
	$('#unblockUIClose').click(function () {
		$('#overlayPageTitle').html("");
		$('#overlayPage').html("");
		$('#overlay').css("visibility","hidden");
		$.unblockUI();
	});
	$.blockUI({
		message:$('.overlay'),
		css:{
			top:'10%',
			left:'15%',
			width:'70%'
		}
	});
}

var opts = {
 	lines: 13, // The number of lines to draw
 	length: 20, // The length of each line
 	width: 10, // The line thickness
	radius: 30, // The radius of the inner circle
 	corners: 1, // Corner roundness (0..1)
 	rotate: 0, // The rotation offset
 	direction: 1, // 1: clockwise, -1: counterclockwise
 	color: '#000', // #rgb or #rrggbb or array of colors
 	speed: 1, // Rounds per second
 	trail: 60, // Afterglow percentage
 	shadow: false, // Whether to render a shadow
 	hwaccel: false, // Whether to use hardware acceleration
 	className: 'spinner', // The CSS class to assign to the spinner
	zIndex: 2e9, // The z-index (defaults to 2000000000)	
 	top: '50%', // Top position relative to parent
 	left: '50%' // Left position relative to parent
};


function checkPhone(phone)  {
	var newNo = phone.replace(/\D/g,"");
	if (newNo.length == 10)  {
		return newNo;
	}  else  {
		return "";
	}
}
function validateEmail(email) { 
	var re = /[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/;
    	return re.test(email);
} 
function validateCC(cc)  {
	var visaRE = /^4[0-9]{6,}$/;
	var mastercardRE = /^5[1-5][0-9]{5,}$/;
	var americanexpressRE = /^3[47][0-9]{5,}$/;
	var discoverRE = /^6(?:011|5[0-9]{2})[0-9]{3,}$/;
	cc = cc.replace(/[\s\-]/g,"");

	if (visaRE.test(cc))  {
		return visaRE.test(cc);
	}
	if (mastercardRE.test(cc))  {
		return mastercardRE.test(cc);
	}
	if (americanexpressRE.test(cc))  {
		return americanexpressRE.test(cc);
	}
	if (discoverRE.test(cc))  {
		return discoverRE.test(cc);
	}
	return 1;
}

function validateCheckout(user,page)  {
	var secRE = /^\d{3}$/;
	var target = document.getElementById('loader');
 	var errors = {};

 	var addr = $('#custaddr').val();
 	var city = $('#custcity').val();
 	var state = $('#custstate').val();
 	var zip = $('#custzip').val();
 	var email = $('#custemail').val();
 	var phone = $('#custphone').val();

 	var cc = "";
	var ccExp = "";
	ccExp = ccExp.replace(/\D/g,"");
	var ccSec = "";
	var ccName = "";
	var ccBill = "";
	var ccCity = "";
	var ccState = "";
	var ccZip = "";
	var terms = $('#terms').is(':checked');
	var isChecked = $('#onfile').is(':checked');
 	var uname = "";
 	var pass = "";

	if (!isChecked)  {
 		cc = $('#custCC').val();
		ccExp = $('#ccExp').val();
		ccSec = $('#ccSec').val();
		ccName = $('#ccName').val();
		ccBill = $('#ccBill').val();
		ccCity = $('#ccCity').val();
		ccState = $('#ccState').val();
		ccZip = $('#ccZip').val();
	}

 	phone = checkPhone(phone);
 	if (phone == "")  {
 		errors['phone'] = "Please enter a 10 digit phone number";
 	}
 	if (!validateEmail(email))  {
 		errors['email'] = "Please enter a valid email";
 	}
 	if (state == "Choose")  {
 		errors['state'] = "Please select your state or not listed";
 	}
 	if (addr == "" || city == "" || zip == "")  {
 		errors['blank'] = "Please enter an address, city, and zip";
 	}
	if (!isChecked && !terms)  {
 		if (!validateCC(cc) && cc.length == 0)  {
 			errors['cc'] = "Please provide a valid credit card number";
 		}
		if (ccSec.length != 3 && !secRE.test(ccSec))  {
			errors['ccSec'] = "Improper format for security code. 3 digits on back of card";
		}
		if (ccExp.length != 4)  {
			errors['ccExp'] = "Your expiration date value is incorrect. Use mmyy";
		}
		if (ccName == "")  {
			errors['ccName'] = "Please fill in cardholders name";
		}
		if (ccBill == "")  {
			errors['ccBill'] = "Please fill in billing address";
		}
		if (ccCity == "")  {
			errors['ccCity'] = "Please fill in billing city";
		}
		if (ccState == "Choose")  {
			errors['ccState'] = "Please select your credit card billing address state.";
		}
		if (ccZip == "" && ccZip.length < 5)  {
			errors['ccZip'] = "Please fill in billing zipcode";
		}
	}
	if (!isChecked && !terms && cc == "")  {
		errors['fillout'] = "\n\nYou must check you have terms with Troy\n";
		errors['fillout'] += "or your credit card is on file\n";
		errors['fillout'] += "or provide us with valid credit card information.";
	}
 	if (Object.keys(errors).length == 0)  {
 		var spinner = new Spinner(opts).spin(target);
 		$.ajax({
 			type:"POST",
 			url:"/pages/"+page,
 			data: { addr:""+addr,city:""+city,state:""+state,zip:""+zip,email:""+email,phone:""+phone,user:""+user,uname:""+uname,pass:""+pass,cc:""+cc,ccExp:""+ccExp,ccSec:""+ccSec,ccName:""+ccName,ccBill:""+ccBill,ccCity:""+ccCity,ccState:""+ccState,ccZip:""+ccZip,terms:""+terms,onfile:""+isChecked  },
 			datatype: 'text',
 			success:function (data)  {
 				spinner.stop();
 				$('#custaddr').attr('disabled','disabled');
 				$('#custcity').attr('disabled','disabled');
 				$('#custstate').attr('disabled','disabled');
 				$('#custzip').attr('disabled','disabled');
 				$('#custemail').attr('disabled','disabled');
 				$('#custphone').attr('disabled','disabled');
 				$('#set').val("set");

				if (page == "checkout.php")  {
					msg = "Thank you for your order. ";
					msg += "You are being redirected to our homepage.";
					alert(msg);
					window.location = "http://www.troy-corp.com/";
				}
 			},
 			error: function(jqXHR, textStatus, errorThrown){
 				spinner.stop();
 				alert(textStatus, errorThrown);
 			}
 		});
	}
	return errors;
}

function validateGoForm()  {
	var name = $('#cName').val();
	var pass = $('#pass').val();
	var company = $('#company').val();
	var address = $('#address').val();
	var city = $('#city').val();
	var state = $('.state').val();
	var zip = $('#zCode').val();
	var phone = $('#phone').val();
	var email = $('#email').val();

	var errors = {};
	if (!validateEmail(email))  {
		errors['email'] = "You need to enter a valid email";
	}
	if (pass.length < 7)  {
		errors['password'] = "Passowrds must be 8 or more characters";
	}
	if (!checkPhone(phone))  {
		errors['phone'] = "Please enter a valid phone number";
	}
	if (name == "" || company == "")  {
		errors['names'] = "Please enter a company name and/or your name";
	}
	if (address == "" || city == "")  {
		errors['location'] = "Please enter an address and/or city";
	}
	if (zip == "" || zip.length != 5)  {
		errors['zip'] = "Please enter a zip code";
	}
	var isChecked = "";
	$('input:checked').each(function ()  {
		if ($(this).prop('checked') == true)  {
			isChecked = $(this).attr("id");
		}
	});
	if (isChecked == "")  {
		errors['types'] = "You have to check off at least one type of fabric to enroll";
	}

	if (Object.keys(errors).length != 0)  {
		var message = "";
		for (var error in errors)  {
			message += errors[error]+"\n";
		}
		alert(message);
		return false;
	}
}

function login(uname,pass,id)  {
	method = "POST";
	var form = document.createElement("form");
	form.setAttribute("method",method);
	form.setAttribute("action","pages/login.php");

	var hiddenField = document.createElement("input");
	hiddenField.setAttribute("type", "hidden");
	hiddenField.setAttribute("name", "uname");
	hiddenField.setAttribute("value", ""+uname);
	form.appendChild(hiddenField);

	var hiddenField = document.createElement("input");
	hiddenField.setAttribute("type", "hidden");
	hiddenField.setAttribute("name", "pass");
	hiddenField.setAttribute("value", ""+pass);
	form.appendChild(hiddenField);

	var hiddenField = document.createElement("input");
	hiddenField.setAttribute("type", "hidden");
	hiddenField.setAttribute("name", "id");
	hiddenField.setAttribute("value", ""+id);
	form.appendChild(hiddenField);

	$(document.body).append(form);
	form.submit();
}

function register()  {
	var user = $('#id').val();
	var uname = $('#uname').val();
	var pass = $('#password').val();
	var againpass = $('#againpassword').val();
	var email = $('#custemail').val();
	var againemail = $('#againcustemail').val();
	var matches = pass.match(/\s/gi);
	var addr = "";
	var city = "";
	var state = "";
	var zip = "";
	var phone = "";

	var errors = {};
	if (!validateEmail(email))  {
		errors['email'] = "Please enter a valid email";
	}
	if (uname == "")  {
		errors['uname'] = "Please enter a username";
	}
	if (pass.length < 8)  {
		errors['pass'] = "Please enter a password at least 8 characters ";
	}
	if (matches)  {
		errors['blank'] = "A password cannot contain spaces";
	}
	if (email != againemail)  {
		errors['emailmatch'] = "You have to enter the same email address";
	}
	if (pass != againpass)  {
		errors['passmatch'] = "Your passwords have to match";
	}

	if (Object.keys(errors).length == 0)  {
		$.ajax({
			type:"POST",
                	url:"pages/customerUpdate.php",
                	data: { addr:""+addr,city:""+city,state:""+state,zip:""+zip,email:""+email,phone:""+phone,user:""+user,uname:""+uname,pass:""+pass },
			datatype: 'text',
			success:function(data)  {
				login(uname,pass,user);
			},
			error: function(jqXHR, textStatus, errorThrown){
				alert(textStatus, errorThrown);
			}
		});
	}  else  {
		var message = "";
		for (var error in errors)  {
			message += errors[error]+"\n";
		}
		alert(message);
	}
}

function checkLogin()  {
	var id = $('#loginID').val();
	var pass = $('#loginPass').val();

	if (id.length != 4 || id.length != 10)  {
		return validateEmail(id);
	}
	return false;
}

function getPage(file)  {
	$.ajax({
		type:"POST",
		url:"pages/"+file+".php",
		success:function (data)  {
			if (file == 'logout')  {
				window.location.href = "http://www.troy-corp.com/";
			}
		}
	});
}

$(document).ready(function ()  {
	var checked = 0;
	$(function() {
		$("#viewcart").click(function(event)  {
			$('#centerFrame').html("");
			getPage("cart");
		});
		$("#logout").click(function(event)  {
			getPage("logout");
		});
		$("#register").click(function(event)  {
			register();
		});
	});

	$(function() {
 		$( "#dialog" ).dialog({
 			autoOpen: false
 		});
		$("#signin").click(function(evnt) {
 			$( "#dialog" ).dialog( "open" );
 		});
		$("#goSelectAll").click(function(event)  {
			if (checked == 0)  {
				$('.goCheck').prop('checked',true);
				$(this).text("Unselect all categories");
			}  else  {
				$('.goCheck').prop('checked',false);
				$(this).text("Select all categories");
			}
			if (checked == 0)  {  checked = 1;  }  else  {  checked = 0;  }
		});
 	});

	$("#slideshow > div:gt(0)").hide();
	setInterval(function() { 
 		$('#slideshow > div:first')
 			.fadeOut(1000)
 			.next()
 			.fadeIn(1000)
 			.end()
 			.appendTo('#slideshow');
	},  10000);
	$("#slideshow2 > div:gt(0)").hide();
	setInterval(function() { 
 		$('#slideshow2 > div:first')
 			.fadeOut(1000)
 			.next()
 			.fadeIn(1000)
 			.end()
 			.appendTo('#slideshow2');
	},  10000);
});
