<?php

    function isUserExist($userName, $ACCOUNT_TYPE){
        global $con;
        $count = 0;

        switch($ACCOUNT_TYPE){
            case "ADMIN":
                /* Some statement here */

                break;
            case "USER":
                /* For users */
                $stmtUser = $con->prepare("SELECT * FROM accounts WHERE userName=?");
                $stmtUser->bindParam(1,$userName);
                $stmtUser->execute();
                $count = $stmtUser->rowCount();

                break;
        }
        return $count > 0 ? false : true;
    }


    /**
     * verifyAccount.php library functions
     *  
     *  f isUserExist(string Username, string accountType) : bool 
     *      - returns true if the user is existing
     *  f 
     * 
     * 
     * 
     * 
     */
?>