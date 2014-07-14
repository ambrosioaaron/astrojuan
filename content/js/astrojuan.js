function astroBlock(blockID, blockText)
{
    $(blockID).children().hide();
    $(blockID).append('<h4 class="astroBlock" id=\'astroBlock\'>' + blockText + '</h4>')
}

function astroUnBlock(blockID) {
    $(blockID).children().show();
    $('#astroBlock').remove();
}

function isValidEmailAddress(emailAddress) {
    var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
    return pattern.test(emailAddress);
};

function isValidDisplayName(displayName) {
    var pattern = new RegExp(/^[A-Za-z0-9 _.-]+$/);
    return pattern.test(displayName);
};

function validateDisplayName(displayName)
{
	var res = true;
	
	if(!isValidDisplayName(displayName))
	{
		return "Letters and numbers only";
	}
	
	if(displayName.length < 6 || displayName.length > 20)
	{
		return "6 to 20 characters only";
	}
	
	return res;
}

function validateEmail(emailAddress)
{
	var res = true;
	
	if(!isValidEmailAddress(emailAddress))
	{
		return "Enter a valid email address";
	}
	
	return res;
}

function validatePassword(password)
{
	var res = true;
	
	if(password.length < 6 || password.length > 20)
	{
		return "6 to 20 characters only";
	}
	
	return res;
}

function confirmPassword(password, cpassword)
{
	var res = true;
	
	if(password != cpassword)
	{
		return "Password did not match";
	}
	
	return res;
}