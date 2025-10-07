<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mind Commerce</title>
    <style href="css/index.css"></style>
</head>
<body>

<form method="post" class="form-example" id="form">
  <div class="form-example">
    <label for="name">Nome: </label>
    <input type="text" name="nome" id="name" required />
  </div>  
  <div class="form-example">
    <label for="cognome">Cognome: </label>
    <input type="text" name="cognome" id="cognome" required />
  </div>   
  <div class="form-example">
    <label for="email">Email: </label>
    <input type="text" name="email" id="email" autocomplete="on" required />
  </div> 
   <div class="form-example">
    <label for="password">password: </label>
    <input type="password" name="password" id="password" autocomplete="off" required />
  </div>
<div class="form-example">
    <label for="cf">CF: </label>
    <input type="text" name="cf" id="cf" maxlength="16"/>
  </div>
   <div class="form-example">
    <label for="telefono">Tel: </label>
    <input type="text" name="telefono" id="telefono" maxlength="14"/>
  </div> 
  <div class="form-example">
    <input type="submit" name="submit" value="invia" />
  </div>

</form>

<script src="js/script.js"> </script>
</body>
</html>
