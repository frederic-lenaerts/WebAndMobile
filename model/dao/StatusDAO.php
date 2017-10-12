<?php

namespace model\dao;

use \PDO;
use PDOException;
use model\factories\StatusFactory;
use model\interfaces\dao\IStatusDAO;
use config\DependencyInjector;

class StatusDAO implements IStatusDAO {

    public function __construct( PDO $connection = null) {
        if ( !isset( $connection ) )
            $connection = DependancyInjector::getContainer()['pdo'];

        $this->connection = $connection;
    }

    public function findAll() {
        try {
            $statement = $this->connection->prepare( 'SELECT * FROM status' );
            $statement->execute();
            $rows = $statement->fetchAll( PDO::FETCH_ASSOC );

            $status = array();

            for ( $i = 0; $i < count( $rows ); $i++ ) {
                $status[$i] = StatusFactory::CreateFromArray( $rows[$i] );
            }

            return $status;
        } catch ( PDOException $e ) {
            throw new Exception( 'Caught exception: ' . $e->getMessage() );
        } finally {
            $this->connection = null;
        }
    }

    public function find( $id ) {
        try {
            $statement = $this->connection->prepare( 'SELECT * FROM status WHERE id = :id' );
            $statement->setFetchMode( PDO::FETCH_ASSOC );
            $statement->bindParam( ':id', $id, PDO::PARAM_INT );
            $statement->execute();
            $row = $statement->fetchAll();

            if ( count( $row ) > 0 ) {
                return StatusFactory::CreateFromArray( $row[0] );
            } else {
                return null;
            }
        } catch ( PDOException $e ) {
            throw new Exception( 'Caught exception: ' . $e->getMessage() );
        } finally {
            $this->connection = null;
        }
    }

    public function create( $status ) {
        try {
            $statement = $this->connection->prepare( 'INSERT INTO locations (location_id, status, date) VALUES (:location_id, :status, :date)' );
            $locationId = $status->getLocationId();
            $statement->bindParam( ':location_id', $locationId, PDO::PARAM_STR );
            $statusInteger = $status->getStatus();
            $statement->bindParam( ':status', $statusInteger, PDO::PARAM_INT );
            $date = $status->getDate();
            $statement->bindParam( ':date', $date, PDO::PARAM_STR );
            $success = $statement->execute();

            if ( $success ) {
                $id = $this->connection->lastInsertId();
                $status->setId( $id );

                return $status;
            }
            
            return null;
        } catch ( PDOException $e ) {
            throw new Exception( 'Caught exception: ' . $e->getMessage() );
        } finally {
            $this->connection = null;
        }
    }
}