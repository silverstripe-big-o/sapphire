<div class="breadcrumbs-default hide">
<% control Breadcrumbs %>
	<% if First %>
		<span class="cms-panel-link crumb">$Title.XML</span>
	<% end_if %>
<% end_control %>
</div>
<div class="breadcrumbs-full">
<% control Breadcrumbs %>
	<% if Last %>
		<span class="cms-panel-link crumb">$Title.XML</span>
	<% else %>
		<a class="<% if ListChildren %>list-children-link<% else %>cms-panel-link<% end_if %> crumb" href="$Link">$Title.XML</a> /
	<% end_if %>
<% end_control %>
</div>