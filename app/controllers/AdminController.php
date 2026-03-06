<?php
/**
 * AgriStack — Admin Controller
 */
class AdminController {
    private Listing  $listingModel;
    private Booking  $bookingModel;
    private User     $userModel;
    private AuditLog $audit;

    public function __construct() {
        $this->listingModel = new Listing();
        $this->bookingModel = new Booking();
        $this->userModel    = new User();
        $this->audit        = new AuditLog();
    }

    public function dashboard(): void {
        $stats = [
            'today_listings'    => $this->listingModel->countToday(),
            'pending_listings'  => $this->listingModel->pendingCount(),
            'approved_listings' => $this->listingModel->totalApproved(),
            'pending_orders'    => $this->bookingModel->pendingCount(),
            'total_booked_value'=> $this->bookingModel->totalBookedValue(),
            'collected_orders'  => $this->bookingModel->countByStatus('collected'),
            'total_farmers'     => $this->userModel->countByRole('farmer'),
            'total_buyers'      => $this->userModel->countByRole('buyer'),
            'top_sectors'       => $this->listingModel->topPickupSectors(),
            'recent_audit'      => $this->audit->getRecent(5),
        ];
        require_once ROOT . '/app/views/admin/dashboard.php';
    }

    public function listings(): void {
        $listings = $this->listingModel->getAll();
        require_once ROOT . '/app/views/admin/listings.php';
    }

    public function approveListing(): void {
        $id = (int)($_GET['id'] ?? 0);
        if ($this->listingModel->updateStatus($id, 'approved', $_SESSION['user_id'])) {
            $listing = $this->listingModel->findById($id);
            $this->audit->log($_SESSION['user_id'], $_SESSION['user_name'],
                'Approved listing', 'listing', $id, "Listing: {$listing['title']}");
            flash('success','Listing approved and published.');
        } else {
            flash('error','Approval failed.');
        }
        redirect('admin','listings');
    }

    public function rejectListing(): void {
        $id   = (int)($_GET['id'] ?? 0);
        $note = trim($_POST['admin_note'] ?? 'Does not meet quality standards.');
        if ($this->listingModel->updateStatus($id, 'rejected', $_SESSION['user_id'], $note)) {
            $this->audit->log($_SESSION['user_id'], $_SESSION['user_name'],
                'Rejected listing', 'listing', $id, "Reason: {$note}");
            flash('success','Listing rejected.');
        } else {
            flash('error','Rejection failed.');
        }
        redirect('admin','listings');
    }

    public function orders(): void {
        $bookings = $this->bookingModel->getAll();
        require_once ROOT . '/app/views/admin/orders.php';
    }

    public function approveOrder(): void {
        $id = (int)($_GET['id'] ?? 0);
        if ($this->bookingModel->updateStatus($id, 'approved', $_SESSION['user_id'])) {
            $this->audit->log($_SESSION['user_id'], $_SESSION['user_name'],
                'Approved booking', 'booking', $id);
            flash('success','Order approved.');
        } else {
            flash('error','Approval failed.');
        }
        redirect('admin','orders');
    }

    public function users(): void {
        $users = $this->userModel->getAll();
        require_once ROOT . '/app/views/admin/users.php';
    }

    public function auditLog(): void {
        $logs  = $this->audit->getRecent(100);
        $count = $this->audit->count();
        require_once ROOT . '/app/views/admin/audit.php';
    }
}
