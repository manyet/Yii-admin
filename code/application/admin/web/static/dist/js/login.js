require(["plugins"], function () {
    var $img = $('#captchaimg'), $vcon = $('#validate-code');
    $('form').on('requestComplete', function(e, data) {
        if (data.status !== 1) {
            if (++et >= 3) {
                $vcon.show();
                $img.click();
            }
            $.msg.error(data.info);
        }else{
            $.msg.success(data.info, 1000, function(){
				data.url += location.hash;
				location.href = data.url;
			});
        }
    });
});

if(login.username.value){
	login.password.focus();
	$('#remember').prop('checked', true);
}else{
	login.username.focus();
}

$('#captchaimg').click(function(){
	var self = this;
	$.get(this.src.split('?')[0] + '?refresh=1', function(d){
		self.src = d.url;
	})
});