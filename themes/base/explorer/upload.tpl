<table class="forum" style="width: {page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="headb">{lang:explorer} - {lang:upload}</td>
  </tr>
  <tr>
    <td class="leftc">{lang:max_upload}</td>
  </tr>
</table>
<br />

<form method="post" name="explorer_upload2" action="{url:explorer_upload}" enctype="multipart/form-data">
<table class="forum" style="width: {page:width}" cellpadding="0" cellspacing="{page:cellspacing}">
  <tr>
    <td class="leftc" style="width: 25%">{icn:dir} {lang:directory}</td>
    <td class="leftb" style="width: 75%">{var:dir}</td>
  </tr>
  <tr>
    <td class="leftc">{icon:download} {lang:file} *</td>
    <td class="leftb"><input type="file" name="file" value="" class="form" /></td>
  </tr>
  <tr>
    <td class="leftc">{icon:kedit} {lang:f_name}</td>
    <td class="leftb"><input type="text" name="name" value="{var:name}" maxlength="40" size="25" class="form" /><br />
     {clip:info}
    </td>
  </tr>{if:accessentry}
  <tr>
    <td class="leftc">{icon:access} {lang:minaccess}</td>
    <td class="leftb">
      <select name="minaxx" class="form">
        <option value="0">0 - {lang:lev_0}</option>
        <option value="1">1 - {lang:lev_1}</option>
        <option value="2">2 - {lang:lev_2}</option>
        <option value="3">3 - {lang:lev_3}</option>
        <option value="4">4 - {lang:lev_4}</option>
        <option value="5">5 - {lang:lev_5}</option>
      </select></td>
  </tr>{stop:accessentry}
  <tr>
    <td class="leftc">{icon:ksysguard} {lang:options}</td>
    <td class="leftb">
      <input type="hidden" name="dir" value="{var:dir}" />
      <input type="submit" name="submit" value="{lang:upload}" class="form" />{if:modsdir}
      <input type="submit" name="accessadd" value="{lang:entry_in_accessfile}" class="form"/>{stop:modsdir}</td>
  </tr>
</table>
</form>
