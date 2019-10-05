<?php

session_start();

if(empty($_SESSION["loggedin"]) && $_SESSION["loggedin"] === false){
    header("location: login.php");
    exit;
}
if (isset($_SESSION["isNotAdmin"]) && $_SESSION["isNotAdmin"] === 1){
    header("location: index.php");
    exit;
}
require_once("connection.php");

$type = "ajout";

if (isset($_GET['edit_id_login'])) {
    $idLoginToEdit = $_GET['edit_id_login'];
    $strSQLRequest = "SELECT id_login, login, valide, nom_role, Utilisateur.id_role FROM Utilisateur
            INNER JOIN Role ON Utilisateur.id_role = Role.id_role
            WHERE id_login LIKE '".$_GET['edit_id_login']."'";
    $stmt = $pdo->query($strSQLRequest);
    $userToEdit = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
}

if(isset($_POST['edit'])){
    if (isset($_POST['id_login'])){
        try {
            if (isset($_POST['password'])) {
                $hashPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
                $strSQLRequest = "UPDATE Utilisateur SET login = ?, password = ?, valide = ?, id_role = ? WHERE id_login = ?";
                $stmt = $pdo->prepare($strSQLRequest);
                $stmt->execute([$_POST['login'], $hashPassword, $_POST['valide'], $_POST['Role'], $_POST['id_login']]);
            } else {
                $strSQLRequest = "UPDATE Utilisateur SET login = ?, valide = ?, id_role = ? WHERE id_login = ?";
                $stmt = $pdo->prepare($strSQLRequest);
                $stmt->execute([$_POST['login'], $_POST['valide'], $_POST['Role'], $_POST['id_login']]);
            }
        } catch (PDOException $e) {
            header("Location: 404.php");
            echo $strSQLRequest;
            die("ERROR: Could not able to execute $strSQLRequest. " . $e->getMessage());
        }
        header("Location: admin.php");
    } else {
        header("Location: 404.php");
    }
}

if(isset($_POST['add'])){
    try {
        $hashPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $strSQLRequest ="INSERT INTO Utilisateur (login, password, valide, id_role) VALUES (?,?,?,?)";
        $stmt= $pdo->prepare($strSQLRequest);
        $stmt->execute([$_POST['login'], $hashPassword, $_POST['valide'], $_POST['Role']]);
        header("Location: admin.php");
    } catch(PDOException $e){
        header("Location: 404.php");
        echo $strSQLRequest;
        die("ERROR: Could not able to execute $strSQLRequest. " . $e->getMessage());
    }
}

include_once('includes/header.inc.php');
?>

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="p-5">

                    <?php
                        if (isset($userToEdit['login'])) {
                            echo "<div class='text-center'>";
                            echo "<h1 class='h4 text-gray-900 mb-4'>Modification de l'utilisateur </h1>";
                            echo "</div>";
                            echo "<form method='post' action='admin-addUser.php' class='user'>
                                <div class='form-group row'>
                                    <div class='col-sm-6 mb-3 mb-sm-0'>
                                        <input type='hidden' name='id_login' value='".$userToEdit['id_login']."'> 
                                        <input type='text' class='form-control form-control-user' placeholder='Login' name='login' value='".$userToEdit['login']."'>
                                    </div>
                                    <div class='col-sm-2'>
                                        <label class='text-lg'> choisir un rôle :</label>
                                    </div>
                                    <div class='col-sm-4'>
                                        <select name='Role' class='form-control form-control-user'>";
                                            $strSQLRequest = "SELECT id_role, nom_role FROM Role ORDER BY nom_role";
                                            $stmt = $pdo->query($strSQLRequest);
                                            $tabRoles = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                            $stmt->closeCursor();
                                            foreach ($tabRoles as $role){
                                                echo '<option value="'.$role['id_role'].'"';
                                                if ($userToEdit['id_role'] == $role['id_role']){
                                                    echo 'selected = "selected"';
                                                }
                                                echo '>'.$role['nom_role'].'</option>';
                                            }
                                        echo "</select>
                                    </div>
                                </div>
                                <div class='form-group'>
                                <div class='col-sm-2'>
                                        <label class='text-lg'> Activité du compte :</label>
                                    </div>
                                    <div class='col-sm-4'>
                                        <select name='valide' class='form-control form-control-user'>
                                        <option value='1'";
                                            if ($userToEdit['valide'] === "1"){
                                                echo "selected = 'selected'";
                                            }
                                            echo "> Compte activé</option>
                                        <option value='0'";
                                            if ($userToEdit['valide'] === "0"){
                                                echo "selected = 'selected'";
                                            }
                                            echo "> Compte désactivé</option>";

                                        echo "</select>
                                    </div>
                                </div>
                                <div class='form-group row'>
                                    <div class='col-sm-12 mb-3 mb-sm-0'>
                                        <input type='password' class='form-control form-control-user' placeholder='Changer le mot de passe ?' name='password'>
                                    </div>
                                </div>
        
                                <input type='submit' name='edit' class='btn btn-primary btn-user btn-block' value='Modifier'>
        
                            </form>";
                        } else {
                            echo "<div class='text-center'>";
                            echo "<h1 class='h4 text-gray-900 mb-4'>Ajout d'utilisateur</h1>";
                            echo "</div>";
                            echo "<form method='post' action='admin-addUser.php' class='user' >
                                <div class='form-group row'>
                                    <div class='col-sm-6 mb-3 mb-sm-0'>
                                        <input type='text' class='form-control form-control-user' placeholder='Login' name='login'>
                                    </div>
                                    <div class='col-sm-2'>
                                        <label class='text-lg'> choisir un rôle :</label>
                                    </div>
                                    <div class='col-sm-4'>
                                        <select name='Role' class='form-control form-control-user'>";
                                            $strSQLRequest = "SELECT id_role, nom_role FROM Role ORDER BY nom_role";
                                            $stmt = $pdo->query($strSQLRequest);
                                            $tabRoles = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                            $stmt->closeCursor();
                                            foreach ($tabRoles as $role){
                                                echo "<option value='".$role['id_role']."'>".$role['nom_role']."</option>";
                                            }
                                        echo "</select>
                                    </div>
                                </div>
                                <div class='form-group'>
                                <div class='col-sm-2'>
                                        <label class='text-lg'> Activité du compte :</label>
                                    </div>
                                    <div class='col-sm-4'>
                                        <select name='valide' class='form-control form-control-user'>
                                            <option value='1'> Compte activé</option>
                                            <option value='0'> Compte désactivé</option>
                                        </select>
                                    </div>
                                </div>
                                <div class='form-group row'>
                                    <div class='col-sm-12 mb-3 mb-sm-0'>
                                        <input type='password' class='form-control form-control-user' placeholder='Mot de passe'>
                                    </div>
                                </div>
        
                                <input type='submit' name='add' class='btn btn-primary btn-user btn-block' value='Ajouter'>
        
                            </form>";
                        }

                    ?>

                </div>
            </div>


        </div>
    <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<?php
include_once('includes/footer.inc.php');
?>



