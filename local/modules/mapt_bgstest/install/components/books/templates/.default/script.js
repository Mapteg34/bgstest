$(function(){
	$("table#books_list input[type=button]").click(function(){
		var btn = $(this);
		$.ajax({
			data:{
				BOOK_ID:btn.closest("tr").data("bookid"),
				MARK:btn.val(),
				FORM_ID:"BOOKS_RATING",
				sessid:BX.bitrix_sessid()
			},
			async:true,
			cache:false,
			method:"POST",
			error:function(){
				alert("Ошибка при выполнении запроса. Обновите страницу и попробуйте снова, или обратитесь к администратору сайта");
				return false;
			},
			success:function(response){
				try {
					response = $.parseJSON(response);
				} catch(e){
					this.error();
					return false;
				}
				if (!response.state || (response.state!="success" && response.state!="error")) {
					this.error();
					return false;
				}
				
				if (response.state=="error") {
					alert(response.errorText);
					return false;
				}
				btn.closest("tr").find("td.avg").html(response.result);
				return true;
			}
		});
		return false;
	});
})