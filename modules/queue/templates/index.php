<!-- show queue -->
<?php
if($skinnyData['queuecount'] == 0)
{
	$this->notification = '<b> <span> <span class = "fa fa-exclamation-triangle"> </span> No Queue Added </span> </b>';
	$this->notificationclass = 'alert alert-info';
	$skinnyData['page'] = 0;
}
else if($skinnyData['page'] > $skinnyData['lastpage'])
{
	$this->notification = '<b> <span> <span class = "fa fa-exclamation-triangle"> </span> Enter page number correctly </span> </b>';
	$this->notificationclass = 'alert alert-warning';
}

$error = '';
$pagination = '';
$pagination .= "<div style = 'margin-left:30%'> <ul class='pagination pagination-lg'>";
# previous button
if ($skinnyData['page'] > 1) 
	$pagination.= "<li> <a href='{$skinnyData['targetpage']}&paged=1'> <span class = 'fa fa-angle-double-left'> </span> </a> </li> <li> <a href='{$skinnyData['targetpage']}&paged={$skinnyData['prev']}'> <span class = 'fa fa-angle-left'> </span> </a> </li>";
else
	$pagination.= "<li class = 'disabled'> <a> <span class = 'fa fa-angle-double-left'> </span> </a> </li> <li class = 'disabled'> <a> <span class = 'fa fa-angle-left'> </span> </a> </li>";	

# page text box	
$pagination .= '<li> <span class="paging-input"> <input class="current-page" type="text" size="1" value="'.$skinnyData['page'].'" name="saiob_queue_page" id = "saiob_queue_page" title="Current page"> of <span class="total-pages"> '.$skinnyData["lastpage"].'</span> </span> </li>';

#next button
if ($skinnyData['page'] < $skinnyData['lastpage']) 
	$pagination .= "<li> <a href='{$skinnyData['targetpage']}&paged={$skinnyData['next']}'> <span class = 'fa fa-angle-right'> </span> </a> </li> <li> <a href='{$skinnyData['targetpage']}&paged={$skinnyData['lastpage']}'> <span class = 'fa fa-angle-double-right'> </span> </a> </li>";
else
	$pagination .= "<li class='disabled'> <a> <span class = 'fa fa-angle-right'> </span> </a> </li> <li class = 'disabled'> <a> <span class = 'fa fa-angle-double-right'> </span> </a> </li>";

$pagination .= "</ul> </div>";		
$pagination .= "<script> jQuery('#saiob_queue_page').keypress(function (e) {
var key = e.which;
if(key == 13) 
{
	var paged = jQuery('#saiob_queue_page').val();
	var reg=/^-?[0-9]+$/;
	if(reg.test(paged))	{
		window.location.href = 'admin.php?page=social-all-in-one-bot/saiob.php&__module=queue&paged='+paged;
		return false;
	}
	var msg = 'Kindly enter Number'; 
	shownotification(msg, 'danger');
}
}); </script>";

?> 
<div class = "form-group"> <?php echo $error; ?> </div>
<table class = "table table-bordered" id = 'queue'>
	<tr>
		<th> # </th>
		<th> Provider </th>
		<th> Message </th>
		<th> Period </th>
		<th> Action </th>	
	</tr>
<?php	
foreach($skinnyData['queuelist'] as $singleQueue)
{ 
	$unser_message = maybe_unserialize($singleQueue->socialmessage);
	if($singleQueue->provider == 'twitter')
		$message = $unser_message;
	else
		$message = $unser_message['title'];

	$status = ($singleQueue->isrun == 0) ? 'In Queue' : 'Completed';
	$id = $singleQueue->id;
?> 
	<tr>
		<td> <?php echo $id; ?></td>
		<td> <?php echo $singleQueue->provider; ?> </td>
		<td> <?php echo $message; ?> </td>
		<td> <?php echo $singleQueue->period; ?> </td>
		<td> <span class = 'col-sm-1' style = 'height:25px;'> <button type = 'button' name = 'deleteform' id = 'delete_<?php echo $id; ?>' class = "btn btn-danger btn-sm" title = "Delete" onclick = "return performdeleteaction('queue','<?php echo $id; ?>', this)" data-loading-text="<span class = 'fa fa-spinner fa-spin'></span>">  <span class="fa fa-trash-o"> </span> </button> </span> </td>
	</tr>
<?php } ?>
</table> 
<?php echo $pagination; ?>
