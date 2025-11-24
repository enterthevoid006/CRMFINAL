<?php
require_once __DIR__ . '/../Models/ContactsModel.php';

class ContactsController {
    private $model;

    public function __construct($conn) {
        $this->model = new ContactsModel($conn);
    }

    public function index() {
        // Recherche et filtres
        $search = $_GET['search'] ?? '';
        $statut = $_GET['statut'] ?? '';

        $contacts = $this->model->getContacts($search, $statut);
        require __DIR__ . '/../Views/contacts.view.php';
    }
}
