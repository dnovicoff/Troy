function getcookie(cookiename) 
{
  var cookiestring=""+document.cookie;
  var index1=cookiestring.indexOf(cookiename);
  if (index1==-1 || cookiename=="") return ""; 
  var index2=cookiestring.indexOf(';',index1);
  if (index2==-1) index2=cookiestring.length; 
  return unescape(cookiestring.substring(index1+cookiename.length+1,index2));
}

function LogInStatus(XValue)
{
  var CookieValue = getcookie('TROY-CORP_LI');
  if (CookieValue == "")
  {
    return "9";
  }
  else if (CookieValue.substring(6,7) == 'I')
  {
    return "5";
  }
  else
  {  
    return "7";
  }
}

function GetUserName(XValue)
{
  var CookieValue = getcookie('TROY-CORP_LI');
  if (CookieValue == "")
  {
    return "-2";
  }
  else if (CookieValue.length < 38)
  {
    return "Welcome To Troy-Corp.com";
  }
  else
  {  

    var TempName1 = CookieValue.substring(37);
    var TempName2 = TempName1.replace(/9/g, " ")

    return TempName2;
  }
}

function IsSOL(XValue)
{
  var CookieValue = getcookie('TROY-CORP_LI');
  if (CookieValue == "")
  {
    return "9";
  }
  else 
  if 
    ((CookieValue.substring(0,1) == 'A') || 
	(CookieValue.substring(0,1) == 'U') ||
	(CookieValue.substring(0,1) == 'S') ||
	(CookieValue.substring(0,1) == 'D') ||
	(CookieValue.substring(0,1) == 'M') ||
	(CookieValue.substring(0,1) == 'C')) 
  {
    return "5";
  }
  else
  {  
    return "7";
  }
}

function IsWCL(XValue)
{
  var CookieValue = getcookie('TROY-CORP_LI');
  if (CookieValue == "")
  {
    return "9";
  }
  else 
  if 
    ((CookieValue.substring(0,1) == 'W') || 
	(CookieValue.substring(0,1) == 'A') ||
	(CookieValue.substring(0,1) == 'U') ||
	(CookieValue.substring(0,1) == 'S') ||
	(CookieValue.substring(0,1) == 'D') ||
	(CookieValue.substring(0,1) == 'M') ||
	(CookieValue.substring(0,1) == 'C')) 
  {
    return "5";
  }
  else
  {  
    return "7";
  }
}

function setCookie(name, value, expires, path, domain, secure) 
{
  var cookieString = name + "=" +escape(value) +
       ( (expires) ? ";expires=" + expires.toGMTString() : "") +
       ( (path) ? ";path=" + path : "") +
       ( (domain) ? ";domain=" + domain : "") +
       ( (secure) ? ";secure" : "");
    document.cookie = cookieString; 
}

function CartTotal(XValue)
{
  var now = new Date();
  var vSecure = new Boolean(0);
  var CookieValue = getcookie('TROY-CORP_WC');
  if (CookieValue != "")
  {
    return CookieValue.substring(38,40);
  }
  else
  {
    now.setTime(now.getTime() + 365 * 24 * 60 * 60 * 1000);
    setCookie("TROY-CORP_WC", "B000000099990000000000009999000000000000", now, "/", ".troy-corp.com", false);
    return "0"
  }
}

// -->
