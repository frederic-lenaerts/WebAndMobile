<?php

namespace model\repositories;

use \PDO;
use PDOException;

class ActionRepository implements IActionRepository {
    
    private $connection = null;

    public function __construct( PDO $connection ) {
        $this->connection = $connection;
    }

    public function getActionById( $id ) {
        try {
            $statement = $this->connection->prepare( 'SELECT * FROM actions WHERE id = :id' );
            $statement->setFetchMode( PDO::FETCH_ASSOC );
            $statement->bindParam( ':id', $id, PDO::PARAM_INT );
            $statement->execute();
            $row = $statement->fetch();
            if ( count($row) > 0 ) {
                return new Action( $row[0]['id'], $row[0]['action'], $row[0]['date'] );
            } else {
                return null;
            }
        } catch ( PDOException $e ) {
            return null;    
        } finally {
            $connection = null;
        }
    }
}