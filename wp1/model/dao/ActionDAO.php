<?php

namespace model\dao;

use \PDO;
use PDOException;
use model\factories\ActionFactory;
use model\interfaces\dao\IActionDAO;
use config\DependencyInjector;

class ActionDAO implements IActionDAO {

    public function __construct( PDO $connection = null ) {
        if ( !isset( $connection ) )
            $connection = DependancyInjector::getContainer()['pdo'];

        $this->connection = $connection;
    }

    public function findAll() {
        $query = function() {
            $statement = $this->connection->prepare( 
                'SELECT * 
                FROM actions' 
            );
            $statement->setFetchMode( PDO::FETCH_ASSOC );
            $statement->execute();
            return $statement->fetchAll();
        };

        $rows = $this->tryToExecute( $query() );

        $actions = array();
        for ( $i = 0; $i < count( $rows ); $i++ ) {
            $actions[$i] = ActionFactory::CreateFromArray( $rows[$i] );
        }

        return $actions;
    }

    public function find( $id ) {
        $query = function() use ( $id ) {
            $statement = $this->connection->prepare( 
                'SELECT * FROM actions 
                WHERE id = :id' 
            );
            $statement->setFetchMode( PDO::FETCH_ASSOC );
            $statement->bindParam( ':id', $id, PDO::PARAM_INT );
            $statement->execute();
            return $statement->fetchAll();
        };

        $row = $this->tryToExecute( $query() );

        $action = null;
        if ( count( $row ) > 0 ) {
            $action = ActionFactory::CreateFromArray( $row[0] );
        }

        return $action;
    }

    public function create( $action ) {
        $query = function() use ( $action ) {
            $id = null;
            $statement = $this->connection->prepare( 
                'INSERT INTO actions (action, date) 
                VALUES (:action, :date)' 
            );
            $actionString = $action->getAction();
            $statement->bindParam( ':action', $actionString, PDO::PARAM_STR );
            $date = $action->getDate();
            $statement->bindParam( ':date', $date, PDO::PARAM_STR );
            if ( $statement->execute() ) {
                return $this->connection->lastInsertId();
            };
            return null;
        };

        $id = $this->tryToExecute( $query() );

        if ( $id ) {
            $action->setId( $id );
        } else {
            $action = null;
        }
        
        return $action;
    }

    private function tryToExecute( $function ) {
        try {
            return $function;
        } catch ( PDOException $e ) {
            throw new Exception( 'Caught exception: ' . $e->getMessage() );
        } finally {
            $this->connection = null;
        }
    }
}