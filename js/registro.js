document.getElementById("registrationForm").addEventListener("submit", function(event) {
    const email = document.getElementById("email").value;
    const password = document.getElementById("password").value;
  
    if (!isValidEmail(email)) {
      event.preventDefault(); 
      alert("Por favor, ingrese un correo electrónico válido.");
    }
  
    if (!isValidPassword(password)) {
      event.preventDefault(); 
      alert("La contraseña debe tener al menos 8 caracteres.");
    }
  });
  
  function isValidEmail(email) {
   
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
  }
  
  function isValidPassword(password) {

    return password.length >= 8;
  }