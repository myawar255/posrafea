$(function(){

	CustomValidation = {
		init: function() {
			/* START OF PASSWORD SHOW BTN */
			$(".custom-input-attachment .password-show-icon").on("click",function(){
				if(!$(this).hasClass("off")){
					$(this).addClass("off");
					$(this).find(".mdi").removeClass("mdi-eye");
					$(this).find(".mdi").addClass("mdi-eye-off");

					var password = $(this).closest(".form-group").find("input[type=password]");
					$(password).attr("type","text");
				} else {
					$(this).removeClass("off");
					$(this).find(".mdi").removeClass("mdi-eye-off");
					$(this).find(".mdi").addClass("mdi-eye");

					var password = $(this).closest(".form-group").find("input[type=text]");
					$(password).attr("type","password");
				}
			});
			/* END OF PASSWORD SHOW BTN */
		}
	}

	CustomValidation.init();
});
