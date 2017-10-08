<?php

namespace model\repositories;

require_once('vendor/autoload.php');

use \PDO;
use PDOException;
use model\interfaces\IActionRepository;
use model\Action;

class ActionRepository implements IActionRepository {
    
    private $connection = null;

    public function __construct( PDO $connection ) {
        $this->connection = $connection;
    }

    public function findAll() {
        try {
            $statement = $this->connection->prepare( 'SELECT * FROM actions' );
            $statement->execute();
            $rows = $statement->fetchAll( PDO::FETCH_ASSOC );

            $actions = array();
            if ( count( $row ) > 0 ) {

                for ( $i = 0; $i < count( $rows ); $i++ ) {
                    $actions[$i] = new Action( $rows[$i]['id'], $rows[$i]['action'], $rows[$i]['date'] );
                } 
            }
            return $actions;
        } catch ( PDOException $e ) {
            throw new Exception( 'Caught exception: ' . $e->getMessage() );
        } finally {
            $connection = null;
        }
    }

    public function find( $id ) {
        try {
            $statement = $this->connection->prepare( 'SELECT * FROM actions WHERE id = :id' );
            $statement->setFetchMode( PDO::FETCH_ASSOC );
            $statement->bindParam( ':id', $id, PDO::PARAM_INT );
            $statement->execute();
            $row = $statement->fetch();

            if ( count( $row ) > 0 ) {
                return new Action( $row[0]['id'], $row[0]['action'], $row[0]['date'] );
            } else {
                return null;
            }
        } catch ( PDOException $e ) {
            throw new Exception( 'Caught exception: ' . $e->getMessage() );
        } finally {
            $connection = null;
        }
    }

    public function create( $action, $date ) {
        try {
            $statement = $this->connection->prepare( 'INSERT INTO actions (action, date) VALUES (:action, :date)' );
            $statement->bindParam( ':action', $action, PDO::PARAM_STR );
            $statement->bindParam( ':date', $date, PDO::PARAM_STR );
            $statement->execute();
        } catch ( PDOException $e ) {
            throw new Exception( 'Caught exception: ' . $e->getMessage() );
        } finally {
            $pdo = null;
        }
    }

    public function update( $id, $action, $date ) {
        
    }

    public function delete( $id ) {
        try{
            $statement = $this->connection->prepare( 'DELETE FROM actions WHERE id = :id ' );
            $statement->setFetchMode( PDO::FETCH_ASSOC );
            $statement->bindParam( ':id', $id, PDO::PARAM_INT );
            $statement->execute();
        } catch ( PDOException $e ) {
            throw new Exception( 'Caught exception: ' . $e->getMessage() );
        } finally {
            $connection = null;
        }
    }
}