<?php

namespace model\dao;

use \PDO;
use PDOException;
use model\factories\LocationFactory;
use model\interfaces\dao\ILocationDAO;
use config\DependencyInjector;

class LocationDAO implements ILocationDAO {

    public function __construct( PDO $connection = null ) {
        if ( !isset( $connection ) )
            $connection = DependancyInjector::getContainer()['pdo'];

        $this->connection = $connection;
    }

    public function findAll() {
        try {
            $statement = $this->connection->prepare( 'SELECT * FROM locations' );
            $statement->execute();
            $rows = $statement->fetchAll( PDO::FETCH_ASSOC );
            
            $locations = array();

            for ( $i = 0; $i < count( $rows ); $i++ ) {
                $locations[$i] = LocationFactory::CreateFromArray( $rows[$i] );
            } 

            return $locations;
        } catch ( PDOException $e ) {
            throw new Exception( 'Caught exception: ' . $e->getMessage() );
        } finally {
            $this->connection = null;
        }
    }

    public function find( $id ) {
        try {
            $statement = $this->connection->prepare( 'SELECT * FROM locations WHERE id = :id' );
            $statement->setFetchMode( PDO::FETCH_ASSOC );
            $statement->bindParam( ':id', $id, PDO::PARAM_INT );
            $statement->execute();
            $location = $statement->fetchAll();

            if ( count( $location ) > 0 ) {
                return LocationFactory::CreateFromArray( $location[0] );
            } else {
                return null;
            }
        } catch ( PDOException $e ) {
            throw new Exception( 'Caught exception: ' . $e->getMessage() );
        } finally {
            $this->connection = null;
        }
    }

    public function create( $location ) {
        try {
            $statement = $this->connection->prepare( 'INSERT INTO locations (name) VALUES (:name)' );
            $name = $location->getName();
            $statement->bindParam( ':name', $name, PDO::PARAM_STR );
            $success = $statement->execute();

            if ( $success ) {
                $id = $this->connection->lastInsertId();
                $location->setId( $id );

                return $location;
            }
            
            return null;
        } catch ( PDOException $e ) {
            throw new Exception( 'Caught exception: ' . $e->getMessage() );
        } finally {
            $this->connection = null;
        }
    }
}