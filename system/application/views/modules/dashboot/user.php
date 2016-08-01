<?if (!defined('BASEPATH')) exit('No direct script access allowed')?>
<? if (isset($_REQUEST['action']) && 'user_saved'==$_REQUEST['action']): ?>
<div class="alert alert-success">User profile has been saved<a href="?book_id=<?=@$book_id?>&zone=user" style="float:right;">clear</a></div>
<? endif ?>
<? if (isset($_REQUEST['action']) && 'duplicated'==$_REQUEST['action']): ?>
<div class="alert alert-success">Book has been duplicated, you now have a new book present in the list of books at the bottom of the page<a href="?book_id=<?=@$book_id?>&zone=user" style="float:right;">clear</a></div>
<? endif ?>
<? if (isset($_REQUEST['action']) && 'added'==$_REQUEST['action']): ?>
<div class="alert alert-success">Book has been created (and is now present in the list to the right)<a href="?book_id=<?=@$book_id?>&zone=user" style="float:right;">clear</a></div>
<? endif ?>
<? if (isset($_REQUEST['error']) && 'email_exists'==$_REQUEST['error']): ?>
<div class="alert alert-danger">The email address entered already exists in the system. Please try again with a different email.<a href="?book_id=<?=@$book_id?>&zone=user" style="float:right;">clear</a></div>
<? endif ?>
<? if (isset($_REQUEST['error']) && 'fullname_required'==$_REQUEST['error']): ?>
<div class="alert alert-danger">Full name is a required field.  Please enter a full name and try again.<a href="?book_id=<?=@$book_id?>&zone=user" style="float:right;">clear</a></div>
<? endif ?>
<? if (isset($_REQUEST['error']) && 'incorrect_password'==$_REQUEST['error']): ?>
<div class="alert alert-danger">Incorrect current password<a href="?book_id=<?=@$book_id?>&zone=user" style="float:right;">clear</a></div>
<? endif ?>
<? if (isset($_REQUEST['error']) && 'password_match'==$_REQUEST['error']): ?>
<div class="alert alert-danger">New password and retype password do not match<a href="?book_id=<?=@$book_id?>&zone=user" style="float:right;">clear</a></div>
<? endif ?>
<div class="container-fluid user">
  <div class="row">
    <section class="col-xs-12 col-sm-6">
      <div class="page-header"><h4>Account</h4></div>
	  <form class="form-horizontal" action="<?=confirm_slash(base_url())?>system/dashboard" method="post" id="user_form">
	    <input type="hidden" name="action" value="do_save_user" />
	    <input type="hidden" name="id" value="<?=$login->user_id?>" />
	    <input type="hidden" name="book_id" value="<?=@$book_id?>" />      
        <div class="form-group">
          <label for="fullname" class="col-sm-4 control-label">Full name</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" id="fullname" name="fullname" value="<?=htmlspecialchars($login->fullname)?>">
          </div>
        </div>
        <div class="form-group">
          <label for="email" class="col-sm-4 control-label">Email (login)</label>
          <div class="col-sm-8">
            <input type="email" class="form-control" id="email" name="email" value="<?=htmlspecialchars($login->email)?>">
          </div>
        </div>
        <div class="form-group">
          <label for="url" class="col-sm-4 control-label">Website</label>
          <div class="col-sm-8">
            <input type="url" class="form-control" id="url" name="url" value="<?=htmlspecialchars($login->url)?>" placeholder="http://">
          </div>
        </div>
<?php if ($login_is_super): ?>
        <div class="form-group">
          <label class="col-sm-4 control-label">Admin status</label>
          <label class="col-sm-8 control-label label-text">You are an admin</label>
        </div>     
