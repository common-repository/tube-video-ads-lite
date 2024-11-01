<script>
	jQuery(document).ready(function(){
		jQuery('.checkall').click(function(){
			if(jQuery(this).is(':checked')){
				jQuery('.checkall').prop('checked', true);
				jQuery('.link_checkbox').prop('checked', true);
			}else{
				jQuery('.checkall').prop('checked', false);
				jQuery('.link_checkbox').prop('checked', false);
			}
		})
		
	})
</script>
<div class="wrap">

    <div id="icon-edit-pages" class="icon32"><br></div>
    <h2><?php echo $title; ?> <a href="admin.php?page=add_wpyoulink" class="add-new-h2">Add New WpLink</a> </h2><br>
	<form method="post">
		<table class="widefat contests">
			<thead>
			<th><input type="checkbox" class="checkall" /></th>
			<th class="column-1">Title</th>
			<th>Shortcode</th>
			<th class="column-3">Created</th>		
			</thead>
			<tfoot>
			<th><input type="checkbox" class="checkall" /></th>
			<th class="column-1">Title</th>
			<th>Shortcode</th>
			<th class="column-3">Created</th>		
			</tfoot>
			<tbody>
				<?php foreach($linkList as $link): ?>
					<tr>
						<td><input type="checkbox" name="to_delete[]" value="<?php echo $link->id ?>" class="link_checkbox" /></td>
						<td><a href="admin.php?page=add_wpyoulink&id=<?php echo $link->id ?>"><?php echo $link->title; ?></a></td>
						<td>[video_link id=<?php echo $link->id ?>]</td>
						<td><?php echo $link->created ?></td>
					</tr>
				<?php endforeach; ?>

			</tbody>

		</table>
	

		<select name="action">
			<option value="-">Bulk Actions</option>
			<option value="delete">Delete</option>
		</select>
		<input type="submit" value="Apply" />
	</form>
</div>