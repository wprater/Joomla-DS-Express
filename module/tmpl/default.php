<?php 
// no direct access
defined('_JEXEC') or die('Restricted access'); ?>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/ext-core/3.0/ext-core-debug.js"></script>

<div class="dsexpress<?php echo $params->get( 'moduleclass_sfx' ) ?>">

<?php if (DsExpressHelper::isGuestUser()): ?>
    <p>You need to login to sign "<?php echo $signingDocument->name; ?>".</p>
<?php else: ?>
	<form action="default_submit" id="document-signing<?php echo $signingDocument->id; ?>" method="post" accept-charset="utf-8">
		<p>Please sign the "<?php echo $signingDocument->name; ?>" document.  You can start by clicking the button below.</p>

		<input type="hidden" name="documentId" value="<?php echo $signingDocument->id ?>" id="documentId"/>
		<input type="submit" name="submit" value="Begin Signing" id="ds-submit<?php echo $signingDocument->id; ?>"/>
	</form>
<?php endif ?>	

</div>

<script type="text/javascript" charset="utf-8">

	// Submit the form and return a embedded DS Link
	Ext.fly('ds-submit<?php echo $signingDocument->id; ?>').on('click', function(e, t) 
	{
		e.preventDefault();
		
		Ext.Ajax.request({
			// Passing format=raw allows Joomla disable the layout
			url: 'index.php?option=com_hello&format=raw&task=sign&id=<?php echo $signingDocument->id; ?>',
			success: function(response, opts) 
			{				
				var el = {
					tag: 'a',
					href: response.responseText,
					html: 'Open DocuSign window.',
					target: '_blank'
				};
				Ext.get(t).replaceWith(el);
				
				// var obj = Ext.decode(response.responseText);
				// 		      	console.dir(obj);		      
			},
			failure: function(response, opts) 
			{
				console.log('server-side failure with status code ' + response.status);
			}
		});
	});
	
</script>