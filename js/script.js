 async function sendData(form) {

    const formData = new FormData(form);
    formData.append("submit", "true");

    try {
      document.getElementById("form").innerHTML = "<div class=\"loader \"></div>"

      const response = await fetch("api/users/create.php", {
        method: "POST",
        body: formData,
      });

      oggetto_risposta = await response.json()

      document.getElementById("form").innerHTML = "<h1>Ben fatto, api ritorna "+oggetto_risposta.insert+"</h1>"

    } catch (e) {
      console.error(e);
    }
  }

  document.getElementById("form").addEventListener("submit", (e) => {
    e.preventDefault();

    sendData(e.target)

  })