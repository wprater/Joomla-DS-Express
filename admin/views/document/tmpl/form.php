<?php defined('_JEXEC') or die('Restricted access'); ?>

<form action="index.php" enctype="multipart/form-data" method="post" name="adminForm" id="adminForm">
<div class="col100">
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'Details' ); ?></legend>

		<table class="admintable">
		<tr>
			<td width="100" align="right" class="key">
				<label for="name">
					<?php echo JText::_( 'Signing Name' ); ?>:
				</label>
			</td>
			<td>
				<input class="text_area required" type="text" name="name" id="name" size="32" maxlength="250" value="<?php echo $this->document->name;?>" />
			</td>
		</tr>
		<tr>
			<td width="100" align="right" class="key">
				<label for="documentName">
					<?php echo JText::_( 'Document Name' ); ?>:
				</label>
			</td>
			<td>
				<input class="text_area" type="text" disabled="1" name="documentName" id="documentName" size="32" maxlength="250" value="<?php echo $this->document->documentName;?>" />
			</td>
		</tr>
		<tr>
			<td width="100" align="right" class="key">
				<label for="document">
					<?php echo JText::_( 'Document (DPD only)' ); ?>:
				</label>
			</td>
			<td>
				<!-- <input type="hidden" name="MAX_FILE_SIZE" value="1000000" /> -->
				<input id="document" name="document_upload" type="file" />
			</td>
		</tr>
		
	</table>
	</fieldset>
</div>
<div class="clr"></div>

<input type="hidden" name="option" value="com_hello" />
<input type="hidden" name="id" value="<?php echo $this->document->id; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="document" />
</form>
