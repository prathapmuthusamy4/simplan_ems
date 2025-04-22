<?php /* Smarty version 2.6.17, created on 
         compiled from list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'list.tpl', 19, false),array('modifier', 'admin_err', 'list.tpl', 29, false),array('modifier', 'date_format', 'list.tpl', 93, false),array('function', 'select_option', 'list.tpl', 44, false),array('function', 'html_checkboxes', 'list.tpl', 52, false),array('function', 'admin_page_navi', 'list.tpl', 70, false),array('function', 'cycle', 'list.tpl', 83, false),array('function', 'imageLink', 'list.tpl', 86, false),array('function', 'admin_page_feed', 'list.tpl', 116, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['common']['head_tpl']), 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<?php echo '
<style type="text/css">
   .blink {
            animation: blinker 3.5s linear infinite;
            color: red;
            font-family: sans-serif;
        }
        @keyframes blinker {
            50% {
                opacity: 0;
            }
        }
</style>
'; ?>

<!--rightmenu-->
<div id="rightm">
  <h2><?php echo ((is_array($_tmp=$this->_tpl_vars['param']['title'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
/Search/List</h2>
  <p></p>
  <ul id="main">
    <li>
      <h3>&nbsp;SEARCH</h3>
      <table width="980"  border="0" cellpadding="0" cellspacing="1" bgcolor="#cccccc">
        <tr valign="top" bgcolor="#FFFFFF" height="25">
          <td width="20%" valign="middle"><h4>Employee Id</h4></td>
          <td width="80%" valign="middle" bgcolor="#F5F5F5">
            <input name="f_emp_id" type="text" class="formstb_m" value="<?php echo $this->_tpl_vars['param']['f_emp_id']; ?>
" />
              <?php echo ((is_array($_tmp=$this->_tpl_vars['param']['errmsg']['f_emp_id'])) ? $this->_run_mod_handler('admin_err', true, $_tmp) : smarty_modifier_admin_err($_tmp)); ?>

            </td>
        </tr>
        <tr valign="top" bgcolor="#FFFFFF" height="25">
          <td width="20%" valign="middle"><h4>Name</h4></td>
          <td width="80%" valign="middle" bgcolor="#F5F5F5">
            <input name="f_name" type="text" class="formstb_m" value="<?php echo $this->_tpl_vars['param']['f_name']; ?>
" />
              <?php echo ((is_array($_tmp=$this->_tpl_vars['param']['errmsg']['f_name'])) ? $this->_run_mod_handler('admin_err', true, $_tmp) : smarty_modifier_admin_err($_tmp)); ?>

          </td>
        </tr>
        <tr valign="top" bgcolor="#FFFFFF" height="25">
          <td width="20%" valign="middle"><h4>Status</h4></td>
          <td width="80%" valign="middle" bgcolor="#F5F5F5" class="formstd_c">
            <select name="f_emp_status">
                <option value="">All</option>
                <?php echo smarty_function_select_option(array('list' => $this->_tpl_vars['param']['disp_emp_status'],'value' => $this->_tpl_vars['param']['f_emp_status']), $this);?>

            </select>
            <?php echo ((is_array($_tmp=$this->_tpl_vars['param']['errmsg']['f_emp_status'])) ? $this->_run_mod_handler('admin_err', true, $_tmp) : smarty_modifier_admin_err($_tmp)); ?>

          </td>
        </tr>
        <tr valign="top" bgcolor="#FFFFFF" height="25">
          <td width="20%" valign="middle"><h4>Language</h4></td>
          <td width="80%" valign="middle" bgcolor="#F5F5F5">
            <?php echo smarty_function_html_checkboxes(array('name' => 'f_language','options' => $this->_tpl_vars['param']['disp_language'],'selected' => $this->_tpl_vars['param']['f_language'],'separator' => '&nbsp;'), $this);?>

            <?php echo ((is_array($_tmp=$this->_tpl_vars['param']['errmsg']['f_language'])) ? $this->_run_mod_handler('admin_err', true, $_tmp) : smarty_modifier_admin_err($_tmp)); ?>

          </td>
        </tr>
      </table>
      <div id="pt">
        <input type="button" class="formbtn" onClick="return submitfrm('addemployee.php', 'list', 'search');" value="search"/>
      </div>
    </li>
    <li>
      <?php $_from = $this->_tpl_vars['param']['f_language']; if (($_from instanceof StdClass) || (!is_array($_from) && !is_object($_from))) { settype($_from, 'array'); }$this->_foreach['current'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['current']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['cur']):
        $this->_foreach['current']['iteration']++;
?>
        <?php if (! ($this->_foreach['current']['iteration'] <= 1)): ?>
          <h3>nandha</h3>
        <?php else: ?>
          <h3>nandhakumar</h3>
        <?php endif; ?>
      <?php endforeach; endif; unset($_from); ?>
      <h3>&nbsp;LIST</h3>
      <p><?php echo smarty_function_admin_page_navi(array('info' => $this->_tpl_vars['param']['page_info']), $this);?>
</p>
      <table width="980"  border="0" cellpadding="0" cellspacing="1" bgcolor="#cccccc">
        <tr align="center" valign="top" bgcolor="#F5F5F5" height="30">
          <td width="10%" valign="middle" class="tfextra">Profile Photo</td>
          <td width="10%" valign="middle" class="tfextra">Employee ID</td>
          <td width="15%" valign="middle" class="tfextra">Name</td>
          <td width="10%" valign="middle" class="tfextra">Date Of Birth</td>
          <td width="15%" valign="middle" class="tfextra">Aadhar Number</td>
          <td width="15%" valign="middle" class="tfextra">Passport Number</td>
          <td width="10%" valign="middle" class="tfextra">Mobile Number</td>
          <td width="15%" valign="middle" class="tfextra">Operation</td>
        </tr>
        <?php $_from = $this->_tpl_vars['param']['list']; if (($_from instanceof StdClass) || (!is_array($_from) && !is_object($_from))) { settype($_from, 'array'); }$this->_foreach['current'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['current']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['cur']):
        $this->_foreach['current']['iteration']++;
?>
        <tr valign="top" bgcolor="<?php echo smarty_function_cycle(array('values' => "#FFFFFF,#FAFAD2"), $this);?>
" height="30">
          <td align="center" valign="middle" class="tfextrb">
            <?php if (is_file ( "../".($this->_tpl_vars['param']['url_img']).($this->_tpl_vars['cur']['f_image']) )): ?>
              <?php echo smarty_function_imageLink(array('image' => "../".($this->_tpl_vars['param']['url_img']).($this->_tpl_vars['cur']['f_image']),'width' => '70','height' => '70'), $this);?>

            <?php endif; ?>
          </td>
          <td align="center" valign="middle" class="tfextrb"><?php echo ((is_array($_tmp=$this->_tpl_vars['cur']['f_emp_id'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
          <td align="left" valign="middle" class="tfextrb"><?php echo $this->_tpl_vars['cur']['f_name']; ?>
</td>
          <td align="left" valign="middle" class="tfextrb">
            <?php echo $this->_tpl_vars['cur']['f_date_of_birth']; ?>

            <?php if (( ((is_array($_tmp=$this->_tpl_vars['cur']['f_date_of_birth'])) ? $this->_run_mod_handler('date_format', true, $_tmp, '%m/%d') : smarty_modifier_date_format($_tmp, '%m/%d')) ) == ( ((is_array($_tmp=time())) ? $this->_run_mod_handler('date_format', true, $_tmp, '%m/%d') : smarty_modifier_date_format($_tmp, '%m/%d')) )): ?>
              <i style = "color:red;"class="fa fa-birthday-cake"></i>
            <?php endif; ?>
          </td>
          <td align="center" valign="middle" class="tfextrb"><?php echo ((is_array($_tmp=$this->_tpl_vars['cur']['f_aadhar_number'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
          <?php if ($this->_tpl_vars['cur']['f_passport_alert'] > 0): ?>
            <td align="center" style="color:red" valign="middle" class="blink"><?php echo ((is_array($_tmp=$this->_tpl_vars['cur']['f_passport'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
<br><?php echo $this->_tpl_vars['cur']['f_expiry_date']; ?>
</td>
          <?php else: ?>
            <td align="center" valign="middle" class="tfextrb"><?php echo ((is_array($_tmp=$this->_tpl_vars['cur']['f_passport'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
<br><?php echo $this->_tpl_vars['cur']['f_expiry_date']; ?>
</td>
          <?php endif; ?>
          <td align="center" valign="middle" class="tfextrb"><?php echo ((is_array($_tmp=$this->_tpl_vars['cur']['f_mobile_number'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
          <td align="center" valign="middle" class="tfextrb">
            <input type="button" class="formstc" onClick="return selectfrm('addemployee.php', 'edit', '', '<?php echo ((is_array($_tmp=$this->_tpl_vars['cur']['f_employee_id'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
');" value="Edit" />
            <input type="button" class="formstc" onClick="return selectfrm('addemployee.php', 'detail',  'confirm', '<?php echo ((is_array($_tmp=$this->_tpl_vars['cur']['f_employee_id'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
');" value="Detail" />
            <input type="button" class="formstc_red" onClick="return selectfrm('addemployee.php', 'del',  'confirm', '<?php echo ((is_array($_tmp=$this->_tpl_vars['cur']['f_employee_id'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
');" value="Delete" />
          </td>
        </tr>
        <?php endforeach; else: ?>
        <tr bgcolor="#FFFFFF" height="30">
          <td align="center" colspan="8" class="tfextrb" ><?php echo ((is_array($_tmp=$this->_tpl_vars['param']['none'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
        </tr>
        <?php endif; unset($_from); ?>
      </table>
      <p><?php echo smarty_function_admin_page_feed(array('info' => $this->_tpl_vars['param']['page_info'],'process' => 'list'), $this);?>
</p>
      <div id="pt">
        <input type="button" class="formbtn" onClick="return submitfrmNofalse('addemployee.php', 'list', 'excel');" value="ExcelDownload" />
        <input type="button" class="formbtn" onClick="return submitfrm('addemployee.php', 'new', '');" value="New Regist" />
      </div>
    </li>
  </ul>
  <div id="pt">
    <a href="#top">▲Go back to the top of this page</a>
  </div>
</div>
<!--/rightmenu-->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['common']['foot_tpl']), 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>