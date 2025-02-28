function submitfrm(action, proc, cmd)
{

    var frms = document.mainfrm;
    frms.action = action;
    frms.target = "_self";  //add
    frms.prc.value = proc;
    frms.cmd.value = cmd;
    frms.submit();
    submitfrm = blockIt;
    return false;
}

function submitfrm_conf(action, proc, cmd, str)
{
    if (!confirm(str)) {
        return;
    }
    submitfrm(action, proc, cmd);
}

function selectfrm(action, proc, cmd, sid)
{
    var frms = document.mainfrm;
    frms.sid.value = sid;
    submitfrm(action, proc, cmd);
}

function selectfrm_conf(action, proc, cmd, sid, str)
{
    if (!confirm(str)) {
        return;
    }
    selectfrm(action, proc, cmd, sid);
}

function submitfrmWithEnter(action, proc, cmd, e)
{
   var keycode;
   if (window.event) {
      keycode = window.event.keyCode;
   } else if (e) {
      keycode = e.which;
   } else {
      return;
   }
   if (keycode == 13) {
      submitfrm(action, proc, cmd);
   } else {
      return;
   }
}

function submitfrmNofalse(action, proc, cmd)
{

    var frms = document.mainfrm;
    frms.action = action;
    frms.target = "_self";  //add
    frms.prc.value = proc;
    frms.cmd.value = cmd;
    frms.submit();
    return false;
}

function selectfrmNofalse(action, proc, cmd, sid)
{
    var frms = document.mainfrm;
    frms.sid.value = sid;
    submitfrmNofalse(action, proc, cmd);
}

function pagefrm(action, proc, cmd, pno)
{
    var frms = document.mainfrm;
    frms.pno.value = pno;
    submitfrm(action, proc, cmd);
}

function pagefrm_ex(action, proc, cmd, pno)
{
    var frms = document.mainfrm;
    frms.pno_ex.value = pno;
    submitfrm(action, proc, cmd);
}

function submitFormEx(action, proc, cmd)
{
    var frms = document.forms[0];
    frms.action = action;
    frms.prc.value = proc;
    frms.cmd.value = cmd;
    frms.submit();
    submitFormEx = blockIt;
    return false;
}

function submitfrmMulti(action, proc, cmd)
{
    var frms = document.mainfrm;
    frms.action = action;
    frms.target = "_self";  //add
    frms.prc.value = proc;
    frms.cmd.value = cmd;
    frms.encoding = 'multipart/form-data';
    frms.submit();
    submitfrm = blockIt;
    return false;
}

function selectfrmMulti(action, proc, cmd, sid)
{
    var frms = document.mainfrm;
    frms.action = action;
    frms.target = "_self";  //add
    frms.prc.value = proc;
    frms.cmd.value = cmd;
    frms.sid.value = sid;
    frms.encoding = 'multipart/form-data';
    frms.submit();
    selectfrmMulti = blockIt;
    return false;
}

function submitfrmBlank(action, proc, cmd)
{

    var frms = document.mainfrm;
    frms.action = action;
    frms.target = "_blank";  //add
    frms.prc.value = proc;
    frms.cmd.value = cmd;
    frms.submit();
    return false;
}

function submitfrm_search_api(action)
{
    var frms = document.mainfrm;
    frms.action = action;
    frms.method = "get";
    frms.target = "_blank";  //add
    frms.q.value = frms.f_keyword.value;
    frms.submit();
}

function blockIt()
{
    return false;
}

function form_reset()
{
    var frms = document.mainfrm;
    frms.reset();
}

function submitFormPopupWindow (action, proc, cmd, id) {
    var subwin = "popupwin";
    window.open('about:blank', subwin, 'width=700,height=850,status=no,scrollbars=yes,directories=no, menubar=no, resizable=yes, toolbar=no');

    // submit
    var frms = document.mainfrm;
    frms.action = action;
    frms.target = subwin;
    frms.prc.value = proc;
    frms.cmd.value = cmd;
    frms.sid.value = id;
    frms.submit();
}

function submitFormPopupWindowSizeFree (action, proc, cmd, id, w, h) {
    var subwin = "popupwin";
    window.open('about:blank', subwin, 'width='+w+',height='+h+',status=no,scrollbars=yes,directories=no, menubar=no, resizable=yes, toolbar=no');

    // submit
    var frms = document.mainfrm;
    frms.action = action;
    frms.target = subwin;
    frms.prc.value = proc;
    frms.cmd.value = cmd;
    frms.sid.value = id;
    frms.submit();
}

function submitfrm_opener(action, prc, cmd)
{
    var frms = window.opener.document.mainfrm;

    frms.action = action;
    frms.target = "_self";  //add
    frms.prc.value = prc;
    frms.cmd.value = cmd;
    frms.submit();
    window.close();
}