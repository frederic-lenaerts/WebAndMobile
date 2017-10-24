<?php

namespace model\dao;

use \PDO;
use PDOException;
use model\factories\TechnicianFactory;
use model\interfaces\dao\ITechnicianDAO;
use config\DependencyInjector;

class TechnicianDAO implements ITechnicianDAO {

    public function __construct( PDO $connection = null ) {
        if ( !isset( $connection ) )
            $connection = DependancyInjector::getContainer()['pdo'];

        $this->connection = $connection;
    }

    public function findAll() {
        try {
            $statement = $this->connection->prepare( 'SELECT * FROM technicians' );
            $statement->execute();
            $rows = $statement->fetchAll( PDO::FETCH_ASSOC );
            
            $technicians = array();

            for ( $i = 0; $i < count( $rows ); $i++ ) {
                $technicians[$i] = TechnicianFactory::CreateFromArray( $rows[$i]);
            } 

            return $technicians;
        } catch ( PDOException $e ) {
            throw new Exception( 'Caught exception: ' . $e->getMessage() );
        } finally {
            $this->connection = null;
        }
    }

    public function find( $id ) {
        try {
            $statement = $this->connection->prepare( 'SELECT * FROM technicians WHERE id = :id' );
            $statement->setFetchMode( PDO::FETCH_ASSOC );
            $statement->bindParam( ':id', $id, PDO::PARAM_INT );
            $statement->execute();
            $technician = $statement->fetchAll();

            if ( count( $technician ) > 0 ) {
                return TechnicianFactory::CreateFromArray( $technician[0] );
            } else {
                return null;
            }
        } catch ( PDOException $e ) {
            throw new Exception( 'Caught exception: ' . $e->getMessage() );
        } finally {
            $this->connection = null;
        }
    }

    public function create( $technician ) {
        try {
            $statement = $this->connection->prepare( 'INSERT INTO technicians (name, location_id) VALUES (:name, :location_id)' );
            $name = $technician->getName();
            $statement->bindParam( ':name', $name, PDO::PARAM_STR );
            $locationId = $technician->getLocationId();
            $statement->bindParam( ':location_id', $locationId, PDO::PARAM_INT );
            $success = $statement->execute();

            if ( $success ) {
                $id = $this->connection->lastInsertId();
                $technician->setId( $id );

                return $technician;
            }
            
            return null;
        } catch ( PDOException $e ) {
            throw new Exception( 'Caught exception: ' . $e->getMessage() );
        } finally {
            $this->connection = null;
        }
    }
}