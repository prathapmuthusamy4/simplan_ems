<?php /* Smarty version 2.6.17, created on 2019-11-13 17:14:09
         compiled from /home/m-ela/projects/sample/public_app/html/mail/user_mail_arrach.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', '/home/m-ela/projects/sample/public_app/html/mail/user_mail_arrach.tpl', 16, false),)), $this); ?>
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
┏━━┓  || <?php echo $this->_tpl_vars['common']['name_en']; ?>
 ||
┃＼／┃ エントリー受付メール
┗━━┛  <?php echo $this->_tpl_vars['common']['url']; ?>

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
---------------------------------------------------------------------
このメールは<?php echo $this->_tpl_vars['common']['name_en']; ?>
より自動送信でお届けしたものです。
心当たりのない方は、恐れ入りますがその旨をご記入いただき、
このメールに返信していただけますようお願いいたします。
---------------------------------------------------------------------

 ┏━━━━━━━━━━━━━━━━━━━━━━━━━━━┓
   <?php echo $this->_tpl_vars['param']['f_mtitle']; ?>
のエントリーを受付ました。
 ┗━━━━━━━━━━━━━━━━━━━━━━━━━━━┛

<?php echo ((is_array($_tmp=$this->_tpl_vars['param']['f_name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
　様
この度は【<?php echo $this->_tpl_vars['common']['name_en']; ?>
】をご利用いただきありがとうございます。
以下のイベントに関してエントリーを受け付けました。
参加の可否に関してはメールにてご連絡します。

---------------------------------------------------------------------
<?php echo $this->_tpl_vars['param']['f_mtitle']; ?>

---------------------------------------------------------------------

<?php echo ((is_array($_tmp=$this->_tpl_vars['param']['f_content'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>



---------------------------------------------------------------------

【<?php echo $this->_tpl_vars['common']['name_en']; ?>
】を今後ともよろしくお願いいたします。

マザープラスでは会員の皆さまの活躍の場を広げるお仕事紹介も行っています。
既に活躍されている方もスキル記入でスカウトのチャンスもあるかも!?
スキル記入は「マイページ・メンバー情報変更」より♪


━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
:: <?php echo $this->_tpl_vars['common']['name']; ?>
 :: 　<?php echo $this->_tpl_vars['common']['url']; ?>

　　<?php echo $this->_tpl_vars['common']['address1']; ?>
　<?php echo $this->_tpl_vars['common']['address2']; ?>


＜お問合せ窓口＞
　担当： <?php echo $this->_tpl_vars['common']['contact_belongto']; ?>
 <?php echo $this->_tpl_vars['common']['contact_name']; ?>

　E-mail: <?php echo $this->_tpl_vars['common']['mail']; ?>

　Tel   : <?php echo $this->_tpl_vars['common']['tel']; ?>

　Fax   : <?php echo $this->_tpl_vars['common']['fax']; ?>

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━