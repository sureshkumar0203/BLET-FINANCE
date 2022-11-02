
//Enable Only A and P for textbox
function isAPKeys(evt)
{
	 var charCode = (evt.which) ? evt.which : event.keyCode
	 //alert(charCode);
	 if (charCode == 80 || charCode == 65 || charCode == 97 || charCode == 112 || charCode == 8)
	 {
		return true;
	 }
	 else
	 {
		return false;
	 }
}

//Except Characters
function PhoneNo(evt)
{
	 var charCode = (evt.which) ? evt.which : event.keyCode
	 if ((charCode >= 97 && charCode <=122) || ((charCode >= 65 && charCode <=90)))
	 {
		return false;
	 }
	 else
	 {
		return true;
	 }
}

//Allow only Number
function isNumberKey(evt)
{
 var charCode = (evt.which) ? evt.which : event.keyCode
	 if (charCode > 31 && (charCode < 48 || charCode > 57))
	return false;
	return true;
}

//Number with Character


//Not Allow any Number values (0-9)
function AlfaNumberic(evt)
{
	var charCode = (evt.which) ? evt.which : event.keyCode
	 //alert(charCode);
	 if (charCode >= 48 && charCode <= 57)
	 {
		return false;
	 }
	 else
	 {
		return true;
	 }
}


//Check valid URL
/*function isURL(s)
{
 	var regexp = /http:\/\/[A-Za-z0-9\.-]{3,}\.[A-Za-z]{3}/;
 	return regexp;
}*/


//Allow Only Character values
function OnlyCharacter(evt)
{
	var charCode = (evt.which) ? evt.which : event.keyCode
	 //alert(charCode);
	 if (charCode >= 97 && charCode <= 122)
	 {
		return true;
	 }
	 else if (charCode >= 65 && charCode <= 90)
	 {
		return true;
	 }
	 else if (charCode == 32 || charCode == 46)
	 {
		return true;
	 }
	 else
	 {
		return false;
	 }
}

