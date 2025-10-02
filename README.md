query sql:
- create = INSERT INTO [nometabella](campi da inserire separati da virgola) VALUES (valori dei campi separati da virgola in ordine di apparizione)
- update= UPDATE [nometabella] SET [campo=nuovovalore] WHERE [condizioni campo=valore che limitano la query solo a determinati record]
- delete= DELETE FROM [tabella]  WHERE [condizioni campo=valore che limitano la query solo a determinati record]
- select = SELECT [campi o tutti i campi con *] FROM [nometabella] WHERE [condizioni campo=valore che limitano la query solo a determinati record]

dove facciamo la query (la tabella) e' identificata dalla clausola "FROM [nametabella]" 

le query possono e devono in certi casi essere eseguite solo su alcuni campi che andiamo ad identificare con la clausola "WHERE [campo=valore da uguagliare]"


pensato a un problema
ci siamo dati una soluzione
abbiamo creato dei workflow per applicare la soluzione
abbiamo creato un diagramma ER che specifica il db applicare la soluzione
abbiamo creato il db con query sql rispettando il diagramma ER
abbiamo delle API basiche che rispettano il CRUD (create read update delete)