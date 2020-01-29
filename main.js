function verify_existing_user(){

    var form_data = new FormData(document.getElementById('user_verify_form'));
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'bg/verify_user.php', true);
    xhr.onload = () => {
        if (xhr.status === 200) {
          var response=JSON.parse(xhr.response);
          if(response.status==false)
           alert(response.text);
          else if(response.status=="2fa")
          {
            alert(response.text)
            var otp_box =  document.getElementById('otp_box');
            otp_box.style.visibility="visible";

            xhr.open('POST', 'bg/authy_requests.php', true);
            var fd=new FormData();
            fd.append("new_otp",true);
            xhr.onload = () => 
            {
              if (xhr.status === 200)
              {
                var obj=JSON.parse(xhr.response);
                alert(obj.text);
              }
            };
            xhr.send(fd);
          }
          else{
            alert(response.text);
            window.location.href="welcome.php";
          }
        }
      };
    xhr.send(form_data);
  //   for (var value of form_data.values()) {
  //     console.log(value); 
  //  }
}

function show_data_section(){
  var first_activate_button = document.getElementById('activate_button');
  first_activate_button.style.display="none";

  var data_section = document.getElementById('data-container');
  data_section.style.visibility="visible";
}

function activate_2fa(){
  var form_data = new FormData(document.getElementById('2fa_activation_form'));
  form_data.append('2fa_activate',true);
  var xhr = new XMLHttpRequest();
  xhr.open('POST', 'bg/authy_requests.php', true);
  xhr.onload = () => {
      if (xhr.status === 200) {
        var response=JSON.parse(xhr.response);
        if(response.status==false)
         alert(response.text);
        else{
          alert(xhr.response);
          location.reload();
        }
      }
    };
  xhr.send(form_data);
}

function deactivate_2fa(){
  var form_data = new FormData();
  form_data.append('2fa_deactivate',true);
  var xhr = new XMLHttpRequest();
  xhr.open('POST', 'bg/authy_requests.php', true);
  xhr.onload = () => {
      if (xhr.status === 200) {
        var response=JSON.parse(xhr.response);
        if(response.status==false)
         alert(response.text);
        else{
          alert(xhr.response);
          location.reload();
        }
      }
    };
  xhr.send(form_data);
}

function send_new_otp(){
  
  var xhr = new XMLHttpRequest();
  xhr.open('POST', 'bg/authy_requests.php', true);
  var fd=new FormData();
  fd.append("new_otp",true);
  xhr.onload = () => 
  {
    if (xhr.status === 200)
    {
      var obj=JSON.parse(xhr.response);
      alert(obj.message);
    }
  };
  xhr.send(fd);
}

function verify_otp(){
  
  var xhr = new XMLHttpRequest();
  xhr.open('POST', 'bg/authy_requests.php', true);
  var fd=new FormData(document.getElementById('otp_form'));
  fd.append("verify_otp",true);
  xhr.onload = () => 
  {
    if (xhr.status === 200)
    {
      var obj=JSON.parse(xhr.response);
      alert(obj.text);
      if(obj.status==true)
        window.location.href="welcome.php";
    }
  };
  xhr.send(fd);
}


