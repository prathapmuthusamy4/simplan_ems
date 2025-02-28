{literal}
<script type="text/javascript">
$(function(){
  $('input[type=text],input[type=password],textarea').focus(function(){
    $(this).addClass('focus');
  }).blur(function(){
    $(this).removeClass('focus');
  });
});
</script>
{/literal}
