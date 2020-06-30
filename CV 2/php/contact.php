<?php

    $array = array("firstname" => "", "name" => "", "email" => "", "phone" => "", "message" => "", "firstnameRrror" => "", "nameError" => "", "emailError" => "", "phoneError" => "", "messageError" => "", "isSuccess" => "false");
        

    $emailTo = "mathisjancelii@gmail.com";




    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $array["firstname"] = verifyInput($_POST['firstname']);
        $array["name"] = verifyInput($_POST['name']);
        $array["email"] = verifyInput($_POST['email']);
        $array["phone"] = verifyInput($_POST['phone']);
        $array["message"] = verifyInput($_POST['message']);
        $array["isSuccess"] = true;
        $emailText ="";
        
        if(empty($array["firstname"]))
        {
            $array["firstnameError"] = "Quel est votre prénom ?";
            $array["isSuccess"] = false;
        }
        else
        {
            $emailText .= "firstname: {$array["firstname"]}\n";
        }
        if(empty($array["name"]))
        {
            $array["nameError"] = "Quel est votre nom ?";
            $array["isSuccess"] = false;
        }
        else
        {
            $emailText .= "name: {$array["name"]}\n";
        }
        
        if(!isEmail($array["email"]))
        {
            $array["emailError"] = "Veuillez saisir un email valide.";
            $array["isSuccess"] = false;
        }
        else
        {
            $emailText .= "email: {$array["email"]}\n";
        }
        if(!isPhone($array["phone"]))
        {
            $array["phoneError"] = "Veuillez utilisez les chiffres ou la touche espace";
            $array["isSuccess"] = false;
        }
        else
        {
            $emailText .= "phone: {$array["phone"]}\n";
        }
        if(empty($array["message"]))
        {
            $array["messageError"] = "Quel message souhaitez-vous me communiquer ?";
            $array["isSuccess"] = false;
        }
        else
        {
            $emailText .= "message: {$array["message"]}\n";
        }
        if($array["isSuccess"])
        {
            $headers = "From: {$array["firstname"]} {$array["name"]} <{$array["email"]}>\r\nReply-To: {$array["email"]}";
            mail($emailTo, "Un message de votre site", $emailText , $headers);
             
            
        }
        
        echo json_encode($array);
    }

    function isPhone($var)
        
    {
        return preg_match("/^[0-9 ]*$/", $var);
    }

    function isEmail($var)
    {
        return filter_var($var, FILTER_VALIDATE_EMAIL);
    }

    function verifyInput($var)
    {
        $var = trim($var);
        $var = stripslashes ($var);
        $var = htmlspecialchars($var);
        
        return $var;
    }





?>