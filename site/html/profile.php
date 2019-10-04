<?php
session_start();

if(empty($_SESSION["loggedin"]) && $_SESSION["loggedin"] === false){
    header("location: login.php");
    exit;
}

require_once ("connection.php");
if (isset($_POST['password'])) {
    try {
        $hashPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $strSQLRequest = "UPDATE Utilisateur SET password = ?WHERE id_login = ?";
        $stmt = $pdo->prepare($strSQLRequest);
        $stmt->execute([$hashPassword, $_SESSION["id"]]);
    } catch (PDOException $e){
        header("Location: 404.php");
        echo $strSQLRequest;
        die("ERROR: Could not able to execute $strSQLRequest. " . $e->getMessage());
    }
}

include_once('includes/header.inc.php');
?>
        <!-- Begin Page Content -->
        <div class="container-fluid">

            <div class="form-group row">
                <div class="col-lg-6">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Login :</h6>
                        </div>
                        <div class="card-body"> <?php echo $_SESSION["login"]; ?> </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Rôle :</h6>
                        </div>
                        <div class="card-body"> <?php echo $_SESSION["role"]; ?> </div>
                    </div>
                </div>
            </div>
            <form class="user" method='post' action='profile.php'>
                <div class="form-group row">
                    <div class="col-lg-9">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Changer de mot de passe :</h6>
                            </div>
                            <div class="card-body">
                                <input type="password" name="password" class="form-control form-control-user" placeholder="Mot de passe">
                            </div>
                        </div>
                    </div>
                </div>
                <input type='submit' name='edit' class='btn btn-primary btn-user btn-block' value='Modifier'>
                <?php
                    if (isset($_POST["edit"])) {
                        echo "<div class=\"col-lg-6\">
                                <div class=\"card shadow mb-4\">
                                    <div class=\"card-header py-3\">
                                        <h6 class='m-0 font-weight-bold text-primary'>Votre mot de passe a été changé</h6>
                                    </div>
                                </div>
                            </div>";
                    }
                ?>
            </form>

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->


<?php
include_once('includes/footer.inc.php');
?>