<?php endif; ?>   
        <!-- Avatar? -->
        <div class="form-group">
          <div class="col-sm-offset-4 col-sm-8">
            <small>To change your password enter the following values:</small>
          </div>
        </div>          
        <div class="form-group">
          <label for="old_password" class="col-sm-4 control-label">Current password</label>
          <div class="col-sm-8">
            <input type="password" class="form-control" id="old_password" name="old_password">
          </div>
        </div>
        <div class="form-group">
          <label for="password" class="col-sm-4 control-label">New password</label>
          <div class="col-sm-8">
            <input type="password" class="form-control" id="password" name="password">
          </div>
        </div>
        <div class="form-group">
          <label for="password_2" class="col-sm-4 control-label">Retype new</label>
          <div class="col-sm-8">
            <input type="password" class="form-control" id="password_2" name="password_2">
          </div>
        </div>    
        <div class="page-header">&nbsp;</div>
        <div class="form-group">
          <div class="col-sm-12">
            <button type="submit" class="btn btn-primary pull-right">Save changes</button>
          </div>
        </div>                    
	  </form>
    </section>
    <section class="col-xs-12 col-sm-6">
      <div class="page-header"><h4>Books</h4></div>
      <div class="form-inline">
      	<button class="btn btn-default" data-toggle="modal" data-target="#createBookModal">Create new book</button> &nbsp; 
      	<button class="btn btn-default" data-toggle="modal" data-target="#duplicateBookModal">Duplicate existing book</button>
      </div>
      <div class="page-v-spacer"></div>
      <div class="table-responsive">
        <table class="table table-condensed">
          <thead>
            <tr>
              <th>Title</th>
              <th>Role</th>
              <th></th>
            </tr>
          </thead>
          <tbody><?php 
	    	  foreach ($my_books as $my_book) {
	    	  	$role = '(No role)';
	    	  	foreach ($my_book->users as $my_user) {
	    	  		if ($my_user->user_id == $login->user_id) $role = ucwords($my_user->relationship);
	    	  	}
	    		echo '<tr class="'.(($my_book->book_id==$book_id)?'info':'').'">';
	    		echo '<td>';
	    		echo '<a href="'.base_url().$my_book->slug.'">';
	    		echo strip_tags($my_book->title);
	    		echo '</a>';
	    		echo '</td>';
	    		echo '<td>';
	    		echo $role;
	    		echo '</td>';
	    		echo '<td class="">';
	    		echo '<a href="?book_id='.$my_book->book_id.'" class="btn btn-default btn-xs pull-right">Dashboard</a>';
	    		echo '</td>';
	    		echo '</tr>';
	    	  }
          ?></tbody>
        </table>
      </div>
    </section>    
  </div>
</div>

<div class="modal fade" id="createBookModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form class="form-horizontal" action="<?=confirm_slash(base_url())?>system/dashboard" method="post" onsubmit="if (!this.title.value.length||this.title.value=='New book title') {alert('Please enter a book title');return false;}">
      <input type="hidden" name="action" value="do_add_book" />
      <input type="hidden" name="user_id" value="<?=$login->user_id?>" />    
      <div class="modal-body">
        <div class="page-header"><h4>Create new book</h4></div>
        <div class="form-group">
          <label for="title" class="col-sm-2 control-label">Title</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="title" name="title" placeholder="New book title">
          </div>
        </div>
        <div class="form-group">
          <label for="subtitle" class="col-sm-2 control-label">Subtitle</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="subtitle" name="subtitle" placeholder="New book subtitle">
          </div>
        </div>
        <div class="form-group">
          <label for="scope" class="col-sm-2 control-label">Genre</label>
          <div class="col-sm-4">
            <select class="form-control" id="scope" name="scope">
              <option value="book">Book</option>
              <option value="article">Article</option>
              <option value="project">Project</option>
            </select>
          </div>
          <div class="col-sm-6">
            <small>For cosmentic purposes only&mdash;will be displayed throughout the interface</small>
          </div>
        </div>        	  
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Create</button>
      </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="duplicateBookModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <p>Duplicate book</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Duplicate</button>
      </div>
    </div>
  </div>
</div>