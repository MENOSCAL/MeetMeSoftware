function checkPasswordMatch() {
    var password = $("#newPassword").val();
    var confirmPassword = $("#confirmPassword").val();
    
    if (password != confirmPassword){
        $("#checkPasswordMatch").html("Passwords do not match!");
        document.getElementById("btn_register").disabled = true; 
    }
    else{
        
        if (password.length < 7 || password.length > 14){
           $("#checkPasswordMatch").html("Password must be between 7 and 14 characters");
           document.getElementById("btn_register").disabled = true; 
        }else{
            if (hasNumbers(password) == 0){
                 $("#checkPasswordMatch").html("Password must contain a number.");
                 document.getElementById("btn_register").disabled = true; 
            }
            
            else{
                if (hasLowercase(password) == 0){
                      $("#checkPasswordMatch").html("Password must contain at least 1 lowercase.");
                      document.getElementById("btn_register").disabled = true; 
                }else{
                    if (hasCapitalLetter(password) == 0){
                      $("#checkPasswordMatch").html("Password must contain at least 1 capital letter.");
                      document.getElementById("btn_register").disabled = true; 
                }else{
                        $("#checkPasswordMatch").html("Password match. Password is correct.");
                        checkCountry();
                } 
        }
     }
    }
  }
}

function checkCountry(){
     var country =  document.getElementById("countrycbx").value ;
    if (country == -1){
        $("#checkCountry").html("Please select a country!");
        document.getElementById("newPassword").value = "";
        document.getElementById("confirmPassword").value = "";
        $("#checkPasswordMatch").html("");
    }else{
        $("#checkCountry").html("");
        document.getElementById("btn_register").disabled = false; 
    }
}


var numbers="0123456789";

function hasNumbers(pass){
   for(i=0; i<pass.length; i++){
      if (numbers.indexOf(pass.charAt(i),0)!=-1){
         return 1;
      }
   }
   return 0;
}

var letters="abcdefghyjklmnñopqrstuvwxyz";

function hasLowercase(pass){
   for(i=0; i<pass.length; i++){
      if (letters.indexOf(pass.charAt(i),0)!=-1){
         return 1;
      }
   }
   return 0;
}

var capitalLetters="ABCDEFGHYJKLMNÑOPQRSTUVWXYZ";

function hasCapitalLetter(pass){
   for(i=0; i<pass.length; i++){
      if (capitalLetters.indexOf(pass.charAt(i),0)!=-1){
         return 1;
      }
   }
   return 0;
}

$(window).ready(function () {
   $("#confirmPassword").keyup(checkPasswordMatch);
    $('input[name=auto]').click(function(){
        if($(this).val()=='si'){
            $('.auto').fadeIn(1000);
        }
        if($(this).val()=='no'){
            $('.auto').fadeOut(1000);
        }
    })
});