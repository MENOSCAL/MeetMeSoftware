var gapi;

 (function() {
       var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
       po.src = 'https://apis.google.com/js/client.js?onload=onLoadCallback';
       var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
     })();
     
     
function logout()
{
    gapi.auth.signOut();
    location.reload();
}

function login() 
{
  var myParams = {
    'clientid' : '813345231026-pr0rfdg8rprhb5k3003c9hoqta03bkln.apps.googleusercontent.com', //You need to set client id
    'cookiepolicy' : 'single_host_origin',
    'callback' : 'loginCallback', //callback function
    'approvalprompt':'force',
    'scope' : 'https://www.googleapis.com/auth/plus.login https://www.googleapis.com/auth/plus.profile.emails.read'
  };
  gapi.auth.signIn(myParams);
}

function loginCallback(result)
{
    if(result['status']['signed_in'])
    { 
        alert("Login Success");
    }   
 
}


function onLoadCallback()
{
    gapi.client.setApiKey('AIzaSyC31T5HW9OTl28C344KE3qYPbZRmFVfoOo');
    gapi.client.load('plus', 'v1',function(){});
}

  
     
     