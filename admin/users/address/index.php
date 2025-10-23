<?php

//obiettivi pagina:
// visualizzare tutti gli indirizzi per utente, implementando della paginazione
// eliminare creare duplicare modificare indirizzi
// facciamo creare la tabella da js e non da php
// modifica e creazione sono fatte in linea dentro la tabella (non aprono una nuova pagina)

//  $_GET["id_user"];

include("../../admin_session.php");
include("../../header.php");
if (isset($_GET["error"])) {
    echo '<div class="alert alert-success" role="alert">' . urldecode($_GET["error"]) . '  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button></div>';
}

require("../../../db/session.php");
?>

<body>
    <?php
    include("../../menu.php");
    ?>
    <div class="centrato">Indirizzi utente: <?= $_GET["id_user"] //TODO inserire nome utente
                                            ?> </div>
    <table id="tabella" class="centrato">
        <thead>
            <tr>
                <th>Via e civico</th>
                <th>citta(PROVINCIA)</th>
                <th>CAP</th>
                <th>Regione</th>
                <th>Paese</th>
                <th>Azioni</th>
            </tr>
        </thead>
        <tbody id="body_tabella">
        </tbody>


    </table>
    <div class="centrato">
        <div><button id="succ">pagina successiva</button></div>
        <div><button id="prec">pagina precedente</button></div>
        <div> pagina attuale <div id="pag">1</div>/<div id="pag_tot">0</div></button></div>
    </div>

</body>

<script>
    window.addEventListener("load", async () => {
        var pagina_attuale = 0
        bodyTabella = document.getElementById("body_tabella");

        async function loadData(n_pagina) {




            results = await fetch("<?= getenvterm("DOMAIN") ?>api/users/addresses.php?id_user=<?= $_GET["id_user"] ?>&page=" + n_pagina)

            risultato_json = await results.json()

            if (risultato_json.indirizzi.length == 0) {
                pagina_attuale = n_pagina - 1
                return
            }


            bodyTabella.innerHTML = "";
            risultato_json.indirizzi.forEach((indirizzo) => {

                let row = document.createElement("tr");
                let td_via_civico = document.createElement("td");
                let td_citta_prov = document.createElement("td");
                let td_cap = document.createElement("td");
                let td_reg = document.createElement("td");
                let td_state = document.createElement("td");
                let td_azioni = document.createElement("td");


                td_via_civico.innerText = indirizzo["street"] + " " + indirizzo["street_n"];
                row.appendChild(td_via_civico)

                td_citta_prov.innerText = indirizzo["city"] + " " + indirizzo["district"];
                row.appendChild(td_citta_prov)

                td_cap.innerText = indirizzo["zip"];
                row.appendChild(td_cap)

                td_reg.innerText = indirizzo["region"];
                row.appendChild(td_reg)

                td_state.innerText = indirizzo["state"];
                row.appendChild(td_state)

                row.appendChild(td_azioni)




                bodyTabella.appendChild(row)

            })

            document.getElementById("pag").innerText = n_pagina + 1
            document.getElementById("pag_tot").innerText = Math.ceil(risultato_json.tot / risultato_json.nrows)


        }

        loadData(pagina_attuale)


        document.getElementById("prec").addEventListener("click", () => {
            if (pagina_attuale - 1 < 0) {
                pagina_attuale = 0
                return
            } else {
                loadData(--pagina_attuale)
            }
        })
        document.getElementById("succ").addEventListener("click", () => {
            if (pagina_attuale + 1 <= 0) {
                return
            } else {
                loadData(++pagina_attuale)
            }
        })

    })
</script>

</html>