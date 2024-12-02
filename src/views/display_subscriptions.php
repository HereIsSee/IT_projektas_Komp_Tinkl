<?php if (empty($event_selections)): ?>
    <p>Nerasta renginių pasirinkimo.</p>
<?php else: ?>
    <?php foreach ($event_selections as $selection_id => $selection): ?>
        <div class="event-selection-container">
            <h3>Prenumerata "<?= htmlspecialchars($selection['title']) ?>"</h3>
            <p><strong>Renginio miestas:</strong> <?= htmlspecialchars($selection['city']) ?></p>
            <p><strong>Renginio mikrorajonas:</strong> <?= htmlspecialchars($selection['microcity']) ?></p>
            <p><strong>Renginių tipai:</strong> <?= htmlspecialchars(implode(', ', $selection['event_types'])) ?></p>
            <p><strong>Socialinės grupės:</strong> <?= htmlspecialchars(implode(', ', $selection['social_groups'])) ?></p>
            <form action="" method="post" onsubmit="return confirm('Ar tikrai norite ištrinti šią prenumerata?');">
                <input type="hidden" name="delete_subscription" value="<?= $selection_id ?>">
                <button type="submit" class="btn btn-danger">Ištrinti prenumerata</button>
            </form>
        </div>        
    <?php endforeach; ?>
<?php endif; ?>