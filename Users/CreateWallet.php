<?php


require('../bd/connexionDB.php'); 

if($argv[1] == "create" && $argv[2] == "wallet") {

    if(isset($argv[3])) {


        if (preg_match("/^[a-z0-9\-_.]+@[a-z]+\.[a-z]{2,3}$/i", $argv[3])) {


            if(isset($argv[4])) {


                if(isset($argv[5])) {

                    $password = hash("sha256", $argv[4]);
                    $confirmPassword = hash("sha256", $argv[5]);

                    if($password == $confirmPassword) {

                        if (!file_exists('Users/' . $argv[3] . '.json')) {

                            $constructKey = $argv[3] . $password;
                        
                            $privateKey =  hash("sha256", $constructKey);
                        
                            $publicKey =  hash("sha256", $privateKey);
                        
                        
                        
                            $DB->insert("INSERT INTO users (email, password, privateKey, publicKey) VALUES 
                                (?, ?, ?, ?)", 
                                array($argv[3], $password, "KEY@" . $privateKey, "WALLET@" . $publicKey)
                            );
                        
                        
                        } else {
                        
                            echo "existing wallet";
                        
                        }

                    } else {

                        echo "passwords do not match";
                         
                    }


                } else {
    
                    echo "a password confirmation must be defined";
    
                }  


            } else {

                echo "you must define a password";

            }


        } else {

            echo "your email address is not in the right format";

        }


    } else {

        echo "Missing value";

    }

}