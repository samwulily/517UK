<script type="text/javascript">
function changeyanzhengma()
{
	alert("�ı���֤��");
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
		if (validate_required(coordinator,"��ϵ�˱�����д��")==false)
			{coordinator.focus();return false}
		if (validate_required(phoneNumber,"��ϵ�绰������д��")==false)
			{phoneNumber.focus();return false}
		if (validate_required(email,"���ʵ�ַ������д��")==false)
			{email.focus();return false}
		if (validate_required(message,"���Ա�����д��")==false)
			{message.focus();return false}
	  }
	alert("��л������ѯ�����ǵ�ר�һ�ܿ������ϵ��");
}
</script>
</script>
