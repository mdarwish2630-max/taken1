<?php
/**
 * Messages View
 * صفحة الرسائل
 */

?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title"><?= lang('messages') ?></h3>
        <span class="badge badge-info"><?= count($messages) ?> <?= lang('message') ?></span>
    </div>
    <div class="card-body">
        <?php if (!empty($messages)): ?>
        <div class="messages-list">
            <?php foreach ($messages as $message): ?>
            <div class="message-item <?= $message->is_read ? '' : 'unread' ?>" 
                 style="padding: 1rem; border-radius: 8px; margin-bottom: 1rem; background: <?= $message->is_read ? 'var(--light)' : '#fff' ?>; border: 1px solid var(--border); <?= !$message->is_read ? 'border-right: 4px solid var(--primary);' : '' ?>">
                
                <div class="message-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                    <div>
                        <strong><?= $message->name ?></strong>
                        <small style="color: var(--secondary); margin-<?= langDir() === 'rtl' ? 'right' : 'left' ?>: 0.5rem;">
                            <?= $message->email ?>
                        </small>
                    </div>
                    <small style="color: var(--secondary);">
                        <?= date('d/m/Y H:i', strtotime($message->created_at)) ?>
                    </small>
                </div>
                
                <?php if ($message->phone): ?>
                <div style="margin-bottom: 0.5rem;">
                    <i class="fas fa-phone" style="color: var(--primary);"></i>
                    <a href="tel:<?= $message->phone ?>"><?= $message->phone ?></a>
                </div>
                <?php endif; ?>
                
                <?php if ($message->subject): ?>
                <div style="font-weight: 600; margin-bottom: 0.5rem; color: var(--primary);">
                    <?= $message->subject ?>
                </div>
                <?php endif; ?>
                
                <div class="message-content" style="color: #555; line-height: 1.6;">
                    <?= nl2br($message->message) ?>
                </div>
                
                <div class="message-actions mt-3" style="display: flex; gap: 0.5rem;">
                    <a href="mailto:<?= $message->email ?>" class="btn btn-outline btn-sm">
                        <i class="fas fa-reply"></i> <?= lang('reply') ?>
                    </a>
                    <?php if (!$message->is_read): ?>
                    <button type="button" class="btn btn-success btn-sm"
                            onclick="markAsRead(<?= $message->id ?>)">
                        <i class="fas fa-check"></i> <?= lang('mark_read') ?>
                    </button>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="empty-state">
            <i class="fas fa-inbox" style="font-size: 3rem; color: var(--secondary); margin-bottom: 1rem;"></i>
            <p><?= lang('no_messages') ?></p>
        </div>
        <?php endif; ?>
    </div>
</div>

<script>
function markAsRead(id) {
    fetch('<?= url('/dashboard/messages/read/') ?>' + id, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' }
    }).then(() => location.reload());
}
</script>
