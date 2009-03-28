<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb" colspan="2">{lang:mod} - {lang:manage}</td>
  </tr>
  <tr>
    <td class="leftb">{icon:editpaste} <a href="{url:cups_create}">{lang:new_cup}</a></td>
    <td class="leftb">{icon:contents} {lang:total}: {vars:count}</td>
  </tr>
</table>
<br />
{vars:message}

<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
  <tr>
    <td class="headb">{lang:game}</td>
    <td class="headb">{lang:name}</td>
    <td class="headb">{lang:max_teams}</td>
    <td class="headb">{lang:teams}</td>
    <td class="headb" colspan="4">{lang:options}</td>
  </tr>{loop:cups}
  <tr>
    <td class="leftc">{if:gameicon_exists}<img src="uploads/games/{cups:games_id}.gif" alt="" />{stop:gameicon_exists}</td>
    <td class="leftc"><a href="{url:cups_view:id={cups:cups_id}}">{cups:cups_name}</a></td>
    <td class="leftc">{cups:cups_teams}</td>
    <td class="leftc">{cups:participations}</td>
    <td class="leftc">{cups:start_link}</td>
    <td class="leftc"><a href="{url:cups_teams:where={cups:cups_id}}" title="{lang:teams}">{icon:kdmconfig}</a></td>
    <td class="leftc"><a href="{url:cups_edit:id={cups:cups_id}}" title="{lang:edit}">{icon:edit}</a></td>
    <td class="leftc"><a href="{url:cups_remove:id={cups:cups_id}}" title="{lang:remove}">{icon:editdelete}</a></td>
  </tr>{stop:cups}
</table>
