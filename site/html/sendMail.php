<?php
session_start();

if(empty($_SESSION["loggedin"]) && $_SESSION["loggedin"] === false){
    header("location: login.php");
    exit;
}

require_once "connection.php";

$destination = $subject = $message = "";

if(isset($_GET['id'])){
    try{
        $sql = "SELECT Utilisateur.login, Message.date, Message.sujet, Message.corps FROM Message INNER JOIN Utilisateur
            ON Message.expediteur = Utilisateur.id_login WHERE Message.id_message = " . $_GET["id"];
        $stmt = $pdo->query($sql);
        $user = $stmt->fetch(PDO::FETCH_OBJ);
        $destination = $user->login;
        $subject = "Re: " . $user->sujet;
        $message = "\r\n\r\n\r\n---------------------------->Réponse au mail ci-dessous\r\n\r\nEnvoyé le: " . $user->date
            . " \r\nSujet: " . $user->sujet . " \r\n\r\n" . $user->corps;

    } catch (PDOException $e) {
        header("Location: 404.php");
        die("ERREUR: " . $e->getMessage());
    }
}


$destination_err = $subject_err = $message_err = "";

// Traite le formulaire
if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(empty(trim($_POST["destination"]))){
        $destination_err = "Entrez un destinataire";
    } else{
        $destination = $_POST["destination"];
    }
    if(empty(trim($_POST["subject"]))){
        $subject_err = "Entrez un subject";
    } else{
        $subject = ($_POST["subject"]);
    }
    if(empty(trim($_POST["message"]))){
        $message_err = "Entrez un message";
    } else{
        $message = $_POST["message"];
    }

    if(empty($destination_err) && empty($subject_err) && empty($message_err)) {
        try{
            $sql = "SELECT id_login, login FROM Utilisateur";
            $stmt = $pdo->query($sql);
            $tabUser = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            header("Location: 404.php");
            die("ERREUR: " . $e->getMessage());
        }

        $founded = 0;
        foreach($tabUser as $user){
            if($user['login'] === $destination){
                $founded = 1;
                $idLogin = $user['id_login'];
                break;
            }
        }

        if ($founded) {
            try{
                $sql = "INSERT INTO Message (sujet, corps, date, expediteur, recepteur) VALUES (?,?,?,?,?)";
                $stmt= $pdo->prepare($sql);
                date_default_timezone_set('Europe/Zurich');
                $stmt->execute([$subject, $message, date('d-m-Y H:i:s'), $_SESSION['id'], $idLogin]);
            } catch (PDOException $e) {
                header("Location: 404.php");
                die("ERREUR: " . $e->getMessage());
            }

            header("location: index.php");

        } else {
            $destination_err = "Pas de compte trouvé avec ce destinataire ";
        }
    }
}

include_once('includes/header.inc.php');

?>


<div class="container-fluid">
    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Formulaire d'envoi</h1>
                        </div>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <div class="form-group <?php echo (!empty($destination_err)) ? 'has-error' : ''; ?>">
                                <div class="form-group <?php echo (!empty($destination_err)) ? 'has-error' : ''; ?>">
                                    <label>Destinataire</label>
                                    <input type="text" name="destination" class="form-control" value="<?php echo $destination; ?>">
                                    <span class="help-block"><?php echo $destination_err; ?></span>
                                </div>
                                <div class="form-group <?php echo (!empty($subject_err)) ? 'has-error' : ''; ?>">
                                    <label>Sujet</label>
                                    <input type="text" name="subject" class="form-control" value="<?php echo $subject; ?>">
                                    <span class="help-block"><?php echo $subject_err; ?></span>
                                </div>
                                <div class="form-group <?php echo (!empty($message_err)) ? 'has-error' : ''; ?>">
                                    <label>Message</label>
                                    <pre><textarea type="text" name="message" rows="15" class="form-control"><?php echo $message; ?></textarea></pre>
                                    <span class="help-block"><?php echo $message_err; ?></span>
                                </div>
                                <div class="form-group">
                                    <input type="submit" class="btn btn-primary btn-user btn-block" value="Envoyer">
                                </div>
                            </div>
                        </form>

                    </div>
        </div>
    </div>
</div>

</div>
<!-- End of Main Content -->

<?php
include_once('includes/footer.inc.php');
?>
