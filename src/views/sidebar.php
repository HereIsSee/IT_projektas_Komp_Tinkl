<div class="sidenav col-sm-3">
    <h2>Logo</h2>
    <ul class="nav nav-pills nav-stacked">
        <li class="<?= ($activePage === 'dashboard') ? 'active' : '' ?>"><a href="dashboard.php">Dashboard</a></li>
        <li class="<?= ($activePage === 'messages') ? 'active' : '' ?>">
            <a href="messages.php">
                Žinutės 
                <?php if (!empty($_SESSION['has_unread_messages']) && $_SESSION['has_unread_messages'] == 1): ?>
                    <span>🔴</span>
                <?php endif; ?>
            </a>
        </li>
        <li class="<?= ($activePage === 'calendar') ? 'active' : '' ?>"><a href="calendar.php">Renginių kalendorius</a></li>
        <li class="<?= ($activePage === 'events') ? 'active' : '' ?>"><a href="all_events.php">Visi renginiai</a></li>
        <?php if ($_SESSION['vaidmuo'] === 'vip'): ?>
            <li class="<?= ($activePage === 'create_event') ? 'active' : '' ?>"><a href="create_event.php">Sukurti rengini</a></li>
        <?php endif; ?>
        <?php if ($_SESSION['vaidmuo'] === 'vartotojas'): ?>
            <li class="<?= ($activePage === 'subscription') ? 'active' : '' ?>"><a href="create_subscription.php">Sukurti norimų renginių prenumeratą</a></li>
        <?php endif; ?>
        
    </ul>
</div>
