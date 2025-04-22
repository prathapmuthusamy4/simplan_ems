{literal}
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script type="text/javascript">
     $(document).ready(function() {
     	ChangeOption()
        $('input[name="f_option"]').click(function(){
        	ChangeOption();
		});
        $("#device").change(function(){
        	var content = $("#device").val()
            AjaxData(content);
        });
       if ($("#device").val()) {
            var content = $("#device").val()
            AjaxData(content);
        }
        $('input[name="f_devicechk"]').click(function(){
        	var content = $('input[name="f_devicechk"]:checked').val();
        	AjaxData(content);
		});
        function AjaxData(content){
            $.getJSON('ajax.php', {'prc': 'device','device_name': content},function(data){
                $.each(data, function(i, field){
                    $("#devicename").text(data['f_name']);
                    $("#deviceprice").text(data['f_price']);
                    $("#devicesize").text(data['f_size']);
                    $("#devicecolour").text(data['f_color']);
                    $("#f_device").val(data['f_name']);
                    $("#f_device_price").val(data['f_price']);
                    $("#f_device_size").val(data['f_size']);
                    $("#f_device_color").val(data['f_color']);
                });
            });
        }
         function ChangeOption(){
           var op_val = $('input[name="f_option"]:checked').val();
        	 if (op_val == 1) {
        	 	 $("#s1").show();
        	 	 $("#s2").hide();
        	 } else if (op_val == 2) {
               $("#s1").hide();
               $("#s2").show();
        	 }
        }
    });
</script>
{/literal}

<h3>>>>&nbsp;{$param.title|escape}情報</h3>
<table width="980"  border="0" cellpadding="0" cellspacing="1" bgcolor="#cccccc">
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Name</span><span class="must">※</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            <input name="f_name" type="text" class="formstb_m" value="{$param.f_name}" />
            <span class="disclaimer">*</span>
            {$param.errmsg.f_name|admin_err}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Option</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            {radio_option list=$param.disp_option name="f_option" value=$param.f_option|escape}
        </td>
    </tr>
    <tr valign="top" id = "s1" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Device</span><span class="must">※</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            <select name="f_device" id="device">
                <option value="">----</option>
                {select_option list=$param.disp_device value=$param.f_device}
           </select>
        </td>
    </tr>
    <tr valign="top" id = "s2" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Device</span><span class="must">※</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            {radio_option list=$param.disp_device name="f_devicechk" value=$param.f_device|escape}
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Device Name</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            <span id="devicename"></span>
            <input name="f_device" id = "f_device" type="hidden" value="{$param.f_device}" />
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Device Price</span></td>
        <td width="80%" valign="middle" class="tdcls2">
             <span id="deviceprice"></span>
             <input name="f_device_price" id = "f_device_price" type="hidden" value="{$param.f_device_price}" />
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Device Size</span></td>
        <td width="80%" valign="middle" class="tdcls2">
            <span id="devicesize"></span>
            <input name="f_device_size" id = "f_device_size" type="hidden" value="{$param.f_device_size}" />
        </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
        <td width="20%" valign="middle" class="tdcls1"><span class="cap1">Device color</span></td>
        <td width="80%" valign="middle" class="tdcls2">
             <span id="devicecolour"></span>
             <input name="f_device_color" id = "f_device_color" type="hidden" value="{$param.f_device_color}" />
        </td>
    </tr>
</table>