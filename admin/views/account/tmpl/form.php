<?php defined('_JEXEC') or die('Restricted access'); ?>

<form action="index.php" method="post" name="adminForm" id="adminForm">
<div class="col100">
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'DS Account' ); ?></legend>

		<table class="admintable">
		<tr>
			<td width="100" align="right" class="key">
				<label for="endpoint">
					<?php echo JText::_( 'Endpoint' ); ?>:
				</label>
			</td>
			<td>
                <select name="mode" id="mode">
                    <option value="prod">Production</option>
                    <option <?php if ($this->account->mode == 'demo') echo 'selected="selected"'; ?> value="demo">Demo</option>
                </select>
			</td>
		</tr>
		<tr>
			<td width="100" align="right" class="key">
				<label for="email">
					<?php echo JText::_( 'Login email' ); ?>:
				</label>
			</td>
			<td>
				<input class="text_area required" type="text" name="email" id="email" 
				    size="32" 
				    maxlength="250" 
				    value="<?php echo $this->account->email;?>" />
			</td>
		</tr>
		<tr>
			<td width="100" align="right" class="key">
				<label for="password">
					<?php echo JText::_( 'Password' ); ?>:
				</label>
			</td>
			<td>
				<input class="text_area required" type="password" name="password" id="password" 
				    size="32" 
				    maxlength="250" 
				    value="<?php echo ($this->account->password) ? '•••••••••' : ''; ?>" />
			</td>
		</tr>
		<tr>
			<td width="100" align="right" class="key">
				<label for="accountId">
					<?php echo JText::_( 'Account Name' ); ?>:
				</label>
			</td>
			<td>
                <select name="accountId" id="accountId" style="display:none"></select>
				<p><a href="#" id="getAccounts">Fetch your account names</a></p>
			</td>
		</tr>
		
	</table>
	</fieldset>
</div>
<div class="clr"></div>

<input type="hidden" name="option" value="com_dsexpress" />
<input type="hidden" name="id" value="<?php echo $this->account->id; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="account" />

</form>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/ext-core/3.0/ext-core-debug.js"></script>
<script type="text/javascript" charset="utf-8">

Ext.fly('getAccounts').on('click', function(e, t) 
{
	e.preventDefault();
    
    Ext.Ajax.request({
        url: 'index.php?option=com_dsexpress&format=raw&task=getAccounts',
        method: 'POST',
        params: {
            mode: Ext.get('mode').getValue(),
            email: Ext.get('email').getValue(), 
            password: Ext.get('password').getValue()
        },
        // Returns option list with value as accountId|userId
        success: function(response, opts) 
        {
            Ext.fly('getAccounts').remove();

            var target = Ext.fly('accountId');
            target.show();
            target.dom.innerHTML = response.responseText;
        },
        failure: function(response, opts) 
        {

        }
    });
});
    
</script>