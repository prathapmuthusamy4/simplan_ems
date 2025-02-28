    <!--maindefault end-->
    </div>
    <!--css reset-->
    <div id="cc"></div>
    <!--footer-->
    <div id="footer">
      <p>Copyrights &copy; {$smarty.now|date_format:'%Y'} {$common.name_en|escape}. All Right Reserved</p>
      <p>{$common.system_name|escape}&nbsp;Version&nbsp;{$common.system_version|escape}</p>
      <p>{$common.simplan_logo}</p>
    </div>
    <!--default end-->
  </div>
  <input type="hidden" id="onetime_ticket" name="onetime_ticket" value="{$onetime_ticket}" />
</form>
</body>
</html>