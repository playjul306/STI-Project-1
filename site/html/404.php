<?php
session_start();

include_once ('includes/header.inc.php')
?>
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- 404 Error Text -->
        <div class="text-center">
            <div class="error mx-auto" data-text="404">404</div>
            <p class="lead text-gray-800 mb-5">Page introuvable</p>
            <p class="text-gray-500 mb-0">Il s'avère que vous avez découvert une erreur dans la matrice...</p>
            <a href="index.php">&larr; Retour à la boite de messages</a>
        </div>

    </div>
    <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->

<?php
include_once('includes/footer.inc.php');
?>