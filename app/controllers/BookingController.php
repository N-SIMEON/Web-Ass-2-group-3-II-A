<?php
/**
 * AgriStack — Booking Controller
 */
class BookingController {
    private Booking $model;
    private Listing $listingModel;
    private AuditLog $audit;

    public function __construct() {
        $this->model        = new Booking();
        $this->listingModel = new Listing();
        $this->audit        = new AuditLog();
    }

    public function index(): void {
        requireAuth();
        $role     = $_SESSION['user_role'];
        $bookings = ($role === 'buyer')
            ? $this->model->getByBuyer($_SESSION['user_id'])
            : $this->model->getAll();
        require_once ROOT . '/app/views/bookings/index.php';
    }

    public function create(): void {
        requireRole('buyer');
        $listingId = (int)($_GET['listing_id'] ?? 0);
        $listing   = $this->listingModel->findById($listingId);
        if (!$listing || $listing['status'] !== 'approved') {
            flash('error','Listing not available for booking.');
            redirect('listings');
        }
        require_once ROOT . '/app/views/bookings/create.php';
    }

    public function store(): void {
        requireRole('buyer');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { redirect('listings'); }

        $listingId = (int)($_POST['listing_id'] ?? 0);
        $listing   = $this->listingModel->findById($listingId);

        if (!$listing) { flash('error','Listing not found.'); redirect('listings'); }

        $qty   = (float)($_POST['qty_requested'] ?? 0);
        $price = (float)$listing['price_per_kg'];
        $total = $qty * $price;

        if ($qty <= 0 || $qty > $listing['quantity_kg']) {
            flash('error', 'Invalid quantity requested.');
            redirect('bookings', 'create&listing_id=' . $listingId);
        }

        $data = [
            'listing_id'      => $listingId,
            'buyer_id'        => $_SESSION['user_id'],
            'qty_requested'   => $qty,
            'total_value'     => $total,
            'delivery_address'=> trim($_POST['delivery_address'] ?? ''),
            'pickup_date'     => $_POST['pickup_date'] ?? '',
            'notes'           => trim($_POST['notes'] ?? ''),
        ];

        $id = $this->model->create($data);
        if ($id) {
            $this->audit->log($_SESSION['user_id'], $_SESSION['user_name'],
                'Placed booking', 'booking', $id,
                "Booked {$qty}kg of {$listing['title']} = {$total} RWF");
            flash('success','Booking request submitted. Await admin approval.');
        } else {
            flash('error','Failed to place booking.');
        }
        redirect('bookings');
    }

    public function cancel(): void {
        requireRole('buyer');
        $id = (int)($_GET['id'] ?? 0);
        if ($this->model->cancel($id, $_SESSION['user_id'])) {
            $this->audit->log($_SESSION['user_id'], $_SESSION['user_name'],
                'Cancelled booking', 'booking', $id);
            flash('success','Booking cancelled.');
        } else {
            flash('error','Cannot cancel this booking.');
        }
        redirect('bookings');
    }

    public function markCollected(): void {
        requireRole('buyer');
        $id      = (int)($_GET['id'] ?? 0);
        $booking = $this->model->findById($id);
        if ($booking && $booking['buyer_id'] == $_SESSION['user_id'] && $booking['status'] === 'approved') {
            $this->model->updateStatus($id, 'collected');
            $this->audit->log($_SESSION['user_id'], $_SESSION['user_name'],
                'Marked booking collected', 'booking', $id);
            flash('success','Booking marked as collected!');
        } else {
            flash('error','Cannot update this booking.');
        }
        redirect('bookings');
    }
}
