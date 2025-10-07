async function sendData(form) {

  const formData = new FormData(form);
  formData.append("submit", "true");
 //formdata, oggetto complesso ritornato da new FormData(), 
  
  try {
    document.getElementById("form").innerHTML = "<div class=\"loader \"></div>"

    const response = await fetch("api/users/login.php", {
      method: "POST",
      body: formData,
    });

    oggetto_risposta = await response.json()

    document.getElementById("form").innerHTML = "<h1>Ben fatto, api ritorna " + oggetto_risposta.insert + "</h1>"

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