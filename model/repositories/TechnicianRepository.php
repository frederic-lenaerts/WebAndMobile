<?php

namespace model\repositories;

use \PDO;
use PDOException;

class TechnicianRepository implements ITechnicianRepository {
    
    private $connection = null;

    public function __construct( PDO $connection ) {
        $this->connection = $connection;
    }

    public function getTechnicians() {
        try {
            $statement = $this->connection->prepare( 'SELECT * FROM technicians' );
            $statement->execute();
            $rows = $statement->fetch();

            if ( count( $rows ) > 0 ) {
                $technicians = array();

                for ( $i = 0; $i < count( $rows ); $i++ ) {
                    $technicians[] = new Event( $rows[$i]['id'], $rows[$i]['name'], $rows[$i]['location_id'] );
                }

                return $technicians;
            } else {
                return null;
            }
        } catch ( PDOException $e ) {
            throw new Exception( 'Caught exception: ' . $e->getMessage() );
        } finally {
            $connection = null;
        }
    }

    public function getTechnicianById( $id ) {
        try {
            $statement = $this->connection->prepare( 'SELECT * FROM technicians WHERE id = :id' );
            $statement->setFetchMode( PDO::FETCH_ASSOC );
            $statement->bindParam( ':id', $id, PDO::PARAM_INT );
            $statement->execute();
            $row = $statement->fetch();

            if ( count( $row ) === 1 ) {
                return new Technician( $row[0]['id'], $row[0]['name'], $row[0]['location_id'] );
            } else {
                return null;
            }
        } catch ( PDOException $e ) {
            throw new Exception( 'Caught exception: ' . $e->getMessage() );
        } finally {
            $connection = null;
        }
    }

    public function createTechnician( $name, $location_id ) {
        try {
            $statement = $this->connection->prepare( 'INSERT INTO technicians (name, location_id) VALUES (:name, :location_id)' );
            $statement->bindParam( ':name', $name, \PDO::PARAM_INT );
            $statement->bindParam( ':location_id', $location_id, \PDO::PARAM_INT );
            $statement->execute();

            $statement = $this->connection->prepare( 'SELECT * FROM events ORDER BY id DESC LIMIT 1' );
            $statement->execute();
            $results = $statement->fetch();

            if ( count( $row ) === 1 ) {
                return new Technician( $row[0]['id'], $row[0]['name'], $row[0]['location_id'] );
            } else {
                return null;
            }
        } catch ( PDOException $e ) {
            throw new Exception( 'Caught exception: ' . $e->getMessage() );
        } finally {
            $connection = null;
        }
    }

    public function updateTechnician( $id, $name, $location_id ) {
        try {
            $statement = $this->connection->prepare( 'INSERT INTO technicians (id, name, location_id) VALUES (:id, :name, :location_id)' );
            $statement->bindParam( ':id', $id, \PDO::PARAM_INT );
            $statement->bindParam( ':name', $name, \PDO::PARAM_INT );
            $statement->bindParam( ':location_id', $location_id, \PDO::PARAM_INT );
            $statement->execute();

            $statement = $this->connection->prepare( 'SELECT * FROM technicians WHERE id = :id' );
            $statement->setFetchMode( PDO::FETCH_ASSOC );
            $statement->bindParam( ':id', $id, PDO::PARAM_INT );
            $statement->execute();
            $row = $statement->fetch();

            if ( count( $row ) === 1 ) {
                return new Technician( $row[0]['id'], $row[0]['name'], $row[0]['location_id'] );
            } else {
                return null;
            }
        } catch ( PDOException $e ) {
            throw new Exception( 'Caught exception: ' . $e->getMessage() );
        } finally {
            $connection = null;
        }
    }

    public function deleteTechnician( $id ) {
        try {
            $statement = $this->connection->prepare( 'DELETE FROM technicians WHERE id = :id' );
            $statement->bindParam( ':id', $id, \PDO::PARAM_INT );
            $statement->execute();

            return 'Deleted';
        } catch ( PDOException $e ) {
            throw new Exception( 'Caught exception: ' . $e->getMessage() );
        } finally {
            $connection = null;
        }
    }
}