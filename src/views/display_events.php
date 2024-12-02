<?php if (empty($events)): ?>
    <p>Renginių nerasta.</p>
<?php else: ?>
    <?php foreach ($events as $event): ?>
        <div class="event-card">
            <h3>
                <a href="event_page.php?id=<?= urlencode($event->getId()); ?>" style="color: inherit; text-decoration: none;">
                    <?= htmlspecialchars($event->getTitle()); ?>
                </a>
            </h3>
            <p><strong>Data:</strong> <?= htmlspecialchars($event->getDate()); ?></p>
            <p><strong>Renginio tipas:</strong> <?= htmlspecialchars($event->getEventType($dbc)); ?></p>
            <p><strong>Miestas:</strong> <?= htmlspecialchars($event->getCity($dbc)); ?></p>
            <p><strong>Mikrorajonas:</strong> <?= htmlspecialchars($event->getMicrocity($dbc) ?? '-------'); ?></p>
            <?php
            $socialGroups = Event::fetchEventSocialGroups($dbc, $event->getId());
            $groupNames = array_column($socialGroups, 'group_name');
            ?>
            <p><strong>Socialinės grupės:</strong> <?= htmlspecialchars(implode(', ', $groupNames)); ?></p>
        </div>
    <?php endforeach; ?>
<?php endif; ?>