async function sendData(form) {

  const formData = new FormData(form);
  formData.append("submit", "true");

  let nome = formData.get("nome").trim() //formdata, oggetto complesso ritornato da new FormData(), 
  // espone la funzione .get() per accedere ai campi del form, l'uso e': formData.get("nome campo input"),
  // ritorna una stringa/intero in base al valore 
  // successivamente, con .trim(), rimuovo gli spazi vuoti dall'inizio e alla fine della stringa
  let cognome = formData.get("cognome").trim()
  let email = formData.get("email").trim()
  let password = formData.get("password").trim()
  let cf = formData.get("cf").trim()
  let tel = formData.get("telefono").trim()


  if (!nome || nome?.length == 0) {
    //verifico che nome esista E non sia di lunghezza 0, se una delle due condizioni e' vera, chiama un alert
    alert("compilare nome")
    return false
  }
  if (!cognome || cognome?.length == 0) {
    alert("compilare cognome")
    return false
  }
  if (!validateEmail(email)) {
    alert("compilare email ed assicurarsi che contenga almeno una @ e sia valida")
    return false
  }
  if (!password || password?.length == 0) {
    alert("compilare password")
    return false
  }
  if (!cf || cf?.length == 0 || cf?.length != 16) {
    alert("compilare cf con lunghezza 16 caratteri")
    return false
  }
  if (!tel || tel?.length == 0) {
    alert("compilare telefono")
    return false
  }

  try {
    document.getElementById("form").innerHTML = "<div class=\"loader \"></div>"

    const response = await fetch("api/users/register2.php", {
      method: "POST",
      body: formData,
    });

    oggetto_risposta = await response.json()

    if (oggetto_risposta.utente_inserito) window.location = "login.php"

  } catch (e) {
    console.error(e);
  }
}

document.getElementById("form").addEventListener("submit", (e) => {
  e.preventDefault();

  sendData(e.target)

})


const validateEmailRegex = (email) => {
  return String(email)
    .toLowerCase()
    .match(
      /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|.(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
    );
};


function validateEmail(email) {
  var at = email.indexOf("@");
  var last_at = email.lastIndexOf("@");
  var dot = email.lastIndexOf("\.");
  return email.length > 0 &&
    at == last_at &&
    at > 0 &&
    dot > at + 1 &&
    dot < email.length &&
    email[at + 1] !== "." &&
    email.indexOf(" ") === -1 &&
    email.indexOf("..") === -1;
}
//@test.com
//test.aaa@testcom
//test.aaa@test.com.
//test.aaa@.test.com
//test@aaa@test.com
//test.aaa@test..com
//test aaa@.test.com