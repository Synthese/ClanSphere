<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
	<tr>
		<td class="headb">{lang:mod} - {lang:head_create}</td>
	</tr>
	<tr>
		<td class="leftc">{head:body}</td>
	</tr>
</table>
<br />

<form method="post" name="watermark_create" action="{url:gallery_wat_create}" enctype="multipart/form-data">
<table class="forum" cellpadding="0" cellspacing="{page:cellspacing}" style="width:{page:width}">
	<tr>
		<td class="leftb">{icon:xpaint} {lang:name} *</td>
		<td class="leftc"><input type="text" name="categories_name" value="{data:categories_name}" maxlength="80" size="40" /></td>
	</tr>
	<tr>
		<td class="leftb">{icon:download} {lang:pic_up} *</td>
		<td class="leftc"><input type="file" name="picture" value="" /><br />
			<br />
			{picup:clip}
		</td>
	</tr>
	<tr>
		<td class="leftb">{icon:ksysguard} {lang:options}</td>
		<td class="leftc">
			<input type="submit" name="submit" value="{lang:create}" />
			<input type="reset" name="reset" value="{lang:reset}" />
		</td>
	</tr>
</table>
</form>