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
        try {
            $statement = $this->connection->prepare( 'SELECT * FROM actions' );
            $statement->execute();
            $rows = $statement->fetchAll( PDO::FETCH_ASSOC );

            $actions = array();

            for ( $i = 0; $i < count( $rows ); $i++ ) {
                $actions[$i] = ActionFactory::CreateFromArray( $rows[$i] );
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
                return ActionFactory::CreateFromArray( $row[0] );
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
            $actionString = $action->getAction();
            $statement->bindParam( ':action', $actionString, PDO::PARAM_STR );
            $date = $action->getDate();
            $statement->bindParam( ':date', $date, PDO::PARAM_STR );
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
}