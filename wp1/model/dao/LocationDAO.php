<?php

namespace model\dao;

use \PDO;
use PDOException;
use util\Executor;
use model\Location;
use model\interfaces\dao\ILocationDAO;
use config\DependencyInjector;

class LocationDAO implements ILocationDAO {

    public function __construct( PDO $connection = null ) {
        if ( !isset( $connection ) )
            $connection = DependancyInjector::getContainer()['pdo'];

        $this->connection = $connection;
    }

    public function findAll() {
        $query = function() {
            $statement = $this->connection->prepare( 
                'SELECT *
                 FROM locations'
            );
            $statement->execute();
            return $statement->fetchAll( PDO::FETCH_ASSOC );
        };

        $rows = Executor::tryPDO( $query(), $this->connection );

        $locations = array();
        for ( $i = 0; $i < count( $rows ); $i++ ) {
            $locations[$i] = new Location( $rows[$i]["name"],
                                           $rows[$i]["id"] );
        } 

        return $locations;
    }

    public function find( $id ) {
        $query = function() use ( $id ) {
            $statement = $this->connection->prepare( 
                'SELECT *
                 FROM locations
                 WHERE id = :id'
            );
            $statement->setFetchMode( PDO::FETCH_ASSOC );
            $statement->bindParam( ':id', $id, PDO::PARAM_INT );
            $statement->execute();
            return $statement->fetchAll();
        };

        $row = Executor::tryPDO( $query(), $this->connection );

        if ( count( $row ) > 0 ) {
            return new Location( $row[0]["name"],
                                 $row[0]["id"] );
        } else {
            return null;
        }
    }

    public function create( $location ) {
        $query = function() use ( $location ) {
            $statement = $this->connection->prepare( 
                'INSERT INTO locations (name)
                 VALUES (:name)' 
            );
            $name = $location->getName();
            $statement->bindParam( ':name', $name, PDO::PARAM_STR );

            if ( $statement->execute() ) {
                return $this->connection->lastInsertId();
            } else {
                return null;
            }
        };

        $id = Executor::tryPDO( $query(), $this->connection );
        
        if ( $id ) {
            $location->setId( $id );
        } else {
            $location = null;
        }
        
        return $location;
    }
}