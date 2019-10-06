<?php
session_start();

if(empty($_SESSION["loggedin"]) && $_SESSION["loggedin"] === false){
    header("location: login.php");
    exit;
}

require_once "connection.php";

$destination = $subject = $message = "";
$destination_err = $subject_err = $message_err = "";

// Traite le formulaire
if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(empty(trim($_POST["destination"]))){
        $destination_err = "Entrez un destinataire";
    } else{
        $destination = trim($_POST["destination"]);
    }
    if(empty(trim($_POST["subject"]))){
        $subject_err = "Entrez un subject";
    } else{
        $subject = trim($_POST["subject"]);
    }
    if(empty(trim($_POST["message"]))){
        $message_err = "Entrez un message";
    } else{
        $message = trim($_POST["message"]);
    }

    if(empty($destination_err) && empty($subject_err) && empty($message_err)) {
        try{
            $sql = "SELECT id_login, login FROM Utilisateur";
            $stmt = $pdo->query($sql);
            $tabUser = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch (PDOException $e) {
            die("ERROR: Could not able to execute $sql. " . $e->getMessage());
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
                $stmt->execute([$_POST['subject'], $_POST['message'], date('d-m-Y h:i:s'), $_SESSION['id'], $idLogin]);
            }
            catch (PDOException $e) {
                die("ERROR: Could not able to execute $sql. " . $e->getMessage());
            }

            header("location: index.php");

        } else {
            $login_err = "Pas de compte trouvé avec ce destinataire ";
        }
    }
    else{
        echo "error";
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
                                    <textarea type="text" name="message" class="form-control"><?php echo $message; ?></textarea>
                                    <span class="help-block"><?php echo $message_err; ?></span>
                                </div>
                                <div class="form-group">
                                    <input type="submit" class="btn btn-primary" value="Envoyer">
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
