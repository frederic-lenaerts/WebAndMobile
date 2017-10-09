<?php

namespace model\repositories;

use \PDO;
use PDOException;
use model\interfaces\IStatusRepository;
use model\Technician;
use config\DependencyInjector;

class StatusRepository implements IStatusRepository {
    
    private $connection = null;

    public function __construct( PDO $connection ) {
        if ( !isset( $connection ) )
            $connection = DependancyInjector::getContainer()['pdo'];

        $this->connection = $connection;
    }

    public function findAll() {
        try {
            $statement = $this->connection->prepare( 'SELECT * FROM status' );
            $statement->execute();
            $status = $statement->fetch();

            if ( count( $status ) > 0 ) {
                $status = array();

                for ( $i = 0; $i < count( $status ); $i++ ) {
                    $status[] = new Status( $status[$i]['id'], $status[$i]['location_id'], $status[$i]['status'], $status[$i]['date'] );
                }

                return $status;
            } else {
                return null;
            }
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
            $status = $statement->fetch();

            if ( count( $status ) === 1 ) {
                return new Status( $status[0]['id'], $status[0]['location_id'], $status[0]['status'], $status[0]['date'] );
            } else {
                return null;
            }
        } catch ( PDOException $e ) {
            throw new Exception( 'Caught exception: ' . $e->getMessage() );
        } finally {
            $this->connection = null;
        }
    }

    public function create( $location_id, $status, $date ) {
        try {
            $statement = $this->connection->prepare( 'INSERT INTO status (location_id, status, date) VALUES (:location_id, :status, :date)' );
            $statement->bindParam( ':location_id', $location_id, \PDO::PARAM_INT );
            $statement->bindParam( ':status', $status, \PDO::PARAM_INT );
            $statement->bindParam( ':date', $date, \PDO::PARAM_INT );
            $statement->execute();

            $statement = $this->connection->prepare( 'SELECT * FROM events ORDER BY id DESC LIMIT 1' );
            $statement->execute();
            $results = $statement->fetch();

            if ( count( $status ) === 1 ) {
                return new Status( $status[0]['id'], $status[0]['location_id'], $status[0]['status'], $status[0]['date'] );
            } else {
                return null;
            }
        } catch ( PDOException $e ) {
            throw new Exception( 'Caught exception: ' . $e->getMessage() );
        } finally {
            $this->connection = null;
        }
    }

    public function update( $id, $location_id, $status, $date ) {
        try {
            $statement = $this->connection->prepare( 'INSERT INTO status (id, location_id, status, dat) VALUES (:location_id, :status, :date)' );
            $statement->bindParam( ':id', $id, \PDO::PARAM_INT );
            $statement->bindParam( ':location_id', $location_id, \PDO::PARAM_INT );
            $statement->bindParam( ':status', $status, \PDO::PARAM_INT );
            $statement->bindParam( ':date', $date, \PDO::PARAM_INT );
            $statement->execute();

            $statement = $this->connection->prepare( 'SELECT * FROM status WHERE id = :id' );
            $statement->setFetchMode( PDO::FETCH_ASSOC );
            $statement->bindParam( ':id', $id, PDO::PARAM_INT );
            $statement->execute();
            $row = $statement->fetch();

            if ( count( $status ) === 1 ) {
                return new Status( $status[0]['id'], $status[0]['location_id'], $status[0]['status'], $status[0]['date'] );
            } else {
                return null;
            }
        } catch ( PDOException $e ) {
            throw new Exception( 'Caught exception: ' . $e->getMessage() );
        } finally {
            $this->connection = null;
        }
    }

    public function delete( $id ) {
        try {
            $statement = $this->connection->prepare( 'DELETE FROM status WHERE id = :id' );
            $statement->setFetchMode( PDO::FETCH_ASSOC );
            $statement->bindParam( ':id', $id, \PDO::PARAM_INT );
            
            return $statement->execute();
        } catch ( PDOException $e ) {
            throw new Exception( 'Caught exception: ' . $e->getMessage() );
        } finally {
            $this->connection = null;
        }
    }
}