<?php
// CarController.php
require_once 'database.php';

class CAR {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Create a new car (with image)
    public function create($car_model, $plate_number, $car_type, $rental_rate, $status, $car_image) {
        $stmt = $this->pdo->prepare('INSERT INTO cars (car_model, plate_number, car_type, rental_rate, status, car_image) VALUES (?, ?, ?, ?, ?, ?)');
        return $stmt->execute([$car_model, $plate_number, $car_type, $rental_rate, $status, $car_image]);
    }

    // Read all cars
    public function getAll() {
        $stmt = $this->pdo->query('SELECT * FROM cars');
        return $stmt->fetchAll();
    }

    // Read a single car by ID
    public function getById($car_id) {
        $stmt = $this->pdo->prepare('SELECT * FROM cars WHERE car_id = ?');
        $stmt->execute([$car_id]);
        return $stmt->fetch();
    }

    // Update a car (with image)
    public function update($car_id, $car_model, $plate_number, $car_type, $rental_rate, $status, $car_image) {
        $stmt = $this->pdo->prepare('UPDATE cars SET car_model = ?, plate_number = ?, car_type = ?, rental_rate = ?, status = ?, car_image = ? WHERE car_id = ?');
        return $stmt->execute([$car_model, $plate_number, $car_type, $rental_rate, $status, $car_image, $car_id]);
    }

    // Delete a car
    public function delete($car_id) {
        $stmt = $this->pdo->prepare('DELETE FROM cars WHERE car_id = ?');
        return $stmt->execute([$car_id]);
    }
}
