<?php
session_start();

      
    if (isset($_POST['submit2'],$_POST['mail'])) {
        if(!empty($_POST['mail'])){
            $mail=htmlspecialchars($_POST('mail'));
            if(filter_var($mail,FILTER_VALIDATE_EMAIL)){
                $mailexist= $bdd -> prepare('SELECT id FROM membres WHERE mail= ?');
                $mailexist->execute(array($mail));
                $mailexist=$mailexist->rowCount();
                if($mailexist==1){
                    $_SESSION['mail']=$mail;
                    $code="";
                    for($i=0; $i<8 ; $i++){
                      $code .= mt_rand(0,9);
                    }
                    $_SESSION['code']=$code;
                    $mail_recup=$bdd->prepare('SELECT id FROM access WHERE mail=?');
                    if ($mail_recup=1){
                        $recup_insert=$bdd->prepare('UPDATE access SET code=? WHERE mail=?');
                        $recup_insert->execute(array($code,$mail));
                    }else{
                        $recup_insert=$bdd->prepare('INSERT INTO access(mail,code)VALUES(?,?)');
                        $recup_insert->execute(array($mail,$code));
                    }
                }else{
                    $error="Cette adresse mail n'existe pas";
                }
            } else{
                $error="Adresse mail introuvable";
            }
        }else {
            $error= "Veuillez entrer votre mail";
        }
    }

require_once('views/recuperation.php')



?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width" , initial-scale 1.0>
    <meta http-equiv="X-UA-compatible" content="edge">
    <title>Professeur Kode</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
        integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/eb7f2f8a0a.js" crossorigin="anonymous"></script>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="stylesheet/style.css">
    <link rel="stylesheet" href="stylesheet/register.css">
</head>

<body>
    <div id="registration">
        <h2>Recevoir mon mot de pass</h2>
        <form id="ForgotPassForm" action="" method="post">
            <fieldset>
                <input type="email" placeholder="Votre mail" name="mail" value="" />
                <input type="submit" name="submit2" value="Valider" />

        </form>
        <?php if(isset($error)){echo'<span style= color:red"'.$error.'</span>';}else{echo"<br />";}?>
    </div>
    </div>
</body>

</html>