//Only Phone characters
function Phone(evt)
{
	 var charCode = (evt.which) ? evt.which : event.keyCode
	 //alert(charCode);
	 if ((charCode >= 97 && charCode <=122) || ((charCode >= 65 && charCode <=90)))
	 {
		return false;
	 }
	 else if((charCode>=48 && charCode <=57) || charCode==43 || charCode==32 || charCode==45 || charCode==40 || charCode==41 || charCode==8)
	 {
		return true;
	 }
	 else
	 {
		return false;
	 }
}
//validate phone number
function validatephone(xxxxx) {
	 var maintainplus = '';
 	var numval = xxxxx.value
 	if ( numval.charAt(0)=='+' ){ var maintainplus = '+';}
 	curphonevar = numval.replace(/[\\A-Za-z!"£$%^&*+_={};:'@#~,.¦\/<>?|`¬\]\[]/g,'');
 	xxxxx.value = maintainplus + curphonevar;
 	var maintainplus = '';
 	xxxxx.focus;
}



<!-- Begin
<!--function textCounter(field, countfield, maxlimit)
/*{
	if (field.value.length > maxlimit) // if too long...trim it!
	field.value = field.value.substring(0, maxlimit);


else 
	countfield.value = maxlimit - field.value.length;
}*/

<!--<textarea name=message wrap=physical cols=28 rows=4 onKeyDown="textCounter(this.form.message,this.form.remLen,125);" onKeyUp="textCounter(this.form.message,this.form.remLen,125);"></textarea>-->
// End -->

/* For additional information about this JavaScript
and how to use it, see the "Displaying Number of Words
Typed Into Form Fields" article, linked from the archives
at from http://willmaster.com/possibilities/archives/
The above note and the copyright line must remain with
this JavaScript source code. Comments below this point
in the code may be removed if desired. */

// Customizing this JavaScript code requires specifying eight values.

// Value One:
// Specify the maximum number of characters the form field
// may contain. If you have no maximum, specify 0 (zero).

var MaximumCharacters = "500";

// Value Two:
// Specify the maximum number of words the form field may
// contain. If you have no maximum, specify 0 (zero).

var MaximumWords = "100";

// Value Three:
// Specify the form's name (provided by the name="_____"
// attribute in the FORM tag).

var FormName = "frm";

// Value Four:
// Specify the name of the text field being monitored
// (provided by the name="_____" attribute in the
// INPUT or TEXTARE tag).

var TextFieldName = "lastnarr";

// Value Five:
// Specify the field name where where is to be displayed
// the number of characters the user has typed. Make
// it blank (nothing between the quotation marks) if
// you aren't displaying the number of characters typed.

var CharactersTypedFieldName = "CharsTyped";

// Value Six:
// Specify the field name where where is to be displayed
// the number of characters left that may be typed.
// Make it blank (nothing between the quotation marks)
// if you aren't displaying the number of characters
// left.

var CharactersLeftFieldName = "CharsLeft";

// Value Seven:
// Specify the field name where where is to be displayed
// the number of words the user has typed. Make it
// blank (nothing between the quotation marks) if you
// aren't displaying the number of words typed.

var WordsTypedFieldName = "WordsTyped";

// Value Eight:
// Specify the field name where where is to be displayed
// the number of words left that may be typed. Make it
// blank (nothing between the quotation marks) if you
// aren't displaying the number of words left.

var WordsLeftFieldName = "WordsLeft";

//////////////////////////////////////////////////////
//                                                  //
//  No modfications are required below this point.  //
//                                                  //
//////////////////////////////////////////////////////

var WordsMonitor = 0;
var MaxWords = parseInt(MaximumWords);
var MaxChars = parseInt(MaximumCharacters);
var textfield = 'document.' + FormName + '.' + TextFieldName + '.value';

function WordLengthCheck(s,l) {
WordsMonitor = 0;
var f = false;
var ts = new String();
for(var vi = 0; vi < s.length; vi++) {
	vs = s.substr(vi,1);
	if((vs >= 'A' && vs <= 'Z') || (vs >= 'a' && vs <= 'z') || (vs >= '0' && vs <= '9')) {
		if(f == false)	{
			f = true;
			WordsMonitor++;
			if((l > 0) && (WordsMonitor > l)) {
				s = s.substring(0,ts.length);
				vi = s.length;
				WordsMonitor--;
				}
			}
		}
	else { f = false; }
	ts += vs;
	}
return s;
} // function WordLengthCheck()

function CharLengthCheck(s,l) {
if(s.length > l) { s = s.substring(0,l); }
return s;
} // function CharLengthCheck()

function InputCharacterLengthCheck() {
if(MaxChars <= 0) { return; }
var currentstring = new String();
eval('currentstring = ' + textfield);
var currentlength = currentstring.length;
eval('currentstring = CharLengthCheck(' + textfield + ',' + MaxChars + ')');
if(CharactersLeftFieldName.length > 0) {
	var left = 0;
	eval('left = ' + MaxChars + ' - ' + textfield + '.length');
	if(left < 0) { left = 0; }
	eval('document.' + FormName + '.' + CharactersLeftFieldName + '.value = ' + left);
	if(currentstring.length < currentlength) { eval(textfield + ' = currentstring.substring(0)'); }
	}
if(CharactersTypedFieldName.length > 0) {
	eval('document.' + FormName + '.' + CharactersTypedFieldName + '.value = ' + textfield + '.length');
	if(currentstring.length < currentlength) { eval(textfield + ' = currentstring.substring(0)'); }
	}
} // function InputCharacterLengthCheck()

function InputWordLengthCheck() {
if(MaxWords <= 0) { return; }
var currentstring = new String();
eval('currentstring = ' + textfield);
var currentlength = currentstring.length;
eval('currentstring = WordLengthCheck(' + textfield + ',' + MaxWords + ')');
if (WordsLeftFieldName.length > 0) {
	var left = MaxWords - WordsMonitor;
	if(left < 0) { left = 0; }
	eval('document.' + FormName + '.' + WordsLeftFieldName + '.value = ' + left);
	if(currentstring.length < currentlength) { eval(textfield + ' = currentstring.substring(0)'); }
	}
if (WordsTypedFieldName.length > 0) {
	eval('document.' + FormName + '.' + WordsTypedFieldName + '.value = ' + WordsMonitor);
	if(currentstring.length < currentlength) { eval(textfield + ' = currentstring.substring(0)'); }
	}
} // function InputWordLengthCheck()

function InputLengthCheck() {
InputCharacterLengthCheck();
InputWordLengthCheck();
} // function InputLengthCheck()


//validate  number and Hyphen(-) Allowed (2011-12)
function validatenumber(xxxxx) {
	 var maintainplus = '';
 	var numval = xxxxx.value
 	
 	curphonevar = numval.replace(/[\\A-Za-z!"£$%^&*+_={};():'@#~,.¦\/<>?|`¬\]\[]/g,'');
 	xxxxx.value = maintainplus + curphonevar;
 	var maintainplus = '';
 	xxxxx.focus;
}




//Number with Character
function NumwithChar(evt)
{
	 var charCode = (evt.which) ? evt.which : event.keyCode
	 
	 if(charCode==32)// Space
	 {
	 	return true;
	 }
	 else if(charCode>=48 && charCode<=57)// 0-9
	 {
	 	return true;
	 }
	 else if(charCode>=97 && charCode<=122)// a-z
	 {
	 	return true;
	 }
	 else if(charCode>=65 && charCode<=90)// A-Z
	 {
	 	return true;
	 }
	 else
	 {
	 	return false;
	 }
}
