<?php /* Smarty version 2.6.17, created on 
         compiled from file:C:%5Cxampp%5Chtdocs%5Csimplan%5Cpublic_app%5Chtml%5Cadmin_error.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['common']['head_tpl']), 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<!--rightmenu-->
<div id="rightm">
  <h2><?php echo $this->_tpl_vars['param']['content']; ?>
 error</h2>
  <p></p>
  <ul id="main">
    <li><font color="#CC0000"><?php echo $this->_tpl_vars['param']['message']; ?>
</font></li>
  </ul>
  <div id="pt">
    <input type="button" name="confirm" value="<?php echo $this->_tpl_vars['param']['name']; ?>
back to >>" class="formbtn_l"  onclick="return submitfrm('<?php echo $this->_tpl_vars['param']['url']; ?>
','<?php echo $this->_tpl_vars['param']['process']; ?>
','<?php echo $this->_tpl_vars['param']['cmd']; ?>
')"/>
  </div>
  <div class="blankheight300"></div>
</div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['common']['foot_tpl']), 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>