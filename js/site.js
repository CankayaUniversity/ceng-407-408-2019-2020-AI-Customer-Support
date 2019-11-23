/* window.onscroll = () => {
    const nav = document.querySelector('#navbar');
    if(this.scrollY <= 250) nav.className = 'navbar navbar-expand-lg navbar-dark navbar-custom fixed-top'; 
    else nav.className = 'scroll navbar navbar-expand-lg navbar-dark navbar-custom fixed-top';
  };
  */

 var check = function() {
  if (document.getElementById('Password').value ==
    document.getElementById('ConfirmPassword').value) {
    document.getElementById('message').style.color = 'green';
    document.getElementById('message').innerHTML = 'Password matching';
  } else {
    document.getElementById('message').style.color = 'red';
    document.getElementById('message').innerHTML = 'Password is not matching';
  }
}