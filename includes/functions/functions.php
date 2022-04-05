<?php

    /*
    ** Get All Function v2.0
    ** Function To Get All Records From Any Database Table
    */

    function getAllFrom($field, $table, $orderfield, $where = null, $and = null, $ordering = "DESC")
    {
        global $con;

        $getAll = $con->prepare("SELECT $field FROM $table $where $and ORDER BY $orderfield $ordering");

        $getAll->execute();

        $all = $getAll->fetchAll();

        return $all;
    }
    
    /*
    ** Check If User Is Not Activated
    ** Function To Check The RegStatus Of The User
    */

    function checkUserStatus($user)
    {
        global $con;

        $stmtx = $con->prepare("SELECT 
									Username, RegStatus 
								FROM 
									users 
								WHERE 
									Username = ? 
								AND 
									RegStatus = 0");

        $stmtx->execute(array($user));

        $status = $stmtx->rowCount();

        return $status;
    }

    /*
    ** Check Items Function v1.0
    ** Function to Check Item In Database [ Function Accept Parameters ]
    ** $select = The Item To Select [ Example: user, item, category ]
    ** $from = The Table To Select From [ Example: users, items, categories ]
    ** $value = The Value Of Select [ Example: Osama, Box, Electronics ]
    */

    function checkItem($select, $from, $value)
    {
        global $con;

        $statement = $con->prepare("SELECT $select FROM $from WHERE $select = ?");

        $statement->execute(array($value));

        $count = $statement->rowCount();

        return $count;
    }
