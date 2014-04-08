<div id="header">
    <div class="row">
        <h2 class="ttl ttl3">Users</h2>
		<?php echo $template['partials']['search']; ?>
    </div>
</div>

<div class="row">

    <div class="three columns push-nine side-bar-wrapper">
        <div class="panel">
            <h4 class="sidebar-title">Users</h4>
            <p>Manage your users here</p>
            <h4 class="sidebar-title"><?php echo __('global:quick_links'); ?></h4>
            <ul class="side-bar-btns">
                <li class="add"><a href="<?php echo site_url('admin/users/create') ?>" class="fire-ajax">Add User</a></li>
            </ul><br />
        </div><!-- /panel -->
    </div><!-- /three columns side-bar-wrapper -->

    <div class="nine columns pull-three content-wrapper">
        <div class="table-area thirty-days">
            <table cellspacing="0" class="pc-table users-table" style="width: 100%;">
                <thead>
                    <tr>
                        <th class="cell1">&nbsp;</th>
                        <th class="cell1">Name</th>
                        <th class="cell3">Email</th>
                        <th class="cell5">Group</th>
                        <th class="cell5">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td data-title="Picture"><img src="<?php echo get_gravatar($user['email'], '40') ?>" class="members-pic" /></td>
                            <td data-title="Name"><?php echo anchor('admin/users/edit/' . $user['id'], $user['first_name'] . ' ' . $user['last_name'], 'class="fire-ajax"') ?></td>
                            <td data-title="Email"><?php echo mailto($user['email']) ?></td>
                            <td data-title="Group"><?php echo $user['group_description'] ?></td>
                            <td data-title="Actions">
                                <?php if (is_admin()): ?>
                                    <a href="<?php echo site_url("admin/users/".($user['active'] ? 'de' : '')."activate/" . $user['id']);?>" class="tiny button"><?php echo $user['active'] ? 'Deactivate' : 'Activate'; ?></a>
                                    <a href="<?php echo site_url('admin/users/edit/' . $user['id']);?>" class="fire-ajax tiny button">Edit</a>
                                    <a href="<?php echo site_url('admin/users/delete/' . $user['id']);?>" class="tiny button">Delete</a>
                                <?php else: ?>
                                    <div class="tiny button disabled"><?php echo $user['active'] ? 'Deactivate' : 'Activate'; ?></div>
                                    <div class="disabled tiny button">Edit</div>
                                    <div class="disabled tiny button">Delete</div>
                                <?php endif ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div><!-- /table-area -->
    </div><!-- /nine columns content-wrapper -->
</div><!-- /row -->