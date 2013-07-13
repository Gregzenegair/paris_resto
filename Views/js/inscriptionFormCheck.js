/***************************/
//@Author: Adrian "yEnS" Mato Gondelle & Ivan Guardado Castro
//@website: www.yensdesign.com
//@email: yensamg@gmail.com
//@license: Feel free to use it, but keep this credits please!					
/***************************/


$(document).ready(function(){
	//global vars
	var form = $("#mainForm");
	var pseudo = $("#pseudo");
	var pseudoMessage = $("#pseudoMessage");
	var email = $("#email");
	var emailMessage = $("#emailMessage");
	var mdp = $("#mdp");
	var mdpMessage = $("#mdpMessage");
	var mdp_check = $("#mdp_check");
	var mdp_checkMessage = $("#mdp_checkMessage");
        
        
	//On blur
	pseudo.blur(validerPseudo);
	email.blur(validerEmail);
	mdp.blur(validerMdp);
	mdp_check.blur(validerMdp_check);
	//On key press
	pseudo.keyup(validerPseudo);
	mdp.keyup(validerMdp);
	mdp_check.keyup(validerMdp_check);
	//On Submitting
	form.submit(function(){
		if(validerPseudo() & validerEmail() & validerMdp() & validerMdp_check())
			return true;
		else
			return false;
	});
	
	//validation functions
	function validerEmail(){
		//testing regular expression
		var a = $("#email").val();
		var filter = /^[a-zA-Z0-9]+[a-zA-Z0-9_.-]+[a-zA-Z0-9_-]+@[a-zA-Z0-9]+[a-zA-Z0-9.-]+[a-zA-Z0-9]+.[a-z]{2,4}$/;
		//if it's valid email
		if(filter.test(a)){
			email.removeClass("error");
			emailMessage.text("Valid E-mail please, you will need it to log in!");
			emailMessage.removeClass("error");
			return true;
		}
		//if it's NOT valid
		else{
			email.addClass("error");
			emailMessage.text("Stop cowboy! Type a valid e-mail please :P");
			emailMessage.addClass("error");
			return false;
		}
	}
	function validerPseudo(){
		//if it's NOT valid
		if(pseudo.val().length < 4){
			pseudo.addClass("error");
			pseudoMessage.text("We want pseudos with more than 3 letters!");
			pseudoMessage.addClass("error");
			return false;
		}
		//if it's valid
		else{
			pseudo.removeClass("error");
			pseudoMessage.text("What's your pseudo?");
			pseudoMessage.removeClass("error");
			return true;
		}
	}
	function validerMdp(){

		//it's NOT valid
		if(mdp.val().length <5){
			mdp.addClass("error");
			mdpMessage.text("Ey! Remember: At least 5 characters: letters, numbers and '_'");
			mdpMessage.addClass("error");
			return false;
		}
		//it's valid
		else{			
			mdp.removeClass("error");
			mdpMessage.text("At least 5 characters: letters, numbers and '_'");
			mdpMessage.removeClass("error");
			validerMdp_check();
			return true;
		}
	}
	function validerMdp_check(){
		//are NOT valid
		if( mdp.val() != mdp_check.val() ){
			mdp_check.addClass("error");
			mdp_checkMessage.text("Passwords doesn't match!");
			mdp_checkMessage.addClass("error");
			return false;
		}
		//are valid
		else{
			mdp_check.removeClass("error");
			mdp_checkMessage.text("Confirm password");
			mdp_checkMessage.removeClass("error");
			return true;
		}
	}
});