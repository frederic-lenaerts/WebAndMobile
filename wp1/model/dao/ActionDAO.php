<?php

namespace model\dao;

use \PDO;
use PDOException;
use util\Executor;
use model\Action;
use model\Location;
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
                'SELECT a.id, a.date, a.action, a.location_id, l.name
                 FROM actions a
                 JOIN locations l ON a.location_id = l.id' 
            );
            $statement->execute();
            return $statement->fetchAll( PDO::FETCH_ASSOC );
        };

        $rows = Executor::tryPDO( $query(), $this->connection );

        $actions = array();
        for ( $i = 0; $i < count( $rows ); $i++ ) {
            $actions[$i] = new Action( $rows[$i]["action"],
                                       $rows[$i]["date"],
                                       new Location( $rows[$i]["name"],
                                                     $rows[$i]["location_id"] 
                                       ),
                                       $rows[$i]["id"] );
        }

        return $actions;
    }

    public function find( $id ) {
        $query = function() use ( $id ) {
            $statement = $this->connection->prepare( 
                'SELECT a.id, a.date, a.action, l.id location_id, l.name
                 FROM actions a
                 JOIN locations l ON a.location_id = l.id 
                 WHERE a.id = :id' 
            );
            $statement->setFetchMode( PDO::FETCH_ASSOC );
            $statement->bindParam( ':id', $id, PDO::PARAM_INT );
            $statement->execute();
            return $statement->fetchAll();
        };

        $row = Executor::tryPDO( $query(), $this->connection );

        $action = null;
        if ( count( $row ) > 0 ) {
            $action = new Action( $row[0]["action"],
                                  $row[0]["date"],
                                  new Location( $row[0]["name"],
                                                $row[0]["location_id"] 
                                  ),
                                  $row[0]["id"] 
            );
        }

        return $action;
    }

    public function create( $action ) {
        $query = function() use ( $action ) {
            $id = null;
            $statement = $this->connection->prepare( 
                'INSERT INTO actions (action, date, location_id) 
                 VALUES (:action, :date, :location_id)' 
            );
            $actionString = $action->getAction();
            $statement->bindParam( ':action', $actionString, PDO::PARAM_STR );
            $date = $action->getDate();
            $statement->bindParam( ':date', $date, PDO::PARAM_STR );
            $location_id = $action->getLocation()->getId();
            $statement->bindParam( ':location_id', $location_id, PDO::PARAM_INT );
            if ( $statement->execute() ) {
                return $this->connection->lastInsertId();
            };
            return null;
        };

        $id = Executor::tryPDO( $query(), $this->connection );

        if ( $id ) {
            $action->setId( $id );
        } else {
            $action = null;
        }
        
        return $action;
    }

}