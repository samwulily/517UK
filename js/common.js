<script type="text/javascript">
function changeyanzhengma()
{
	alert("改变验证码");
}

function validate_required(field,alerttxt)
{
	with (field)
	{
		if (value==null||value==""){
			alert(alerttxt);return false
		}else {
			return true
		}
	}
}

function validate_form(thisform)
{
	with (thisform)
	  {
		if (validate_required(coordinator,"联系人必须填写！")==false)
			{coordinator.focus();return false}
		if (validate_required(phoneNumber,"联系电话必须填写！")==false)
			{phoneNumber.focus();return false}
		if (validate_required(email,"电邮地址必须填写！")==false)
			{email.focus();return false}
		if (validate_required(message,"留言必须填写！")==false)
			{message.focus();return false}
	  }
	alert("感谢您的咨询，我们的专家会很快和您联系！");
}
</script>
</script>
