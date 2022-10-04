<?php
// This file contains a bridge between the view and the model and redirects back to the proper page
// with after processing whatever form this code absorbs. This is the C in MVC, the Controller.
//
// Authors: Rick Mercer and Matthew Ricci
//  
session_start (); // Not needed until a future iteration

require_once './DatabaseAdaptor.php';

$theDBA = new DatabaseAdaptor();

if (isset($_GET ['todo']) && $_GET ['todo'] === 'getQuotes') {
    //Simply get the quotes
    $arr = $theDBA->getAllQuotations();
    unset($_GET ['todo']);
    echo getQuotesAsHTML ($arr);
} else if (isset($_POST['author']) || isset($_POST['quote'])) {
    //We know they submitted a quote
    $quote = $_POST['quote'];
    $author = $_POST['author'];
    $theDBA->addQuote($quote, $author);
    header("Location: view.php");
} else if (isset($_POST['update'])) {
    $ID = $_POST['hidden'];
    $clickedName = $_POST['update'];
    
    if ($clickedName === 'increase') {
        $theDBA->raiseRating($ID);
    } else if ($clickedName === 'decrease') {
        $theDBA->lowerRating($ID); 
    } else if ($clickedName === 'delete') {
        $theDBA->deleteQuote($ID); 
    }
    header("Location: view.php");
} else if (isset($_POST['username']) && isset($_POST['password'])) {
    if (isset($_POST['register'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $allUsers = $theDBA->getAllUsers();
        $foundUser = false;
        foreach($allUsers as $userEntries) {
            foreach($userEntries as $user) {
                if ($username == $user) {
                    $foundUser = true;
                    break;
                }
            }
            
        }
        if (!$foundUser) { 
            $theDBA->addUser($username, $password);
            header("Location: view.php");
        } else { 
            $_SESSION['accountNameTaken'] = 'That username is already taken.';
            header("Location: register.php"); 
        }
    } else if (isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        if ($theDBA->verifyCredentials($username, $password)) {
            $_SESSION['user'] = $username;
            header("Location: view.php");
        } else {
            $_SESSION['loginError'] = 'Invalid Username or Password';   
            header("Location: login.php");   
        }
    }
}

function getQuotesAsHTML($arr) {
    $result = '';
    foreach ($arr as $quote) {
        $result .= '<div class="container">';
        $result .= '"' . $quote['quote'] . '"<br>';
        $result .= '<p class="author">&nbsp;&nbsp;--' . $quote['author'] . '<br></p>';
        $result .= '<form action="controller.php" method="post"><input type="hidden" name="hidden" value="' . $quote["id"] . '"/>&nbsp;&nbsp;&nbsp;' .
        '<button name="update" value="increase">+</button>' .
        '&nbsp;<span id="rating">' . $quote['rating'] . '</span>&nbsp;&nbsp;' .
        '<button name="update" value="decrease">-</button>&nbsp;&nbsp;' .
        '<button name="update" value="delete">Delete</button>' .
        '</form>';
        $result .= '</div>';
    }
    
    return $result;
}
?>