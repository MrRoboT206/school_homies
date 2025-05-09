<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuovo Post</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            height: 100vh;
        }

        .btn-primary {
            padding: 10px 20px;
            font-size: 18px;
            border-radius: 10px;
            transition: background 0.3s ease;
        }

        .btn-primary:hover {
            background: #0056b3;
        }

        .modal-content {
            border-radius: 20px;
        }
    </style>
</head>

<body>
    <div class="modal fade" id="postModal" tabindex="-1" aria-labelledby="postModalLabel" aria-hidden="true" style="border-radius: 20px;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="postModalLabel">Crea un nuovo post</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="../../priv/gestionePost/addPost.php" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="title">Titolo</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Inserisci il titolo" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Descrizione</label>
                            <textarea class="form-control" id="description" name="description" rows="4" placeholder="Scrivi la descrizione..." required></textarea>
                        </div>

                        <!-- Selezione del tipo di post -->
                        <div class="form-group">
                            <label for="type_post">Tipo di post</label>
                            <select class="form-control" id="type_post" name="type_post" onchange="changePostFields()" required>
                                <option value="1">Post testuale</option>
                                <option value="2">Post evento</option>
                                <option value="3">Post appunti</option>
                                <option value="4">Post richiesta</option>
                            </select>
                        </div>

                        <!-- Sezione che cambia dinamicamente in base al tipo di post -->
                        <div id="extraFields"></div>
                        <div class="form-group" id="imgDiv" style="display: none;">
                            <label for="file_attachment">Allega file</label>
                            <input type="file" class="form-control-file" id="file_attachment" name="file_attachment">
                        </div>

                        <button type="submit" class="btn btn-primary">Aggiungi post</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Funzione che cambia dinamicamente i campi in base al tipo di post
        function changePostFields() {
            var typePost = document.getElementById("type_post").value;
            var extraFields = document.getElementById("extraFields");

            // Reset dei campi extra
            extraFields.innerHTML = "";

            if (typePost == "2") {
                // Aggiungi campi per Tipo 2
                document.getElementById("imgDiv").style.display = "none";
                extraFields.innerHTML = `
                <div class="form-group">
                <label for="date_event">data evento</label>
                <input type="datetime-local" id="date_event" name="date_event" required>
                </div>
                `;
            } else if (typePost == "3") {
                // cambia il display per il div imgDiv
                document.getElementById("imgDiv").style.display = "block";
                
            } else if (typePost == "4") {
                // Aggiungi campi per Tipo 4
                document.getElementById("imgDiv").style.display = "none";
                extraFields.innerHTML = `
                <div class="form-group">
                <label for="extra_field_4">Campo Extra per Tipo 4</label>
                <input type="text" class="form-control" id="extra_field_4" name="extra_field_4" placeholder="Campo per Tipo 4">
            </div>
            <div class="form-group">
                <label for="extra_field_5">Campo Extra Aggiuntivo per Tipo 4</label>
                <textarea class="form-control" id="extra_field_5" name="extra_field_5" rows="4" placeholder="Campo Aggiuntivo per Tipo 4"></textarea>
            </div>
        `;
            }else {
                // Per gli altri tipi di post
                document.getElementById("imgDiv").style.display = "none";
            }
        }

        // Esegui subito il cambio dei campi per il tipo di post selezionato inizialmente
        changePostFields();
    </script>

</body>

</html>