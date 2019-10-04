<?php
session_start();

if(empty($_SESSION["loggedin"]) && $_SESSION["loggedin"] === false){
    header("location: login.php");
    exit;
}

require_once "connection.php";

include_once('includes/header.inc.php');

$sql = "SELECT Message.date, Utilisateur.login, Message.sujet, Message.corps FROM Message INNER JOIN Utilisateur
            ON Message.recepteur = Utilisateur.id_login WHERE Message.id_Message = " . $_GET["id"];

$stmt = $pdo->query($sql);
$result = $stmt->fetch(PDO::FETCH_OBJ);
?>

<?php
if(!empty($result)) {
    $rowArray = array("Date de réception:","Expéditeur:","Sujet:","Message:");
    $sqlRow = array("date", "login", "sujet", "corps");

    $valueArray = array();
    $cpt = 0;
    for ($i = 0; $i < count($sqlRow); $i++){
        array_push($valueArray, $result->$sqlRow[$cpt++]);
    }

    echo '<div class="container-fluid" >';
    for ($i = 0; $i < count($rowArray); $i++) {
        $sizeOfBloc = $i > 1 ? 9 : 3;
                echo'<div class="col-lg-' . $sizeOfBloc .'">
                    <div class="card shadow mb-4" >
                        <div class="card-header py-3" >
                            <h6 class="m-0 font-weight-bold text-primary" >' . $rowArray[$i] . '</h6 >
                        </div >
                    <div class="card-body" >' . $valueArray[$i] . '</div >
                </div>
              </div >';
    }
    echo '</div >';
}
else{
    echo '<div class="container-fluid" >
            <div class="col-lg-3" >
                <div class="card shadow mb-4" >
                    <div class="card-header py-3" >
                        <h6 class="m-0 font-weight-bold text-primary" > Erreur:</h6 >
                    </div >
                    <div class="card-body" >Aucun mail à afficher</div >
                </div >
            </div >
        </div>';
}

echo '<a href="index.php" class="btn btn-primary btn-user btn-block">Retour</a>';

include_once('includes/footer.inc.php');
?>