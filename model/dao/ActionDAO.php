<?php

namespace model\dao;

require_once('vendor/autoload.php');

use \PDO;
use PDOException;
use model\Action;
use model\interfaces\IActionDAO;
use config\DependencyInjector;

class ActionDAO implements IActionDAO {

    public function __construct( PDO $connection = null ) {
        if ( !isset( $connection ) )
            $connection = DependancyInjector::getContainer()['pdo'];

        $this->connection = $connection;
    }

    public function findAll() {
        try {
            $statement = $this->connection->prepare( 'SELECT * FROM actions' );
            $statement->execute();
            $rows = $statement->fetchAll( PDO::FETCH_ASSOC );

            $actions = array();
            for ( $i = 0; $i < count( $rows ); $i++ ) {
                $actions[$i] = Action::deserialize( $rows[ $i ]);
            } 
            return $actions;
        } catch ( PDOException $e ) {
            throw new Exception( 'Caught exception: ' . $e->getMessage() );
        } finally {
            $this->connection = null;
        }
    }

    public function find( $id ) {
        try {
            $statement = $this->connection->prepare( 'SELECT * FROM actions WHERE id = :id' );
            $statement->setFetchMode( PDO::FETCH_ASSOC );
            $statement->bindParam( ':id', $id, PDO::PARAM_INT );
            $statement->execute();
            $row = $statement->fetchAll();

            if ( count( $row ) > 0 ) {
                return Action::deserialize( $row[0] );
            } else {
                return null;
            }
        } catch ( PDOException $e ) {
            throw new Exception( 'Caught exception: ' . $e->getMessage() );
        } finally {
            $this->connection = null;
        }
    }

    public function create( $action ) {
        try {
            $statement = $this->connection->prepare( 'INSERT INTO actions (action, date) VALUES (:action, :date)' );
            $statement->bindParam( ':action', $action->action, PDO::PARAM_STR );
            $statement->bindParam( ':date', $action->date, PDO::PARAM_STR );
            $success = $statement->execute();

            if ( $success ) {
                $id = $this->connection->lastInsertId();
                $action->setId( $id );
                return $action;
            }
            return null;
        } catch ( PDOException $e ) {
            throw new Exception( 'Caught exception: ' . $e->getMessage() );
        } finally {
            $this->connection = null;
        }
    }

    /*
    public function update( $id, $action, $date ) {
        
    }

    public function delete( $id ) {
        try {
            $statement = $this->connection->prepare( 'DELETE FROM actions WHERE id = :id ' );
            $statement->setFetchMode( PDO::FETCH_ASSOC );
            $statement->bindParam( ':id', $id, PDO::PARAM_INT );
            $statement->execute();
        } catch ( PDOException $e ) {
            throw new Exception( 'Caught exception: ' . $e->getMessage() );
        } finally {
            $this->connection = null;
        }
    }
    */
}