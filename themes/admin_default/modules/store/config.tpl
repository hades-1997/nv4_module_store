<!-- BEGIN: main -->
<div id="users">
	<form action="{FORM_ACTION}" method="post">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover">
				<colgroup>
					<col style="width: 260px" />
					<col/>
				</colgroup>
				<tfoot>
					<tr>
						<td colspan="2"><input type="submit" name="submit" value="{LANG.config_save}" class="btn btn-primary" /></td>
					</tr>
				</tfoot>
				<tbody>
					<tr>
						<td>{LANG.config_view_type}</td>
						<td>
						<select name="viewtype" class="form-control w200">
							<!-- BEGIN: loop -->
							<option value="{VIEWTYPE.id}" {VIEWTYPE.selected}>{VIEWTYPE.title}</option>
							<!-- END: loop -->
						</select></td>
					</tr>
					
					
					<tr>
						<td>{LANG.config_view_type_page}</td>
						<td>
						<select class="form-control w200" name="per_page">
							<!-- BEGIN: per_page -->
							<option value="{PER_PAGE.key}"{PER_PAGE.selected}>{PER_PAGE.title}</option>
							<!-- END: per_page -->
						</select></td>
					</tr>
					
					<tr>
						<td>{LANG.config_per_home}</td>
						<td>
						<select name="per_home" class="form-control w200">
							<!-- BEGIN: per_home -->
							<option value="{PER_HOME.key}"{PER_HOME.selected}>{PER_HOME.title}</option>
							<!-- END: per_home -->
						</select></td>
					</tr>
					<tr>
						<td>{LANG.config_per_row}</td>
						<td>
						<select name="per_row" class="form-control w200">
							<!-- BEGIN: per_row -->
							<option value="{PER_ROW.key}"{PER_ROW.selected}>{PER_ROW.title}</option>
							<!-- END: per_row -->
						</select></td>
					</tr>
					<tr>
						<td>{LANG.config_facebookapi}</td>
						<td><input class="form-control w200" name="facebookapi" value="{DATA.facebookapi}" /><span class="help-block">{LANG.config_facebookapi_note}</span></td>
					</tr>
					<tr>
						<td>{LANG.config_thaoluan}</td>
						<td><input type="checkbox" value="1" name="thaoluan"{THAOLUAN}/></td>
					</tr>
                    
                    <tr>
                        <td>{LANG.config_key_map}</td>
                        <td><input class="form-control w200" name="key_map" value="{DATA.key_map}"/></td>
                    </tr>
					
					
					<tr>
						<td>{LANG.config_view_related_articles}</td>
						<td>
						<select class="form-control w200" name="related_articles">
							<!-- BEGIN: related_articles -->
							<option value="{RELATED_ARTICLES.key}"{RELATED_ARTICLES.selected}>{RELATED_ARTICLES.title}</option>
							<!-- END: related_articles -->
						</select></td>
					</tr>
				

				</tbody>
			</table>
		</div>
	</form>
</div>
<!-- END: main -->