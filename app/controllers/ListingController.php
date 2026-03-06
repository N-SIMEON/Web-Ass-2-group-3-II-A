<?php
/**
 * AgriStack — Listing Controller
 */
class ListingController {
    private Listing $model;
    private AuditLog $audit;

    public function __construct() {
        $this->model = new Listing();
        $this->audit = new AuditLog();
    }

    /** Public listing browse (buyers see approved only) */
    public function index(): void {
        requireAuth();
        $role     = $_SESSION['user_role'];
        $listings = ($role === 'farmer')
            ? $this->model->getByFarmer($_SESSION['user_id'])
            : $this->model->getAll('approved');
        require_once ROOT . '/app/views/listings/index.php';
    }

    public function show(): void {
        requireAuth();
        $id      = (int)($_GET['id'] ?? 0);
        $listing = $this->model->findById($id);
        if (!$listing) { flash('error','Listing not found.'); redirect('listings'); }
        require_once ROOT . '/app/views/listings/show.php';
    }

    public function create(): void {
        requireRole('farmer');
        require_once ROOT . '/app/views/listings/create.php';
    }

    public function store(): void {
        requireRole('farmer');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { redirect('listings','create'); }

        $data = [
            'farmer_id'    => $_SESSION['user_id'],
            'title'        => trim($_POST['title'] ?? ''),
            'variety'      => trim($_POST['variety'] ?? ''),
            'quantity_kg'  => (float)($_POST['quantity_kg'] ?? 0),
            'price_per_kg' => (float)($_POST['price_per_kg'] ?? 0),
            'pickup_sector'=> trim($_POST['pickup_sector'] ?? ''),
            'harvest_date' => $_POST['harvest_date'] ?? '',
            'expiry_date'  => $_POST['expiry_date'] ?? null,
            'description'  => trim($_POST['description'] ?? ''),
        ];

        if (!$data['title'] || !$data['variety'] || !$data['quantity_kg'] || !$data['price_per_kg'] || !$data['pickup_sector'] || !$data['harvest_date']) {
            flash('error','Please fill in all required fields.');
            redirect('listings','create');
        }

        $id = $this->model->create($data);
        if ($id) {
            $this->audit->log($_SESSION['user_id'], $_SESSION['user_name'],
                'Created listing', 'listing', $id, "Listing: {$data['title']}");
            flash('success', 'Listing submitted for admin approval.');
        } else {
            flash('error', 'Failed to create listing.');
        }
        redirect('listings');
    }

    public function edit(): void {
        requireRole('farmer');
        $id      = (int)($_GET['id'] ?? 0);
        $listing = $this->model->findById($id);
        if (!$listing || $listing['farmer_id'] != $_SESSION['user_id']) {
            flash('error','Listing not found or permission denied.');
            redirect('listings');
        }
        require_once ROOT . '/app/views/listings/edit.php';
    }

    public function update(): void {
        requireRole('farmer');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { redirect('listings'); }

        $id   = (int)($_POST['id'] ?? 0);
        $data = [
            'farmer_id'    => $_SESSION['user_id'],
            'title'        => trim($_POST['title'] ?? ''),
            'variety'      => trim($_POST['variety'] ?? ''),
            'quantity_kg'  => (float)($_POST['quantity_kg'] ?? 0),
            'price_per_kg' => (float)($_POST['price_per_kg'] ?? 0),
            'pickup_sector'=> trim($_POST['pickup_sector'] ?? ''),
            'harvest_date' => $_POST['harvest_date'] ?? '',
            'expiry_date'  => $_POST['expiry_date'] ?? null,
            'description'  => trim($_POST['description'] ?? ''),
        ];

        if ($this->model->update($id, $data)) {
            $this->audit->log($_SESSION['user_id'], $_SESSION['user_name'],
                'Updated listing', 'listing', $id);
            flash('success','Listing updated successfully.');
        } else {
            flash('error','Update failed.');
        }
        redirect('listings');
    }

    public function delete(): void {
        requireRole('farmer');
        $id = (int)($_GET['id'] ?? 0);
        if ($this->model->delete($id, $_SESSION['user_id'])) {
            $this->audit->log($_SESSION['user_id'], $_SESSION['user_name'],
                'Deleted listing', 'listing', $id);
            flash('success','Listing deleted.');
        } else {
            flash('error','Could not delete listing.');
        }
        redirect('listings');
    }
}
