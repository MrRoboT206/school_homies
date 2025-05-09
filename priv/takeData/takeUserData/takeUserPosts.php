<?php
class FakeMysqliResult {
    private $data;
    public $num_rows;  // Proprietà pubblica per il numero di righe
    private $index = 0;

    public function __construct($data) {
        $this->data = $data;
        $this->num_rows = count($data);  // Calcola il numero di righe e lo salva come proprietà
    }

    public function fetch_assoc() {
        if ($this->index < count($this->data)) {
            return $this->data[$this->index++];
        }
        return null;
    }
}


$stmtPosts = $conn->prepare("SELECT id_post, type_post, date, title, description, date_event, image_path FROM posts WHERE id_user = ?");
$stmtPosts->bind_param("i", $id_user);
$stmtPosts->execute();
$result = $stmtPosts->get_result(); // Otteniamo l'oggetto mysqli_result

$resultPostsArray = []; // Creiamo un array per salvare i risultati

while ($row = $result->fetch_assoc()) {
    $row['id_user'] = $id_user;
    $row['name'] = $userInfoResult['name']; // Aggiungiamo il campo "name"
    $resultPostsArray[] = $row; // Inseriamo la riga modificata nell'array
}

$resultPosts = new FakeMysqliResult($resultPostsArray); // Creiamo un oggetto FakeMysqliResult

// Chiudere lo statement
$stmtPosts->close();