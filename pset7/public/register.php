<?php

    // configuration
    require("../includes/config.php");

    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // else render form
        render("register_form.php", ["title" => "Register"]);
    }

    // else if user reached page via POST (as by submitting a form via POST)
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // validate submission
        if (empty($_POST["username"]))
        {
            apologize("You must provide your username.");
        }
        
        else if (($_POST["password"]) != ($_POST["confirmation"]))
        {
            apologize("Passwords do not match.");
        }
        
        else if (empty($_POST["password"]))
        {
            apologize("You must provide your password.");
        }
        
        else
        {
            
    		// If the username already exists, an error message is displayed
    		if(cs50::query("INSERT INTO users (username, hash, cash) VALUES(?, ?, 10000.00)", $_POST["username"], crypt($_POST["password"])) === false)
    		{
    			apologize('Username already exists');
    		}
    		
    		else
    		{
    			// insert the new user into the database
    			$rows = cs50::query("SELECT LAST_INSERT_ID() AS id");
    			$id = $rows[0]["id"];
    			$_SESSION["id"] = $id; 
    			redirect("index.php");
    		}
        }
        
        
    }

?>
