<?php /* Smarty version 2.6.17, created on 
         compiled from file:C:%5Cxampp%5Chtdocs%5Csimplan%5Cpublic_app%5Chtml%5Cadmin_foot.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'file:C:\\xampp\\htdocs\\simplan\\public_app\\html\\admin_foot.tpl', 7, false),array('modifier', 'escape', 'file:C:\\xampp\\htdocs\\simplan\\public_app\\html\\admin_foot.tpl', 7, false),)), $this); ?>
    <!--maindefault end-->
    </div>
    <!--css reset-->
    <div id="cc"></div>
    <!--footer-->
    <div id="footer">
      <p>Copyrights &copy; <?php echo ((is_array($_tmp=time())) ? $this->_run_mod_handler('date_format', true, $_tmp, '%Y') : smarty_modifier_date_format($_tmp, '%Y')); ?>
 <?php echo ((is_array($_tmp=$this->_tpl_vars['common']['name_en'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
. All Right Reserved</p>
      <p><?php echo ((is_array($_tmp=$this->_tpl_vars['common']['system_name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
&nbsp;Version&nbsp;<?php echo ((is_array($_tmp=$this->_tpl_vars['common']['system_version'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</p>
      <p><?php echo $this->_tpl_vars['common']['simplan_logo']; ?>
</p>
    </div>
    <!--default end-->
  </div>
  <input type="hidden" id="onetime_ticket" name="onetime_ticket" value="<?php echo $this->_tpl_vars['onetime_ticket']; ?>
" />
</form>
</body>
</html>